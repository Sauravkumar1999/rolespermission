@extends('layouts.dashboard')
@push('header')
    <title>Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('main-section')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Default Select</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-primary">
                            Button
                        </button>

                    </div>
                </div>
                <div class="card-body">
                    @php($bootstrapColors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'])
                    @foreach ($daysOfWeek as $day)
                        <div class="live-preview mb-3">
                            <div class="form-check form-check-{{ $bootstrapColors[$loop->index] }} mb-2">
                                <input class="form-check-input" type="checkbox" name="{{ strtolower($day) }}"
                                    id="formCheck{{ $loop->index }}">
                                <label class="form-check-label"
                                    for="formCheck{{ $loop->index }}">{{ $day }}</label>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <h6 class="fw-semibold">Start Time</h6>
                                        <input type="time" name="{{ strtolower($day) }}_start"
                                            class="form-control cursor-pointer" id="exampleInputtime">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <h6 class="fw-semibold">End Time</h6>
                                        <input type="time" name="{{ strtolower($day) }}_end"
                                            class="form-control cursor-pointer" id="exampleInputtime">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-semibold">Actions</h6>
                                    <select class="select2 form-control" name="{{ strtolower($day) }}_action[]"
                                        multiple="multiple">
                                        <option value="London">London</option>
                                        <option value="Manchester">Manchester</option>
                                        <option value="Liverpool">Liverpool</option>
                                        <option value="Paris">Paris</option>
                                        <option value="Lyon">Lyon</option>
                                        <option value="Marseille">Marseille</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
    @push('footer')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
                let timeInputFields = document.querySelectorAll('input[type="time"]');
                timeInputFields.forEach(field => {
                    field.addEventListener('click', function(e) {
                        field.click();
                    });
                });
            });
        </script>
    @endpush
