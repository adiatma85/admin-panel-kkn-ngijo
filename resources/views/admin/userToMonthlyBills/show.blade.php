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
                          {{ $userToMonthlyBill->monthly_bill->bulan ? : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}
                        </th>
                        <td>
                        {{ $userToMonthlyBill->status_pembayaran ? : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ 'edit status pembayaran' }}
                        </th>
                        <td>
                            <form method="POST" action="{{ url('admin/user-to-monthly-bills-edit-status') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input name="id" type="hidden" value="{{$userToMonthlyBill->id}}">
                                    <select class="form-control select2" name="status_pembayaran" id="status_pembayaran">           
                                            <option value="Not paid">Not paid</option>
                                            <option value="Not verified">Not verified</option>
                                            <option value="Verified">Verified</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <button class="btn btn-danger" type="submit">
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                    <tr> 
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.images') }}
                        </th>
                        <td>
                            @foreach($userToMonthlyBill->images as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <h2>
                Detail Pembayaran
            </h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <th>
                      Bulan
                    </th>
                    <th>
                       Nama
                    </th>
                
                    <th>
                        Status Pembayaran
                    </th>
                </thead>
                <tbody>
                        <tr>
                            <td>
                            {{ $userToMonthlyBill->monthly_bill->bulan ? : '' }}
                            </td>
                            <td>
                            {{$userToMonthlyBill->user->name}}
                            </td>
                            <td>
                            {{ $userToMonthlyBill->status_pembayaran ? : '' }}
                            </td>
                        </tr>                       
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monthly-bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection