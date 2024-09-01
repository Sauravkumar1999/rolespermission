@extends('layouts.dashboard')
@push('header')
    <title>Roles</title>
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-bs5/editor-modal-right.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/libs/datatables/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dt-editor/css/editor.bootstrap5.min.css') }}">
@endpush
@section('main-section')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body px-0">
                    {!! $dataTable->table(['class' => 'table table-sm']) !!}
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
                            <img src="/assets/images/users/avatar-1.jpg" alt="" class="avatar-sm rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h5 class="card-title mb-1">Oliver Phillips</h5>
                            <p class="text-muted mb-0">Digital Marketing</p>
                        </div>
                    </div>
                    <div class="row"></div>
                </div>
                <div class="modal-footer">
                    @can('role.permission.update')
                        <button type="button" class="btn btn-primary" data-id=""
                            id="submit-permission"><span>Save</span></button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer')
    <script src="{{ asset('assets/libs/datatables/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables/forms-editors.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables/dt-editor/js/dataTables.editor.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('assets/libs/datatables/dt-editor/js/editor.bootstrap5.min.js') }}">
    </script>
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function() {
            let tableEditor = window.LaravelDataTables["{!! $dataTable->getTableAttribute('id') !!}-editor"];
            let table = window.LaravelDataTables['{!! $dataTable->getTableAttribute('id') !!}'];

            // Run function on table draw
            table.on('draw', function() {
                console.log('draw');
            });

            table.on('click', 'button.editor-delete', function(e) {
                e.preventDefault();
                tableEditor.remove(e.target.closest('tr'), {
                    title: 'Delete this data',
                    message: 'Sure to delete this data',
                    buttons: [{
                            text: 'Close',
                            action: function() {
                                tableEditor.close();
                            }
                        },
                        {
                            text: 'Confirm',
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
                            text: 'Close',
                            action: function() {
                                tableEditor.close();
                            }
                        },
                        {
                            text: 'Submit',
                            action: function() {
                                tableEditor.submit();
                            }
                        }
                    ]
                });
            });
            table.on('click', 'button.editor-permission', function(e) {
                let tdElements = e.target.closest('tr');
                let roleId = $(this).data('id');

                let url = "{{ route('role.permission.all', ':id') }}";
                url = url.replace(':id', roleId);
                $('#modal-permission').modal('show');

                fetch(url, {
                    header: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }).then(data => data.json()).then(res => {
                    generateHtmlPermission(res.data);
                    $('#modal-permission #submit-permission').data('id', roleId);
                })
            });

            tableEditor.on('submitSuccess', function(e, json, data) {
                if (json.action === 'remove') {
                    console.log(e, json, data);
                }
            });
            Datatablenotifications(tableEditor,'create','Data created successfully');
            Datatablenotifications(tableEditor,'edit','Data Updated successfully');
            Datatablenotifications(tableEditor,'remove','Data Deleted successfully');
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
                htmlOutput += '</div>';
                htmlOutput += '</div>';
                htmlOutput += '</div>';
            }
            if ($('#modal-permission .modal-body .row').html(htmlOutput)) {
                @can('role.permission.update')
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
                        let url = "{{ route('role.permission.update', ':id') }}";
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
                @endcan
            }
        }
    </script>
@endpush
