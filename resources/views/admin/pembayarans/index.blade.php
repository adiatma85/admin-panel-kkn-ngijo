@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Daftar Iuran Bulanan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-MonthlyBill">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pembayarans.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pembayarans.fields.tahun') }}
                        </th>
                        <th>
                            {{ trans('cruds.pembayarans.fields.bulan') }}
                        </th>
                        <th>
                            {{ trans('cruds.pembayarans.fields.scope') }}
                        </th>
                        <th>
                            {{ trans('cruds.pembayarans.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyBills as $key => $monthlyBill)
                        <tr data-entry-id="{{ $monthlyBill->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $monthlyBill->id ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyBill->tahun ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\MonthlyBill::BULAN_SELECT[$monthlyBill->bulan] ?? 'Bulan' }}
                            </td>
                            <td>
                                {{ $monthlyBill->scope->name ?? "" }}
                            </td>
                            <td>
                                @php
                                   $isPaidOrNot = App\Models\UserToMonthlyBill::where('user_id', Auth::user()->id)->where('monthly_bill_id', $monthlyBill->id); 
                                // Jika mana sudah membayar
                                    if ($isPaidOrNot->exists()) {
                                        $obj = $isPaidOrNot->first();
                                        switch ($obj->status_pembayaran) {
                                            case 'Not Paid':
                                                $badgeLabel = "danger";
                                            break;

                                            case 'Paid':
                                                $badgeLabel = "warning";
                                            break;

                                            case 'Verified':
                                                $badgeLabel = "success";
                                            break;
                                                    
                                            default:
                                                $badgeLabel = "danger";
                                            break;
                                        }
                                    } else {
                                        $badgeLabel = "danger";
                                    }
                                @endphp
                                <span class="badge rounded-pill bg-{{$badgeLabel}}">
                                    {{ $isPaidOrNot->exists() ? $obj->status_pembayaran : "Not Paid" }}
                                </span>
                            </td>
                            <td>
                                {{-- Action --}}
                                {{-- @can('monthly_bill_show') --}}
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pembayarans.show', $monthlyBill->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                {{-- @endcan --}}

                                {{-- @can('monthly_bill_edit') --}}
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pembayarans.edit', $monthlyBill->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                {{-- @endcan --}}

                                {{-- @can('monthly_bill_delete')
                                    <form action="{{ route('admin.monthly-bills.destroy', $monthlyBill->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan --}}

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('monthly_bill_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.monthly-bills.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-MonthlyBill:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection