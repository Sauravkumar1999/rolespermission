@extends('layouts.dashboard')
@push('header')
    <title>Users</title>
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-bs5/datatables.bootstrap5.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-bs5/editor-modal-right.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/libs/datatables/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dt-editor/css/editor.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        div.DTE div.editor_upload div.cell {
            width: 60%;
        }

        .password-field {
            width: 60%;
            display: inline-block;
            margin-right: 25px;
        }

        .DTE_Field_Name_status .DTE_Field_InputControl div {
            display: flex !important;
            padding-right: 10px;
        }

        .DTE_Field_Name_status .DTE_Field_InputControl div label {
            margin-left: 5px;
        }
    </style>
@endpush
@section('main-section')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body px-0">
                    {!! $dataTable->table(['class' => 'table']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-permission" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modal-permissionTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-permissionTitleId">Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex mb-4 align-items-center" id="permission-user-info">
                        <div class="flex-shrink-0">
                            <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-sm rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="card-title mb-1">Oliver Phillips</h5>
                            <p class="text-muted mb-0">Digital Marketing</p>
                        </div>
                    </div>
                    <div class="row"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-id=""
                        id="submit-permission"><span>Save</span></button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer')
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/libs/datatables/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/forms-editors.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables/dt-editor/js/dataTables.editor.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables/dt-editor/js/editor.bootstrap5.min.js') }}">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            let tableEditor = window.LaravelDataTables["{!! $dataTable->getTableAttribute('id') !!}-editor"];
            let table = window.LaravelDataTables['{!! $dataTable->getTableAttribute('id') !!}'];

            Datatablenotifications(tableEditor, 'create', 'Data created successfully');
            Datatablenotifications(tableEditor, 'edit', 'Data Updated successfully');
            Datatablenotifications(tableEditor, 'remove', 'Data Deleted successfully');

            let filterContainer = $('#{!! $dataTable->getTableAttribute('id') !!}_filter');
            filterContainer.addClass('d-flex');
            $(`<select class="form-select mx-2">
                        <option>Select Status</option>
                        <option value="Approve">Approve</option>
                        <option value="Waiting">Waiting</option>
                    </select>`).appendTo(filterContainer)
                .on('change', function(e) {
                    let val = $(this).val();
                    table.column(1).search(val).draw();
                });
            $(`<select class="form-select mx-2">
                        <option value="all roles">Select Roles</option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>`).appendTo(filterContainer)
                .on('change', function(e) {
                    let val = $(this).val();
                    table.column(4).search(val).draw();
                });

            table.on('click', 'button.editor-delete', function(e) {
                e.preventDefault();
                tableEditor.remove(e.target.closest('tr'), {
                    title: 'Delete this data',
                    message: 'Sure to delete this data',
                    buttons: [{
                            text: "{{ trans('general.close') }}",
                            className: 'btn btn-secondary',
                            action: function() {
                                tableEditor.close();
                            }
                        },
                        {
                            text: "{{ trans('general.confirm') }}",
                            className: 'btn btn-danger',
                            action: function() {
                                tableEditor.submit();
                            }
                        }
                    ],
                });
            });

            table.on('click', 'button.editor-edit', function(e) {
                var tdElements = e.target.closest('tr');
                tableEditor.edit(tdElements, {
                    title: 'User Update',
                    buttons: [{
                            text: "{{ trans('general.close') }}",
                            className: 'btn btn-secondary',
                            action: function() {
                                tableEditor.close();
                            }
                        },
                        {
                            text: "{{ trans('general.confirm') }}",
                            className: 'btn btn-danger',
                            action: function() {
                                tableEditor.submit();
                            }
                        }
                    ],
                });
            });

            table.on('click', 'button.editor-permission', function(e) {
                let tdElements = $(e.target).closest('tr');
                $('#permission-user-info img').attr('src', tdElements.find('td:eq(5)').find('img').attr('src'));
                $('#permission-user-info h5').html(tdElements.find('td:eq(2)').text().trim());
                $('#permission-user-info p').html(tdElements.find('td:eq(1)').html());

                let userId = $(this).data('id');
                let url = "{{ route('permission.all', ':id') }}";
                url = url.replace(':id', userId);
                $('#modal-permission').modal('show');
                $('#modal-permission .modal-body .row').html('');
                fetch(url, {
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        generateHtmlPermission(data.data);
                        $('#modal-permission #submit-permission').data('id', userId);
                    })
                    .catch(error => {
                        console.error('Error fetching permissions:', error);
                    });
            });

            tableEditor.on('initEdit', function(e, node, data) {
                setTimeout(() => {
                    $('.DTE_Field_Name_status .DTE_Field_InputControl div input[name="status"]')
                        .each(function() {
                            if ($(this).val() == data.hidden_status) {
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });
                        $('.DTE_Field_Name_role .DTE_Field_InputControl select').val(data.hidden_role).change();
                }, 100);
            });

            $(document).on('click', '#copy_pwd', function() {
                const copyText = $(this).data('password');
                navigator.clipboard.writeText(copyText);

                const titleText = document.documentElement.lang === 'ko' ? '복사됨' : 'Copied';

                $(this).tooltip('dispose').tooltip({
                    title: titleText,
                    placement: 'top',
                    trigger: 'manual'
                }).tooltip('show');

                setTimeout(() => $(this).tooltip('hide'), 1000);
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('#copy_pwd').length) {
                    $('#copy_pwd').tooltip('hide');
                }
            });

            $(document).on('click', '#generate_pwd', function() {
                const password = makeRandomPass(10);
                $('#password').val(password);
                $('#copy_pwd').attr({
                    'data-password': password,
                    'data-toggle': 'tooltip',
                    'data-placement': 'top',
                    'title': document.documentElement.lang === 'ko' ? '복사됨' : 'Copy'
                });
            });
            // $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        function generateHtmlPermission(groupedPermissions) {
            let htmlOutput = '';
            for (const group in groupedPermissions) {
                const perms = groupedPermissions[group];
                htmlOutput += '<div class="col-md-4 px-1">';
                htmlOutput += '<div class="card">';
                htmlOutput += '<div class="card-header py-2">';
                htmlOutput += '<h4 class="card-title mb-0 flex-grow-1">' + group.charAt(0).toUpperCase() + group.slice(1) +
                    '</h4>';
                htmlOutput += '</div>';
                htmlOutput += '<div class="card-body p-0">';
                htmlOutput += '<div class="list-group">';
                perms.forEach(permission => {
                    htmlOutput += '<label class="list-group-item">';
                    htmlOutput += '<input class="form-check-input me-1" data-permission-id="' + permission.id +
                        '" type="checkbox" value=""' + (permission.status ?
                            'checked' : '') + '>' + (permission.display_name ?? permission.name);
                    htmlOutput += '</label>';
                });
                htmlOutput += '</div>';
                htmlOutput += '</div>'; // end card-body
                htmlOutput += '</div>'; // end card
                htmlOutput += '</div>'; // end col-md-4
            }
            if ($('#modal-permission .modal-body .row').html(htmlOutput)) {
                $('#submit-permission').off('click').click(function(e) {
                    let userId = $(this).data('id');
                    e.preventDefault();
                    $(this).html(`<span class="d-flex align-items-center">
                            <span class="flex-grow-1 me-2">Loading...</span>
                            <span class="spinner-border flex-shrink-0" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </span>
                        </span>`);

                    let data = [];
                    $('input[data-permission-id]').each(function() {
                        var permissionId = $(this).data('permission-id');
                        var isChecked = $(this).prop('checked');
                        data.push({
                            permissionId,
                            isChecked
                        })
                    });
                    let url = "{{ route('permission.update', ':id') }}";
                    url = url.replace(':id', userId);
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(responseData => {
                            if (responseData.status) {
                                $('#modal-permission').modal('hide');
                                let tr = $(`tr[id="${userId}"]`);
                                tr.addClass('bg-success');
                                setTimeout(function() {
                                    tr.removeClass('bg-success');
                                }, 800);
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching permissions:', error);
                        });
                    $(this).html('<span>Save</span>')
                });
            }
        }

        function generatePasswordHTML() {
            $('.add_button').remove();
            $('.DTE_Field_Name_password .DTE_Field_InputControl').after(function() {
                let html = `<div class="add_button" style="display: inline-block;">
                    <button class="btn btn-primary btn-sm p-2" id="generate_pwd" style="margin-right: 10px; ">{{ trans('user.generate') }}</button>
                    <button class="btn btn-primary btn-sm p-2" id="copy_pwd" data-password="">{{ trans('user.copy') }}</button>
                </div>`;
                $(this).append(html);
            })
        }

        function makeRandomPass(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            const numbers = '0123456789';
            const specials = '!@#$%^&*()-_';
            result += letters.charAt(Math.floor(Math.random() * letters.length));
            result += numbers.charAt(Math.floor(Math.random() * numbers.length));
            result += specials.charAt(Math.floor(Math.random() * specials.length));
            for (var i = 0; i < length - 3; i++) {
                result += characters.charAt(Math.floor(Math.random() * characters.length));
            }
            result = result.split('').sort(function() {
                return 0.5 - Math.random()
            }).join('');

            return result;
        }
    </script>
@endpush
