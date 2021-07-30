let locale = $('#locale').val();
$("input[data-bootstrap-switch]").each(function () {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
});
module.exports = (function () {
    function serialize(form, append) {
        if (!form || form.nodeName !== "FORM") {
            return;
        }
        const object = {};
        (new FormData(form)).forEach(function (value, key) {
            if (!Reflect.has(object, key)) {
                object[key] = value;
                return;
            }
            if (!Array.isArray(object[key])) {
                object[key] = [object[key]];
            }
            object[key].push(value);
        });
        return Object.assign({}, object, append);
    }

    const sortTable = {
        init: function () {
            $('#form-filter').append('<input type="hidden" name="sort_" id="input_sort" />');
            sortTable.submitSort();
        },
        submitSort: function () {
            $('.pn-sort').click(function () {
                $('#input_sort').attr('name', 'sort_' + $(this).data('fields'));
                $('#input_sort').val($(this).data('order'));
                $('#form-filter').submit();
            })
        }
    }

    return {
        loading: function (state = true) {
            const loading = document.getElementById('loading')
            if (state) {
                loading.style.display = 'block'
            } else {
                loading.style.display = 'none'
            }
        },
        btnLoading: function (id, state = true) {
            const btn = document.getElementById(id)
            if (state) {
                btn.textContent += ' <span class="btn-loading"><span>'
            } else {
                const regex = / <span class="btn-loading"><\/span>/gi
                btn.textContent.replace(regex, '')
            }
        },
        sortTable: sortTable,
        swalQuestion: function (html) {
            return Swal.fire({
                html: html,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5e72e4',
                cancelButtonColor: '#f5365c',
                confirmButtonText: 'Có, đồng ý!',
                cancelButtonText: 'Không'
            });
        },
        swalWarning: function (html) {
            return Swal.fire({
                html: html,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5e72e4',
                cancelButtonColor: '#f5365c',
                confirmButtonText: 'Có, đồng ý!',
                cancelButtonText: 'Không'
            });
        },
        getData: function (from) {
            if (from === 'url' || !from) {} else {
                return serialize(document.querySelector(from));
            }
        },
        serialize: serialize,
        setSelectAll: function (selectAll, targets) {
            selectAll.on('click', function () {
                const status = $(this).prop('checked');
                targets.prop('checked', status);
            });
            targets.on('click', function () {
                if (targets.filter(':checked').length == targets.length) {
                    selectAll.prop('checked', true);
                } else {
                    selectAll.prop('checked', false);
                }
            });
        },
        setDataTable: function (targetTable, options = {}) {
            const configs = Object.assign({}, {
                language: {
                    url: '/static/vendor/datatable-' + locale + '.json'
                },
                search: true,
                paging: true,
                info: true,
                responsive: true,
                autoWidth: false,
                order: [[1, 'asc' ]],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 1, visible: false }
                ]
            }, options);
            return targetTable.DataTable(configs);
        },
        getLocale: function () {
            return locale;
        }
    };
})();
