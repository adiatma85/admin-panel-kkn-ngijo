@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.monthlyBill.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monthly-bills.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyBill.fields.id') }}
                        </th>
                        <td>
                            {{ $monthlyBill->id ?? ""}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyBill.fields.tahun') }}
                        </th>
                        <td>
                            {{ $monthlyBill->tahun ?? ""}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Nama
                        </th>
                        <td>
                            {{ Auth::user()->name ?? "" }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyBill.fields.bulan') }}
                        </th>
                        <td>
                            {{ App\Models\MonthlyBill::BULAN_SELECT[$monthlyBill->bulan] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>

            {{-- In here untuk referensi --}}
            <h2>
                Detail Iuran-Iuran
            </h2>
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
                    @foreach ($monthlyBill->monthlyBilltoBill as $itemPivot)
                        <tr>
                            <td>
                                {{ $itemPivot->bill->name ?? "Nama iuran" }}
                            </td>
                            <td>
                                Rp. {{ $itemPivot->bill->price ?? "Harga iuran" }}
                            </td>
                            {{-- <td>
                                Metode Pembayaran
                            </td> --}}
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        @if ($userToMonthlyBill)
                                            {{ $userToMonthlyBill->status_pembayaran }}
                                        @else
                                            Not Paid
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        @if ($userToMonthlyBill)
                                            {{ $userToMonthlyBill->created_at }}    
                                        @endif
                                    </div>
                                </div>
                            </td>
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