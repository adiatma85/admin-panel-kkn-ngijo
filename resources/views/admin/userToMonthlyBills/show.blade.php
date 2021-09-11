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
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}
                        </th>
                        <td>
                            <div class="col-md-4">
                                <select name="" id="" class="form-control">
                                    <option value="">{{ App\Models\UserToMonthlyBill::STATUS_PEMBAYARAN_SELECT[$userToMonthlyBill->status_pembayaran] ?? '' }}</option>
                                    <option value="">Paid</option>
                                </select>
                            </div>
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
            <h1>Penjelasan detail-detail iuran</h1>
            <table class="table table-bordered table-striped">
                <thead>
                    <th>
                        Nama iuran
                    </th>
                    <th>
                        Price
                    </th>
                    {{-- <th>
                        Metode Pembayaran
                    </th> --}}
                    <th>
                        Status Pembayaran
                    </th>
                </thead>
                <tbody>
                    
                        <tr>
                            <td>
                                Nama iuran
                            </td>
                            <td>
                                Rp. Harga iuran
                            </td>
                            {{-- <td>
                                Metode Pembayaran
                            </td> --}}
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        Not Paid
                                    </div>
                                    <div class="col-6">
                                        Created At
                                    </div>
                                </div>
                            </td>
                        </tr>   
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.user-to-monthly-bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    <!-- {{ trans('global.save') }} -->
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>



@endsection