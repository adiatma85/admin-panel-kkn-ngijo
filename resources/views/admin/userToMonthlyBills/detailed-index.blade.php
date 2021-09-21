@extends('layouts.admin')
@section('content')
@can('user_to_monthly_bill_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.konfirmasi-pembayaran.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.userToMonthlyBill.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.userToMonthlyBill.title_singular') }} {{ trans('global.list') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-UserToMonthlyBill">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.bulan') }}
                        </th>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}
                        </th>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.images') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userToMonthlyBills as $key => $userToMonthlyBill)
                        <tr data-entry-id="{{ $userToMonthlyBill->id }}">
                            <td>
                            
                            </td>
                            <td> 
                                {{ $userToMonthlyBill->id ?? '' }}
                            </td>
                            <td>
                                {{ $userToMonthlyBill->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $userToMonthlyBill->monthly_bill->bulan ? : '' }}
                            </td>
                            <td>
                                @php
                                $badgeBg = "";
                                switch ($userToMonthlyBill->status_pembayaran) {
                                    case 'Not Paid':
                                        $badgeBg = "danger";
                                        break;

                                    case 'Paid':
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
                            <td>
                                @foreach($userToMonthlyBill->images as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('user_to_monthly_bill_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.konfirmasi-pembayaran.show', $userToMonthlyBill->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('user_to_monthly_bill_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.konfirmasi-pembayaran.edit', $userToMonthlyBill->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('user_to_monthly_bill_delete')
                                    <form action="{{ route('admin.konfirmasi-pembayaran.destroy', $userToMonthlyBill->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
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
@can('user_to_monthly_bill_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.konfirmasi-pembayaran.massDestroy') }}",
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
  let table = $('.datatable-UserToMonthlyBill:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection