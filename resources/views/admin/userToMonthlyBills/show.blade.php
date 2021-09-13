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
                          {{ $userToMonthlyBill->monthly_bill->bulan ? : '' }} {{ $userToMonthlyBill->monthly_bill->tahun ? : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}
                        </th>
                        <td>
                            @php
                                $badgeBg = "";
                                switch ($userToMonthlyBill->status_pembayaran) {
                                    case 'Not Paid':
                                        $badgeBg = "danger";
                                        break;

                                    case 'Not Verified':
                                        $badgeBg = "warning";
                                        break;

                                    case 'Verified':
                                        $badgeBg = "success";
                                        break;

                                    default:
                                        $badgeBg = "danger";
                                        break;
                                }
                            @endphp
                            <span class="badge rounded-pill bg-{{$badgeBg}}">
                                {{ $userToMonthlyBill->status_pembayaran ? : '' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.edit_status_pembayaran') }}
                        </th>
                        <td>
                            <form method="POST" action="{{ url('admin/user-to-monthly-bills-edit-status') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <input name="id" type="hidden" value="{{$userToMonthlyBill->id}}">
                                    <select class="form-control select2" name="status_pembayaran" id="status_pembayaran">
                                            <option value="Not paid" {{ $userToMonthlyBill->status_pembayaran == "Not Paid" ? "selected" : "" }}>Not paid</option>
                                            <option value="Not verified {{ $userToMonthlyBill->status_pembayaran == "Not Verified" ? "selected" : "" }}">Not verified</option>
                                            <option value="Verified" {{ $userToMonthlyBill->status_pembayaran == "Verified" ? "selected" : "" }}>Verified</option>
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
                        <th>
                            Tanggal Pembayaran
                        </th>
                </thead>
                <tbody>
                    @foreach ($userToMonthlyBill->monthly_bill->monthlyBilltoBill as $bill)
                    
                        <tr>
                            {{-- {{ $bill->bill }} --}}
                            <td>{{ $bill->bill->name ?? "" }}</td>
                            <td>Rp. {{ $bill->bill->price ?? "" }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{$badgeBg}}">
                                    {{ $userToMonthlyBill->status_pembayaran ? : '' }}
                                </span>
                            </td>
                            <td>{{ $userToMonthlyBill->created_at ?? "" }}</td>
                        </tr>
                    @endforeach
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