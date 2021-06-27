@section('script_bottom')
    @parent
    <link href="https://releases.transloadit.com/uppy/v1.22.0/uppy.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://releases.transloadit.com/uppy/v1.18.0/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/locales/v1.16.9/vi_VN.min.js"></script>
    <script>
        let KTUppy = function () {
            const Dashboard = Uppy.Dashboard;
            const ImageEditor = Uppy.ImageEditor;
            let headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            };
            let initUppy = function (nameInput, fileSize, numberOfFile, type = []) {
                let targetSelector = '#' + nameInput;
                if ( $(targetSelector).length === 0) {// if not exist dom return
                    return;
                }
                let uppyCore = Uppy.Core({
                    autoProceed: false,
                    locale: Uppy.locales.vi_VN,
                    restrictions: {
                        maxFileSize: 1024 * fileSize, // 1kb * fileSize
                        maxNumberOfFiles: numberOfFile,
                        minNumberOfFiles: 1,
                        allowedFileTypes: type
                    },
                    debug: false,
                });

                uppyCore.use(Dashboard, {
                    trigger: targetSelector + ' .UppyModalOpenerBtn',
                    inline: false,
                    target: targetSelector + " .uppy-container",
                    replaceTargetContent: true,
                    showProgressDetails: true,
                    browserBackButtonClose: true,
                    note: `Số file tối đa được tải lên: ${numberOfFile}, dung lượng tối đa mỗi file ${fileSize / 1000} MB`,
                    height: 460,
                    width: 1000,
                    metaFields: [
                        {id: 'name', name: 'Tên tập', placeholder: 'Nhập tên tập tin muốn thay đổi'}
                    ],
                });
                //set File default by callback function addFile()
                if (!_.isEmpty(dataFiles[nameInput])) {
                    _.forEach(JSON.parse(dataFiles[nameInput]), function (fileObj) {
                        fetch(new Request(fileObj.url))
                            .then(response => response.blob())
                            .then(function (myBlob) {
                                let idAdded = uppyCore.addFile({
                                    name: fileObj.name,
                                    type: fileObj.mime,
                                    data: myBlob
                                });
                                $(targetSelector + ' .uppy-thumbnails').append(showThumb(nameInput, idAdded, fileObj, 'init-upload'));
                            });
                    });
                }
                uppyCore.use(ImageEditor, {target: Dashboard});
                uppyCore.use(Uppy.XHRUpload, {
                    endpoint: '{{route('system.file.apiUpload')}}',
                    withCredentials: true,
                    fieldName: 'file',
                    headers: headers,
                });
                uppyCore.on('complete', function (file) {
                    let imagePreview = "";
                    $(targetSelector + ' .uppy-thumbnails .uppy-thumbnail-container.init-upload').remove();//reset form after up file
                    $.each(file.successful, function (index, value) {
                        uppyCore.setFileMeta( value.id, { name: value.response.body.name })
                        imagePreview = showThumb(nameInput, value.id, value.response.body, 'new-upload')
                        $(targetSelector + ' .uppy-thumbnails').append(imagePreview);
                    });
                });
                uppyCore.on('file-removed', (file, reason) => {
                    $(targetSelector + ' .uppy-thumbnail-container[data-id="' + file.id + '"').remove();//trigger remove input of file
                    check_file_ivr = false;
                });
                $(document).on('click', targetSelector + ' .uppy-thumbnails .uppy-remove-thumbnail', function () {
                    let imageId = $(this).attr('data-id');
                    uppyCore.removeFile(imageId);//trigger remove file in dashboard
                    $(targetSelector + ' .uppy-thumbnail-container[data-id="' + imageId + '"').remove();
                });

                function showThumb(nameInput, id, fileObj, className) {
                    let thumbnail = "";
                    if (/image/.test(fileObj.mime)) {
                        thumbnail = '<div class="uppy-thumbnail"><img src=\'' + fileObj.url + '\'/></div>';
                    }
                    if (fileObj.mime === 'audio/wav') {
                        check_file_ivr = true;
                    }
                    let input = '<input type="hidden" class="file-hidden " name="files[' + nameInput + '][]" value=\'' + JSON.stringify(fileObj) + ' \'>';
                    let btnDel = '<span data-id="' + id + '" class="uppy-remove-thumbnail"><i class="flaticon2-cancel-music"></i></span>'
                    return '<div class="uppy-thumbnail-container bg-hover-primary-o-6  ' + className + '" data-id="' + id + '">' + thumbnail + input + ' <a href="'+ fileObj.url +'" target="_blank" class="uppy-thumbnail-label">' + fileObj.name + formatFileSize(fileObj.size) + '</a>' + btnDel + '</div>';
                }

                //format file size (Ex: 5,4 MB)
                function formatFileSize(size) {
                    let sizeLabel = "bytes";
                    if (size > 1024) {
                        size = size / 1024;
                        sizeLabel = "kb";
                        if (size > 1024) {
                            size = size / 1024;
                            sizeLabel = "MB";
                        }
                    }
                    return ` ( ${Math.round(size, 2)}  ${sizeLabel} )`;
                }
            }
            return {
                init: function () {
                    initUppy('audio', 20 * 1000, 1, ['audio/wav']);
                    initUppy('file', 20 * 1000, 1, ['text/plain', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']);
                },
            };
        }();
        KTUppy.init();
    </script>
@endsection
