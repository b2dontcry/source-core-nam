// jQuery
window.$ = window.jQuery = require('jquery');
// jQuery validation
require('jquery-validation/dist/jquery.validate.min.js');
require('jquery-validation/dist/localization/messages_vi.js');
// Bootstrap 4
require('bootstrap/dist/js/bootstrap.bundle.min.js');
require('bootstrap-switch/dist/js/bootstrap-switch.min.js');
// Select2
require('select2/dist/js/select2.full.min.js');
// DataTable
require('admin-lte/plugins/datatables/jquery.dataTables.min.js');
require('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');
require('admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js');
require('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');
// Sweet Alert
window.Swal = require('sweetalert2/dist/sweetalert2.all.min.js');
// Toastr
window.toastr = require('toastr');
toastr.options = {
    positionClass: "toast-bottom-right",
    timeOut: 3000
};
// Admin LTE
require('admin-lte/dist/js/adminlte.js');

// Common
const common = require('./common.js');

// Configs
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function () {
        common.loading();
    },
    error: function (request) {
        if (request.status === 422) {
            const res = request.responseJSON.errors;
            if ($('#form-submit').length > 0) {
                $('#form-submit').validate({
                    errorElement: 'label',
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                }).showErrors(res);
            } else {
                let mess = '';
                Object.getOwnPropertyNames(res).forEach(function (value) {
                    mess += res[value][0] + '<br/>';
                });
                Swal.fire(mess, '', 'error');
            }
        } else {
            Swal.fire(`${request.status}`, `${request.statusText}`, 'error');
        }
    },
    complete: function () {
        common.loading(false);
    }
});
