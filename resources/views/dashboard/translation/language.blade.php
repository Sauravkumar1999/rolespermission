@extends('layouts.dashboard')
@push('header')
    <title>Translation languages</title>
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-bs5/datatables.bootstrap5.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-bs5/editor-modal-right.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/libs/datatables/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/datatables/dt-editor/css/editor.bootstrap5.min.css') }}">
@endpush
{{-- @dd(app()->getLocale()) --}}
@section('main-section')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {!! $dataTable->table() !!}
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
            let languageEditor = window.LaravelDataTables["{!! $dataTable->getTableAttribute('id') !!}-editor"];
            let languageTable = window.LaravelDataTables["{!! $dataTable->getTableAttribute('id') !!}"];

            languageTable.on('click', 'button.editor-delete', function(e) {
                e.preventDefault();
                languageEditor.remove(e.target.closest('tr'), {
                    title: 'Delete this data',
                    message: 'Sure to delete this data',
                    buttons: [{
                            text: 'Close',
                            action: function() {
                                languageEditor.close();
                            }
                        },
                        {
                            text: 'Confirm',
                            action: function() {
                                languageEditor.submit();
                            }
                        }
                    ],
                });
            });

            languageTable.on('click', 'button.editor-edit', function(e) {
                var tdElements = e.target.closest('tr');
                languageEditor.edit(tdElements, {
                    title: 'User Update',
                    buttons: [{
                            text: 'Close',
                            action: function() {
                                languageEditor.close();
                            }
                        },
                        {
                            text: 'Submit',
                            action: function() {
                                languageEditor.submit();
                            }
                        }
                    ]
                });
            });
        });
    </script>
@endpush
