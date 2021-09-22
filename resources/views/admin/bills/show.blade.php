@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.bill.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <!--<th>
                            {{ trans('cruds.bill.fields.id') }}
                        </th>
                        <td>
                            {{ $bill->id }}
                        </td>-->
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bill.fields.name') }}
                        </th>
                        <td>
                            {{ $bill->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bill.fields.description') }}
                        </th>
                        <td>
                            {{ $bill->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.bill.fields.price') }}
                        </th>
                        <td>
                            Rp. {{ $bill->price }}
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection