(function (userService, common) {
    "use strict";

    $('.btn-save').click(function (e) {
        e.preventDefault();
        const type = $(this).data('type');
        const form = $('#form-submit');
        if ($('#user_id').length) {
            userService.update(form, type, $('#user_id').val());
        }
        return false;
    });
    $('.btn-remove').on('click', function (e) {
        e.preventDefault();
        common.swalWarning("Bạn có chắc muốn xóa chứ?<br/>Bạn sẽ không thể hoàn tác!").then((result) => {
            if (result.value) {
                userService.remove($(this).data('id'), 'index');
            }
        });
    });
    common.setDataTable($('#table-groups'), {paging: false, info: false});
    common.setDataTable($('#table-permissions'), {paging: false, info: false});
    common.setSelectAll($('#select-all-group'), $('.select-all-group'));
    common.setSelectAll($('#select-all-permission'), $('.select-all-permission'));
})(require('../services/user_service.js'), require('../common.js'));