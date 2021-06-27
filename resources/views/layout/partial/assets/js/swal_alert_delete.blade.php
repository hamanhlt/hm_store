@section('script_bottom')
    @parent
    <script>
        let label = $('.delete').data('label') ?? 'Xóa';
        function alertDelete(route) {
            Swal.fire({
                title: "Bạn có chắc chắn muốn " + label + " không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "OK"
            }).then(function (result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: route,
                        success: function (data) {
                            if (data.status === true) {
                                Swal.fire({
                                    title: label + " thành công!",
                                    timer: 1000,
                                    onOpen: function () {
                                        Swal.showLoading()
                                    }
                                }).then(function (result) {
                                    if (result.dismiss === "timer") {
                                        window.location = data.route
                                    }
                                })
                            } else {
                                Swal.fire("Có lỗi xảy ra trong quá trình gửi dữ liệu", "Thao tác lại hoặc liên hệ kỹ thuật để hỗ trợ!!", "question");
                            }
                        },
                        error: function () {
                            Swal.fire("Có lỗi xảy ra", "Thao tác lại hoặc liên hệ kỹ thuật để hỗ trợ!", "question");
                        }
                    });
                }
            });
        }
    </script>
@endsection
