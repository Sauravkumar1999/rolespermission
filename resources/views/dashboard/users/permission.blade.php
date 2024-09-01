@extends('layouts.dashboard')
@push('header')
    <title>Permissions</title>
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
                let userId = $(this).data('id');

                let url = "{{ route('permission.all', ':id') }}";
                url = url.replace(':id', userId);

                fetch(url, {
                    header: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                }).then(data => data.json()).then(res => {
                    console.log(res);
                })
                console.log(url, userId);
                // permission.all
                $('#modal-permission').modal('show');
            });

            tableEditor.on('submitSuccess', function(e, json, data) {
                if (json.action === 'remove') {
                    console.log(e, json, data);
                }
            });
        });
    </script>
@endpush
