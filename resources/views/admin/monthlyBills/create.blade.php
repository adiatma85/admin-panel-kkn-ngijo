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
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection