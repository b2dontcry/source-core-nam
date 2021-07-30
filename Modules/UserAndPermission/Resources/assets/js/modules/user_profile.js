(function (userService, common) {
    "use strict";

    $('.btn-edit').on('click', function (e) {
        e.preventDefault();
        $('.input-edit').removeAttr('readonly');
        $('.btn-save').removeClass('d-none');
        $('.btn-cancel').removeClass('d-none');
        $(this).addClass('d-none');
    });
    $('.btn-cancel').on('click', function (e) {
        e.preventDefault();
        $('.btn-save').addClass('d-none');
        $(this).addClass('d-none');
        $('.btn-edit').removeClass('d-none');
        $('.input-edit').attr('readonly', 'readonly');
    });
    $('.btn-save').on('click', function (e) {
        e.preventDefault();
        const data = common.getData('#form-profile');
        const _this = $(this);
        userService.updateProfile(data, function (res) {
            if (res.status === 200) {
                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
            _this.addClass('d-none');
            $('.btn-cancel').addClass('d-none');
            $('.btn-edit').removeClass('d-none');
            $('.input-edit').attr('readonly', 'readonly');
        });
    });
})(require('../services/user_service.js'), require('../common.js'));
