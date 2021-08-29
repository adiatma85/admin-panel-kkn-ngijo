@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userToMonthlyBill.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.user-to-monthly-bills.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.userToMonthlyBill.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="monthly_bill_id">{{ trans('cruds.userToMonthlyBill.fields.monthly_bill') }}</label>
                <select class="form-control select2 {{ $errors->has('monthly_bill') ? 'is-invalid' : '' }}" name="monthly_bill_id" id="monthly_bill_id">
                    @foreach($monthly_bills as $id => $entry)
                        <option value="{{ $id }}" {{ old('monthly_bill_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('monthly_bill'))
                    <span class="text-danger">{{ $errors->first('monthly_bill') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.monthly_bill_helper') }}</span>
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