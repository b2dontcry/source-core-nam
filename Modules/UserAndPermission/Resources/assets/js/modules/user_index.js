(function (userService, common) {
    "use strict";

    common.sortTable.init();

    $('.active-item').on('switchChange.bootstrapSwitch', function (event) {
        userService.activeUser($(this).data('id'), event.target.checked, $(this));
    });
    $('.btn-restore').on('click', function (e) {
        e.preventDefault();
        common.swalQuestion("Bạn có chắc muốn khôi phục chứ?").then((result) => {
            if (result.value) {
                userService.restore($(this).data('id'), 'reload');
            }
        });
    });
    $('.btn-remove').on('click', function (e) {
        e.preventDefault();
        common.swalWarning("Bạn có chắc muốn xóa chứ?<br/>Bạn sẽ không thể hoàn tác!").then((result) => {
            if (result.value) {
                userService.remove($(this).data('id'), 'reload');
            }
        });
    });
    $('.btn-destroy').on('click', function (e) {
        e.preventDefault();
        common.swalWarning("Bạn có chắc muốn tiêu hủy chứ?<br />Bạn sẽ không thể khôi phục lại!").then((result) => {
            if (result.value) {
                userService.destroy($(this).data('id'));
            }
        });
    });
})(require('../services/user_service.js'), require('../common.js'));
