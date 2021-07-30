(function () {
    "use strict";

    $('.btn-detail').click(function () {
        const id = $(this).data('id');
        $.ajax({
            url: '/dashboard_admin_23644466/history' + '/' + id,
            method: 'GET',
            dataType: 'HTML',
            success: function (res) {
                $('#modal-result').html(res).find('#m_history_detail').modal();
            }
        });
    });
})();
