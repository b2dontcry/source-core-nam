(function (groupService, common) {
    "use strict";

    $('.btn-save').click(function (e) {
        e.preventDefault();
        const type = $(this).data('type');
        const form = $('#form-submit');
        groupService.create(form, type);
    });
    $('.btn-remove').on('click', function (e) {
        e.preventDefault();
        common.swalWarning("Bạn có chắc muốn xóa chứ?<br/>Bạn sẽ không thể hoàn tác!").then((result) => {
            if (result.value) {
                groupService.remove($(this).data('id'), 'index');
            }
        });
    });
    common.setDataTable($('#table-users'), {paging: false, info: false});
    common.setDataTable($('#table-permissions'), {paging: false, info: false});
    common.setSelectAll($('#select-all-user'), $('.select-all-user'));
    common.setSelectAll($('#select-all-permission'), $('.select-all-permission'));
})(require('../services/group_service.js'), require('../common.js'));
