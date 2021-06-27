@section('script_bottom')
    @parent
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

    <script>
        function clickChosen() {
            $(".chosen-select").chosen({
                no_results_text: "Oops, nothing found!"
            });
        }

        clickChosen();

        $(document).on('click', '.add-region', function () {
            $(this).closest('.form-group').find('.choose-region').append($('.append-region').html());
            let stt = 0;
            $(".time-parent .list-time").each(function () {
                let stt_provinces = 0;
                $(this).find('.list-region').each(function () {
                    $(this).find('.provinces').attr('name', 'provinces[' + stt + '][' + stt_provinces + '][]');
                    $(this).find('.provincesPercents').attr('name', 'provincesPercents[' + stt + '][]');
                    stt_provinces++;
                });
                stt++;
            });
            clickChosen();
            $(".form-group .chosen-container-multi:nth-child(3)").remove();
        });

        $(document).on('click', '.close-region', function () {
            $(this).closest('.list-region').remove();
        });

        $(document).on('click', '.btn-filter-mobile', function () {
            let gender = $(this).closest('.list-time').find('.gender').val();
            let provinces = '';
            let check = true;
            let provincesPercents = '';
            $(this).closest('.list-time').find('.provinces').each(function () {
                provinces = provinces + $(this).val().toString() + ',';
            });
            $(this).closest('.list-time').find('.provincesPercents').each(function () {
                if ($(this).val() < 0 || $(this).val() > 100) {
                    check = false;
                } else {
                    provincesPercents = provincesPercents + $(this).val() + ',';
                }
            });
            let startAge = $(this).closest('.list-time').find('.startAge').val();
            let endAge = $(this).closest('.list-time').find('.endAge').val();
            if (startAge < 0 || endAge < 0) {
                return alert('Trường độ tuổi phải nhập giá trị từ 0-100');
            }
            let subscribeType = $(this).closest('.list-time').find('.subscribeType').val();
            let packageCode = $(this).closest('.list-time').find('.packageCode').val();
            let dateDay = $(this).closest('.list-time').find('.date-day').val();
            if (check === false) {
                return alert('Trường tỉ lệ phải nhập giá trị từ 0-100');
            }
            let $this = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '{{ route('campaigns.get.mobile') }}',
                type: 'post',
                dataType: 'json',
                data: {
                    gender: gender,
                    provinces: provinces,
                    provincesPercents: provincesPercents,
                    startAge: startAge,
                    endAge: endAge,
                    subscribeType: subscribeType,
                    packageCode: packageCode,
                    dateDay: dateDay,
                },
                error: function () {
                    alert('Lỗi');
                },
                success: function (data) {
                    if (data.success === true) {
                        $this.closest('.list-time').find('.sum-mobile').html(formatNumber(data.data));
                        $this.closest('.list-time').find('.input-sum-mobile').val(data.data);
                        $this.closest('.list-time').find('.file-name').val(data.fileName);
                    } else {
                        alert('Lỗi');
                    }
                },
            });
        });

        $(document).on('click', '.close-time', function () {
            $(this).closest('.list-time').remove();
        });

        dateRangePicker();

        $('input[name=audienceTypeCode]').on('click', function () {
            let taget = $(this).data('taget');
            let none = $(this).data('none');
            $('.' + taget).css('display', 'block');
            $('.' + none).css('display', 'none');
        });

        $(document).on('keyup', '.description', function () {
            $(this).closest('.label-description').find('.count-description').html($(this).val().length);
        });

        $(".description").each(function () {
            $(this).closest('.label-description').find('.count-description').html($(this).val().length);
        });

        $('.add-time').on('click', function () {
            $('.time-parent').append($('.append-time').html());
            let stt = 0;
            $(".time-parent .list-time").each(function () {
                let stt_provinces = 0;
                $(this).find('.list-region').each(function () {
                    $(this).find('.provinces').attr('name', 'provinces[' + stt + '][' + stt_provinces + '][]');
                    $(this).find('.provincesPercents').attr('name', 'provincesPercents[' + stt + '][]');
                    stt_provinces++;
                });
                console.log($(this));
                stt++;
            });

            dateRangePicker();

            clickChosen();
            $(".form-group .chosen-container-multi:nth-child(3)").remove();
        });

        $('#channels').on('change', function () {

            if ($(this).val() == 'IVR') {
                $('.channel-ivr').css("display", "block").addClass('check-ivr');
                $('.channel-sms').css("display", "none");
            } else {
                $('.channel-ivr').css("display", "none").removeClass('check-ivr');
                $('.channel-sms').css("display", "flex");
            }
        });

        $(document).on('change', '.inputfile', function (event) {
            let files = event.target.files;
            $(this).closest('.inputfile-box').find('.file-name').html($(this).val().split('\\').pop());
            $(this).closest('.inputfile-box').find('.input-file-name').val($(this).val().split('\\').pop());
            $(this).closest('.inputfile-box').find('.myAudio source').attr("src", URL.createObjectURL(files[0]));
            $(this).closest('.inputfile-box').find('.myAudio source').parent()[0].load();
        });

        $(document).on('click', '.remove-file-ivr', function () {
            $(this).closest('.inputfile-box').find('.inputfile').val('');
            $(this).closest('.inputfile-box').find('.file-name').html('');
            $(this).closest('.inputfile-box').find('.input-file-name').val('');
            $(this).closest('.inputfile-box').find('.myAudio source').attr("src", '');
            $(this).closest('.inputfile-box').find('.myAudio source').parent()[0].load();
        });

        $(document).on('click', '.close-branch', function () {
            $(this).closest('.list-branch').remove();
        });

        function selectCtkmRefresh() {
            $('.select-search-ctkm').select2({
                ajax: {
                    type: 'POST',
                    url: '{{ route('campaigns.suggest_ctkm') }}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            _token: '{{ csrf_token() }}',
                            name: params.term,
                        };
                    },
                    delay: 700,
                    cache: true,
                },
                minimumInputLength: 1,
                placeholder: "Nhập tên CTKM",
            });
        }

        selectCtkmRefresh();

        $(document).on('click', '.add-branch', function () {
            $('.select-search-ctkm').select2('destroy');
            $(this).closest('.channel-ivr').find('.parent-branch').append($('.append-branch').html());
            let stt = 0;
            $(".parent-branch .list-branch").each(function () {
                $(this).find('select[name="keypress[]"').attr('name', 'keypress[' + stt + ']');
                $(this).find('select[name="keypressTypeCode[]"').attr('name', 'keypressTypeCode[' + stt + ']');
                $(this).find('select[name="mtContent[]"').attr('name', 'mtContent[' + stt + ']');
                $(this).find('select[name="pakageRegisterCode[]"').attr('name', 'pakageRegisterCode[' + stt + ']');
                $(this).find('select[name="dealHuntCode[]"').attr('name', 'dealHuntCode[' + stt + ']');
                $(this).find('input[name="branch-ivr-file[]"').attr('name', 'branch-ivr-file[' + stt + ']');
                $(this).find('.inputfile-box .col-form-label').attr('for', 'file' + stt);
                $(this).find('.inputfile-box .inputfile').attr('id', 'file' + stt);
                stt++;
            });
            selectCtkmRefresh();
        });

        function checkBranch() {
            if ($(this).closest('.list-branch').find('.keypress-type-code option:selected').val() === 'ADVISORY_REGISTER') {
                $(this).closest('.list-branch').find('.mt-content').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.pakage-register').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.deal-hunt').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.file-ivr').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.inputfile').prop('disabled', false);
            } else if ($(this).closest('.list-branch').find('.keypress-type-code option:selected').val() === 'PACKAGE_REGISTER') {
                $(this).closest('.list-branch').find('.pakage-register').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.mt-content').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.deal-hunt').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.file-ivr').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.inputfile').prop('disabled', false);
            } else if ($(this).closest('.list-branch').find('.keypress-type-code option:selected').val() === 'DEAL_HUNT') {
                $(this).closest('.list-branch').find('.deal-hunt').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.mt-content').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.pakage-register').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.file-ivr').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.inputfile').prop('disabled', false);
            } else if ($(this).closest('.list-branch').find('.keypress-type-code option:selected').val() === 'LISTENT_AGAIN') {
                $(this).closest('.list-branch').find('.deal-hunt').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.mt-content').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.pakage-register').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.file-ivr').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.inputfile').prop('disabled', true);
            } else if ($(this).closest('.list-branch').find('.keypress-type-code option:selected').val() === 'CALL_REJECT') {
                $(this).closest('.list-branch').find('.deal-hunt').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.mt-content').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.pakage-register').removeClass('display-flex').addClass('display-none');
                $(this).closest('.list-branch').find('.file-ivr').removeClass('display-none').addClass('display-flex');
                $(this).closest('.list-branch').find('.inputfile').prop('disabled', false);
            }
        }

        $(document).on('change', '.keypress-type-code', checkBranch);
        $(document).ready(checkBranch);

        let check_file_ivr = false;
        $("#form-submit").submit(function (event) {
            let arrKeypress = [];
            let arrKeyTypeCode = [];
            $("#form-submit .check-ivr .keypress").each(function () {
                if ($(this).val() !== '') {
                    arrKeypress.push($(this).val());
                } else {
                    alert('Nhánh không được bỏ trống!');
                    event.preventDefault();
                    return false;
                }

            });

            $("#form-submit .check-ivr .keypress-type-code").each(function () {
                if ($(this).val() !== '') {
                    arrKeyTypeCode.push($(this).val());
                } else {
                    alert('Loại nhánh không được bỏ trống!');
                    event.preventDefault();
                    return false;
                }

            });

            if ($('#channels option:selected').val() === 'IVR' && !check_file_ivr) {
                alert('File IVR không được bỏ trống!');
                event.preventDefault();
                return false;
            }

            if (!unique(arrKeypress)) {
                alert('Nhánh không được trùng nhau!');
                event.preventDefault();
                return false;
            } else if (!unique(arrKeyTypeCode)) {
                alert('Loại nhánh không được trùng nhau!');
                event.preventDefault();
                return false;
            } else if ($('#form-submit .check-ivr .display-flex .package-register-code').val() === '') {
                alert('Gói đăng ký không được bỏ trống!');
                event.preventDefault();
                return false;
            } else if ($('#form-submit .check-ivr .display-flex .select-search-ctkm').val() === '') {
                alert('Tên CTKM không được bỏ trống!');
                event.preventDefault();
                return false;
            } else if ($('#form-submit .startTime').val() === '') {
                alert('Ngày bắt đầu/Ngày kết thúc không được bỏ trống!');
                event.preventDefault();
                return false;
            }
        });

        function unique(arr) {
            let obj = {};
            let newArr = [];
            let check = true;
            for (let i = 0; i < arr.length; i++) {
                if (!obj[arr[i]]) {
                    obj[arr[i]] = 1;
                    newArr.push(arr[i])
                } else {
                    check = false;
                }
            }
            return check
        }

        function dateRangePicker() {
            $('.date-range-picker').daterangepicker({
                buttonClasses: ' btn',
                applyClass: 'btn-primary',
                cancelClass: 'btn-secondary',

                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                timePickerSeconds: true,
                locale: {
                    format: 'DD-MM-YYYY HH:mm:ss'
                }
            });

            $('.date-range-picker').on('apply.daterangepicker', function (ev, picker) {
                $(this).find('.form-control').val(picker.startDate.format('DD-MM-YYYY HH:mm:ss') + ' / ' + picker.endDate.format('DD-MM-YYYY HH:mm:ss'));
            });
        }

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
@endsection
