module.exports = (function () {
    "use strict";
    const _url = '/dashboard_admin_23644466/group';
    return {
        create: function (form, type) {
            $.ajax({
                url: _url,
                method: 'POST',
                data: form.serialize() + '&type_submit=' + type,
                success: function (res) {
                    if (res.status >= 200 && res.status < 300) {
                        Swal.fire(
                            res.message, '', 'success'
                        ).then(function () {
                            window.location.href = res.data;
                        });
                    } else {
                        Swal.fire(
                            res.message, '', 'error'
                        );
                    }
                }
            });
        },
        update: function (form, type, id) {
            $.ajax({
                url: `${_url}/${id}`,
                method: 'PUT',
                data: form.serialize() + '&type_submit=' + type,
                success: function (res) {
                    if (res.status === 200) {
                        Swal.fire(
                            res.message, '', 'success'
                        ).then(function () {
                            window.location.href = res.data;
                        });
                    } else {
                        Swal.fire(
                            res.message, '', 'error'
                        );
                    }
                }
            });
        },
        remove: function (id, action) {
            $.ajax({
                url: `${_url}/${id}`,
                method: 'DELETE',
                dataType: 'JSON',
                success: function (res) {
                    if (res.status === 200) {
                        Swal.fire(`${res.message}`, '', 'success').then(function () {
                            if (action === 'reload') {
                                location.reload();
                            } else if (action === 'index') {
                                location.href = group.url
                            } else {
                                location.href = action
                            }
                        });
                    } else {
                        Swal.fire(`${res.message}`, '', 'error');
                    }
                }
            });
        }
    };
})();