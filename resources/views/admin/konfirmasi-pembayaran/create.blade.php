@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userToMonthlyBill.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.konfirmasi-pembayaran.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.user') }}
                        </th>
                        <td>
                            {{ $user->name ?? 'Ini nanti jadinya nama' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.userToMonthlyBill.fields.monthly_bill') }}
                        </th>
                        <td>
                          {{ $monthlyBill->bulan ? : 'Bulan' }} {{ $monthlyBill->tahun ? : 'Tahun' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                        {{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}
                        </th>
                        <td>
                            <span class="badge rounded-pill bg-danger">
                                Not Paid
                            </span>
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
                        <th>
                            Metode Pembayaran
                        </th> 
                        <th>
                            Status Pembayaran
                        </th>
                        <th>
                            Tanggal Pembayaran
                        </th>
                </thead>
                <tbody>
                    @foreach ($monthlyBill->monthlyBilltoBill as $bill)
                    
                        <tr>
                            <td>{{ $bill->bill->name ?? "" }}</td>
                            <td>Rp. {{ $bill->bill->price ?? "" }}</td>
                            <td> - </td>
                            <td>
                                <span class="badge rounded-pill bg-danger">
                                    Not Paid
                                </span>
                            </td>
                            <td> - </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <form method="POST" action="{{ route("admin.konfirmasi-pembayaran.store") }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id ?? 0 }}">
                <input type="hidden" name="monthly_bill_id" value="{{ $monthlyBill->id }}">
                <div class="form-group">
                    <label>{{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}</label>
                    <select class="form-control {{ $errors->has('status_pembayaran') ? 'is-invalid' : '' }}" name="status_pembayaran" id="status_pembayaran">
                        <option value disabled {{ old('status_pembayaran', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\UserToMonthlyBill::STATUS_PEMBAYARAN_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('status_pembayaran', "") === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status_pembayaran'))
                        <span class="text-danger">{{ $errors->first('status_pembayaran') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.status_pembayaran_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="nominal_pembayaran">{{ 'Nominal Pembayaran' }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>  
                        </div>
                        <input class="form-control {{ $errors->has('nominal_pembayaran') ? 'is-invalid' : '' }}" type="number" name="nominal_pembayaran" id="nominal_pembayaran" value="{{ old('nominal_pembayaran', '0') }}" step="0.01" required>
                        <div class="input-group-append">
                            <span class="input-group-text">.00</span>  
                        </div>
                    </div>
                    @if($errors->has('nominal_pembayaran'))
                        <span class="text-danger">{{ $errors->first('nominal_pembayaran') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.pembayarans.fields.metode_pembayaran') }}</label>
                    <select class="form-control {{ $errors->has('metode_pembayaran') ? 'is-invalid' : '' }} select2" name="metode_pembayaran" id="metode_pembayaran" required>
                        <option value disabled {{ old('metode_pembayaran', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\UserToMonthlyBill::METODE_PEMBAYARAN_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('metode_pembayaran', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('metode_pembayaran'))
                        <span class="text-danger">{{ $errors->first('metode_pembayaran') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.pembayarans.fields.metode_pembayaran_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="images">{{ trans('cruds.userToMonthlyBill.fields.images') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                    </div>
                    @if($errors->has('images'))
                        <span class="text-danger">{{ $errors->first('images') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.images_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.pembayarans.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
      uploadedImagesMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedImagesMap[file.name]
      }
      $('form').find('input[name="images[]"][value="' + name + '"]').remove()
    },
    init: function () {
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection