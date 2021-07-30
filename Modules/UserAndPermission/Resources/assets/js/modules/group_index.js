(function (groupService, common) {
    "use strict";

    common.sortTable.init();

    $('.btn-remove').on('click', function (e) {
        e.preventDefault();
        common.swalWarning("Bạn có chắc muốn xóa chứ?<br/>Bạn sẽ không thể hoàn tác!").then((result) => {
            if (result.value) {
                groupService.remove($(this).data('id'), 'reload');
            }
        });
    });
})(require('../services/group_service.js'), require('../common.js'));
