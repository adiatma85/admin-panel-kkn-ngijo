@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.monthlyBillToBill.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.monthly-bill-to-bills.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="bill_id">{{ trans('cruds.monthlyBillToBill.fields.bill') }}</label>
                <select class="form-control select2 {{ $errors->has('bill') ? 'is-invalid' : '' }}" name="bill_id" id="bill_id">
                    @foreach($bills as $id => $entry)
                        <option value="{{ $id }}" {{ old('bill_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('bill'))
                    <span class="text-danger">{{ $errors->first('bill') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyBillToBill.fields.bill_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="monthly_bill_id">{{ trans('cruds.monthlyBillToBill.fields.monthly_bill') }}</label>
                <select class="form-control select2 {{ $errors->has('monthly_bill') ? 'is-invalid' : '' }}" name="monthly_bill_id" id="monthly_bill_id">
                    @foreach($monthly_bills as $id => $entry)
                        <option value="{{ $id }}" {{ old('monthly_bill_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('monthly_bill'))
                    <span class="text-danger">{{ $errors->first('monthly_bill') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyBillToBill.fields.monthly_bill_helper') }}</span>
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