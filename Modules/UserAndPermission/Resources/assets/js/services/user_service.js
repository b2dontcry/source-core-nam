module.exports = (function () {
    "use strict";
    const _url = '/dashboard_admin_23644466/user';
    return {
        activeUser: function (id, status, element) {
            $.ajax({
                url: `${_url}/${id}`,
                method: 'PATCH',
                dataType: 'JSON',
                data: {
                    is_active: status ? 1 : 0
                },
                success: function (res) {
                    if (res.status === 200) {
                        toastr.success(res.message);
                    } else {
                        toastr.error(res.message);
                        element.prop('checked', !status);
                    }
                },
                error: function (request) {
                    element.prop('checked', !status);
                    Swal.fire(`${request.status}`, `${request.statusText}`, 'error');
                }
            });
        },
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
                        Swal.fire(res.message, '', 'success').then(function () {
                            window.location.href = res.data;
                        });
                    } else {
                        Swal.fire(res.message, '', 'error');
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
                                location.href = _url
                            } else {
                                location.href = action
                            }
                        });
                    } else {
                        Swal.fire(`${res.message}`, '', 'error');
                    }
                }
            });
        },
        restore: function (id, action) {
            $.ajax({
                url: `${_url}/${id}/restore`,
                method: 'PATCH',
                success: function (res) {
                    if (res.status === 200) {
                        Swal.fire(`${res.message}`, '', 'success').then(function () {
                            if (action === 'reload') {
                                location.reload();
                            } else if (action === 'index') {
                                location.href = _url;
                            } else {
                                location.href = action;
                            }
                        });
                    } else {
                        Swal.fire(`${res.message}`, '', 'error');
                    }
                }
            });
        },
        destroy: function (id, action) {
            $.ajax({
                url: `${_url}/${id}/delete`,
                method: 'DELETE',
                success: function (res) {
                    if (res.status === 200) {
                        Swal.fire(`${res.message}`, '', 'success').then(() => {
                            if (action === 'reload') {
                                location.reload();
                            } else if (action === 'index') {
                                location.href = _url;
                            } else {
                                location.href = action;
                            }
                        });
                    } else {
                        Swal.fire(`${res.message}`, '', 'error');
                    }
                }
            });
        },
        updateProfile: function (data, callback) {
            $.ajax({
                url: `${_url}/profile`,
                method: 'POST',
                dataType: 'JSON',
                data: data,
                success: function (res) {
                    callback(res);
                }
            });
        }
    };
})();
