$("#form-account").validate({
    ignore: [],
    rules: {
        'name': {
            required: true,
        },
        'phone': {
            required: true,
            phone: true
        },
        'sex': {
            required: true
        },
    },
    messages: {
        'name': {
            required: 'Vui lòng nhập tên của bạn',
        },
        'phone': {
            required: 'Vui lòng nhập số điện thoại',
            phone: 'Số điện thoại không hợp lệ'
        },
        'sex': {
            required: 'Giới tính không hợp lệ'
        },
    }
});

$("#signup").validate({
    ignore: [],
    rules: {
        'name': {
            required: true,
        },
        'email': {
            required: true,
            email: true
        },
        'password': {
            required: true
        },
        'password_confirm': {
            required: true,
            equals: "#password"
        }
    },
    messages: {
        'name': {
            required: 'Thiếu họ và tên',
        },
        'email': {
            required: 'Thiếu email',
            email: 'Email không hợp lệ'
        },
        'password': {
            required: 'Thiếu mật khẩu'
        },
        'password_confirm': {
            required: 'Thiếu xác nhận mật khẩu',
            equals: "Mật khẩu mới không khớp"
        }
    }
});

$("#form-login").validate({
    ignore: [],
    rules: {
        'email': {
            required: true,
            email: true
        },
        'password': {
            required: true
        }
    },
    messages: {
        'email': {
            required: 'Thiếu email',
            email: 'Email không hợp lệ'
        },
        'password': {
            required: 'Thiếu mật khẩu'
        }
    }
});

$("#form-changepassword").validate({
    ignore: [],
    rules: {
        'old_password': {
            required: true,
            email: true
        },
        'new_password': {
            required: true,
            equals: "#password"
        },
        'password_confirm': {
            required: true,
            equals: "#password"
        }
    },
    messages: {
        'email': {
            required: 'Thiếu email',
            email: 'Email không hợp lệ'
        },
        'new_password': {
            required: 'Thiếu mật khẩu'
        },
        'password_confirm': {
            required: 'Thiếu xác nhận mật khẩu',
            equals: "Mật khẩu mới không khớp"
        }
    }
});