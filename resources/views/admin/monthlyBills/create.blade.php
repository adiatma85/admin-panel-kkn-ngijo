@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.monthlyBill.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.monthly-bills.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="tahun">{{ trans('cruds.monthlyBill.fields.tahun') }}</label>
                <input class="form-control {{ $errors->has('tahun') ? 'is-invalid' : '' }}" type="text" name="tahun" id="tahun" value="{{ old('tahun', '') }}" required>
                @if($errors->has('tahun'))
                    <span class="text-danger">{{ $errors->first('tahun') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyBill.fields.tahun_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.monthlyBill.fields.bulan') }}</label>
                <select class="form-control {{ $errors->has('bulan') ? 'is-invalid' : '' }}" name="bulan" id="bulan" required>
                    <option value disabled {{ old('bulan', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\MonthlyBill::BULAN_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('bulan', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('bulan'))
                    <span class="text-danger">{{ $errors->first('bulan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyBill.fields.bulan_helper') }}</span>
            </div>
            {{-- Daftar Iuran --}}
            <div class="form-group">
                <label class="required" for="iurans">{{ trans('cruds.monthlyBill.fields.iuran') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('iurans') ? 'is-invalid' : '' }}" name="iurans[]" id="iurans" multiple required>
                    @foreach(($iurans ?? []) as $iuran)
                        <option value="{{ $iuran->id }}" {{ in_array($iuran->id, old('iurans', [])) ? 'selected' : '' }}>{{ $iuran->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('iurans'))
                    <span class="text-danger">{{ $errors->first('iurans') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyBill.fields.iuran_helper') }}</span>
            </div>
            {{-- Scope --}}
            @if (Auth::user()->scope_id != null)
                <input type="hidden" name="scope_id" value="{{Auth::user()->scope_id}}">
            @else
                <div class="form-group">
                    <label for="scope_id" class="required">{{ trans('cruds.bill.fields.scope') }}</label>
                    <select class="form-control {{ $errors->has('scope') ? 'is-invalid' : '' }}" name="scope_id" id="scope_id" required>
                        <option value disabled {{ old('scope_id', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($scopes as $scope)
                            <option value="{{ $scope->id }}" {{ old('scope_id', '') === (string) $scope->id ? 'selected' : '' }}>{{ $scope->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('scope_id'))
                        <span class="text-danger">{{ $errors->first('scope_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.bill.fields.scope_helper') }}</span>
                </div>
            @endif
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection