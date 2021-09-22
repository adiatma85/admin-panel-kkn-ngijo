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
                    @foreach($users as $user)
                        @php
                            $userToMonthlyBill = $user->itemPembayaran;
                            $isExist = count($userToMonthlyBill) != 0;
                        @endphp
                        <tr data-entry-id="{{ $user->id }}">
                            <td>
                            
                            </td>
                            <td>
                                {{ $user->name ?? '' }}
                            </td>
                            <td>
                                {{ $monthlyBill->bulan ?? "" }} {{ $monthlyBulan->tahun ?? "" }}
                            </td>
                            <td>
                                @php
                                    $badgeBg = "";
                                    if ($isExist) {
                                        switch ($userToMonthlyBill[0]->status_pembayaran) {
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
                                    } else {
                                        $badgeBg = "danger";
                                    }
                                @endphp
                                <span class="badge rounded-pill bg-{{$badgeBg}}">
                                    {{ $userToMonthlyBill[0]->status_pembayaran ?? 'Not Paid' }}
                                </span>
                            </td> 
                            <td>
                                @if ($isExist)    
                                    @foreach($userToMonthlyBill[0]->images as $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $media->getUrl('thumb') }}">
                                        </a>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if ($isExist)    
                                    @can('user_to_monthly_bill_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.konfirmasi-pembayaran.show', $userToMonthlyBill[0]->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('user_to_monthly_bill_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.konfirmasi-pembayaran.edit', $userToMonthlyBill[0]->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('user_to_monthly_bill_delete')
                                        <form action="{{ route('admin.konfirmasi-pembayaran.destroy', $userToMonthlyBill[0]->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                @endif

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