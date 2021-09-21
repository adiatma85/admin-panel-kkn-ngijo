@extends('layouts.admin')
@section('content')
@can('monthly_bill_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.monthly-bills.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.monthlyBill.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.monthlyBill.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-MonthlyBill">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.monthlyBill.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyBill.fields.tahun') }}
                        </th>
                        <th>
                            {{ trans('cruds.monthlyBill.fields.bulan') }}
                        </th>
                        @if (Auth::user()->scope_id != null)    
                            <th>
                                {{ trans('cruds.bill.fields.scope') }}
                            </th>
                        @endif
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
                                {{ App\Models\MonthlyBill::BULAN_SELECT[$monthlyBill->bulan] ?? '' }}
                            </td>
                            @if (Auth::user()->scope_id != null)    
                                <td>
                                    {{ $monthlyBill->scope->name ?? "" }}
                                </td>
                            @endif
                            <td>
                                @can('monthly_bill_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.index-detail-pembayaran', [ 'monthlyBill_Id' => $monthlyBill->id ]) }}">
                                        Daftar Pembayaran
                                    </a>
                                @endcan

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