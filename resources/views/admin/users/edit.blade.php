@extends('layouts.netfix')

@section('content')
    <div class="container-fluid">
        @include('layouts.cards')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-6 h4">
                                @lang('JOB Plan') - @lang('create')
                            </div>
                            <div class="col-6 justify-content-end">
                                @home
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @include('partials.alert')
                        <form method="post" action="@update($ppmJobPlan)">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="form-group col-4">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ $ppmJobPlan->name }}" placeholder="@lang('Name')"/>
                                    @error('name')
                                    @include('developer::partials.error_field')
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Property')</label>
                                    <select
                                        class="form-control selectpicker @error('property') is-invalid @enderror"
                                        data-live-search="true" name="property">
                                        <option value="0">@lang("Select a Property")</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}"
                                                    @if($location->id == $ppmJobPlan->location_id) selected @endif>{{ $location->location }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Villa')</label>
                                    <select
                                        class="form-control selectpicker @error('villa') is-invalid @enderror"
                                        data-live-search="true" name="villa">
                                        <option value="0">@lang("Select a Villa")</option>
                                        @foreach($buildings as $building)
                                            <option value="{{ $building->id }}"
                                                    @if($building->id == $ppmJobPlan->building_id) selected @endif>{{ $building->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Location')</label>
                                    <select
                                        class="form-control selectpicker @error('location') is-invalid @enderror"
                                        data-live-search="true" name="location">
                                        <option value="0">@lang("Select a Location")</option>
                                        @foreach($floors as $floor)
                                            <option value="{{ $floor->floor_id }}"
                                                    @if($floor->floor_id == $ppmJobPlan->floor_id) selected @endif>{{ $floor->floor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Area')</label>
                                    <select
                                        class="form-control selectpicker @error('area') is-invalid @enderror"
                                        data-live-search="true" name="area">
                                        <option value="0">@lang("Select an Area")</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->area_id }}"
                                                    @if($area->area_id == $ppmJobPlan->area_id) selected @endif>{{ $area->area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Asset')</label>
                                    <select
                                        class="form-control selectpicker @error('asset') is-invalid @enderror"
                                        data-live-search="true" name="asset">
                                        <option value="0">@lang("Select an Asset")</option>
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->id }}"
                                                    @if($asset->id == $ppmJobPlan->property_id) selected @endif>{{ $asset->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Asset Code')</label>
                                    <input type="text" class="form-control @error('asset_code') is-invalid @enderror"
                                           name="asset_code" value="{{ $ppmJobPlan->property_code }}"
                                           placeholder="@lang('Asset Code')"/>
                                    @error('asset_code')
                                    @include('developer::partials.error_field')
                                    @enderror
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Work Instruction Template')</label>
                                    <select
                                        class="form-control selectpicker @error('work_instruction') is-invalid @enderror"
                                        data-live-search="true" name="work_instruction">
                                        <option value="0">@lang("Select a Workinstruction Template")</option>
                                        @foreach($workInstructions as $workInstruction)
                                            <option
                                                value="{{ $workInstruction->id }}"
                                                @if($workInstruction->id == $ppmJobPlan->work_instruction_id) selected @endif>{{ $workInstruction->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>@lang('Frequency')</label>
                                    <input type="number" class="form-control @error('frequency') is-invalid @enderror"
                                           name="frequency" value="{{ $ppmJobPlan->frequency }}"
                                           placeholder="@lang('Frequency')"/>
                                    @error('frequency')
                                    @include('developer::partials.error_field')
                                    @enderror
                                </div>
                            </div>
                            <hr style="border:1px dashed;"/>
                            <div class="form-row justify-content-end">
                                <div class="col float-right">
                                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i>&nbsp; @lang('Save')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-footer')
    @script('js/ckeditor.js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function () {
            $("select[name=property]").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                var value = $(this).val();
                if (value != previousValue) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("buildings/get-buildings-by-location/") }}/' + value,
                        success: function (data) {
                            $string = '<option value="0">@lang("Select a Villa")</option>';
                            data.response.result.buildings.forEach(function (data, index) {
                                $string += "<option value='" + data.id + "'>" + data.name + "</option>";
                            });
                            $("select[name=villa]").html($string).selectpicker('refresh');
                        }
                    });
                }
            });
            $("select[name=villa]").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                var value = $(this).val();
                if (value != previousValue) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("floors/get-floors-by-building/") }}/' + value,
                        success: function (data) {
                            $string = '<option value="0">@lang("Select a Location")</option>';
                            data.response.result.floors.forEach(function (data, index) {
                                $string += "<option value='" + data.id + "'>" + data.name + "</option>";
                            });
                            $("select[name=location]").html($string).selectpicker('refresh');
                        }
                    });
                }
            });
            $("select[name=location]").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                var value = $(this).val();
                if (value != previousValue) {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("areas/get-areas-by-floor/") }}/' + value + '/' + $("select[name=villa]").val(),
                        success: function (data) {
                            $string = '<option value="0">@lang("Select an Area")</option>';
                            data.response.result.areas.forEach(function (data, index) {
                                $string += "<option value='" + data.id + "'>" + data.name + "</option>";
                            });
                            $("select[name=area]").html($string).selectpicker('refresh');
                        }
                    });
                }
            });
            $("select[name=area]").on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                var value = $(this).val();
                if (value != previousValue) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('properties.getAssets')  }}',
                        data: {
                            'building': $("select[name=villa]").val(),
                            'floor': $("select[name=location]").val(),
                            'area': value
                        },
                        success: function (data) {
                            $string = '<option value="0">@lang("Select an Asset")</option>';
                            data.response.result.assets.forEach(function (data, index) {
                                $string += "<option value='" + data.id + "'>" + data.name + "</option>";
                            });
                            $("select[name=asset]").html($string).selectpicker('refresh');
                        }
                    });
                }
            });
        });
    </script>
@endpush

