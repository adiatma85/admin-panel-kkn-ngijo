@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.userToMonthlyBill.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-to-monthly-bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.id') }}
                        </th>
                        <td>
                            {{ $userToMonthlyBill->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.user') }}
                        </th>
                        <td>
                            {{ $userToMonthlyBill->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.monthly_bill') }}
                        </th>
                        <td>
                            {{ $userToMonthlyBill->monthly_bill->tahun ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-to-monthly-bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection