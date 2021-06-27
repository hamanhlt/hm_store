@section('script_bottom')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.1/jquery.validate.min.js"></script>
    <script>
        var value = $("#password_reg").val();

        $.validator.addMethod("checklower", function (value) {
            return /[a-z]/.test(value);
        });
        $.validator.addMethod("checkupper", function (value) {
            return /[A-Z]/.test(value);
        });
        $.validator.addMethod("checkdigit", function (value) {
            return /[0-9]/.test(value);
        });
        $.validator.addMethod("checkusername", function (value) {
            var username = $("input[name=username]").val();
            if (value.includes(username)) {
                return false;
            }
            return true;
        });
        $.validator.addMethod("pwcheck", function (value) {
            return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) && /[a-z]/.test(value) && /\d/.test(value) && /[A-Z]/.test(value);
        });

        $('#kt_login_signin_form').validate({
            rules: {
                password: {
                    minlength: 8,
                    maxlength: 16,
                    required: true,
                    checkusername: true,
                    //pwcheck: true,
                    checklower: true,
                    checkupper: true,
                    checkdigit: true
                },
                password_confirmation: {
                    equalTo: "#password_reg",
                },
            },
            messages: {
                password: {
                    pwcheck: "Mật khẩu không đủ mạnh!",
                    checkusername: "Mật khẩu không được chứa Username",
                    required: "Mật khẩu không được bỏ trống",
                    minlength: "Mật khẩu phải ít nhất 8 ký tự!",
                    maxlength: "Mật khẩu không được vượt qua 16 ký tự!",
                    checklower: "Cần ít nhất 1 chữ cái viết thường!",
                    checkupper: "Cần ít nhất 1 chữ cái viết hoa!",
                    checkdigit: "Cần ít nhất 1 chữ số!"
                },
                password_confirmation: {
                    equalTo: "Mật khẩu nhập lại phải khớp với mật khẩu trên!",
                    required: "Mật khẩu nhập lại không được bỏ trống",
                },
            },
            highlight: function (element) {
                var id_attr = "#" + $(element).attr("id") + "1";
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                $(id_attr).removeClass('glyphicon-ok').addClass('glyphicon-remove');
                $('.help-block').css('display', '');
            },
            unhighlight: function (element) {
                var id_attr = "#" + $(element).attr("id") + "1";
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                $(id_attr).removeClass('glyphicon-remove').addClass('glyphicon-ok');
                $('#password_confirmation').attr('disabled', false);
            },
            errorElement: 'span',
            errorClass: 'validate_cus',
            errorPlacement: function (error, element) {
                x = element.length;
                if (element.length) {
                    error.insertAfter(element);
                } else {
                    error.insertAfter(element);
                }
            }

        });
    </script>
    <style>
        .validate_cus {
            color: red;
        }
    </style>
@endsection
