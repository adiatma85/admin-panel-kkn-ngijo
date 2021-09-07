@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.monthlyBill.title_singular') }}
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
                                        Badge Pembayaran
                                    </div>
                                    <div class="col-6">
                                        Tanggal Pembayaran kalau ada
                                    </div>
                                </div>
                            </td>
                        </tr>                       
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="POST" action="{{ route('admin.pembayarans.update', [ "pembayaran" => $monthlyBill->id ]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            {{-- Foto --}}
            <div class="form-group">
                <label class="required" for="image">{{ trans('cruds.pembayarans.fields.image') }}</label>
                <div class="needsclick dropzone {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image-dropzone">
                </div>
                @if($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.pembayarans.fields.image_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
@section('scripts')
<script>
    var uploadedImageMap = {}
Dropzone.options.imageDropzone = {
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
      uploadedImageMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file.path)
      file.previewElement.remove()
      var name = ''
      if (typeof file.path !== 'undefined') {
        name = file.path
      } else {
        name = uploadedImageMap[file.name]
      }
      $('form').find('input[name="images[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($userToMonthlyBill) && $userToMonthlyBill->images)
        var files =
            {!! json_encode($userToMonthlyBill->images) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
            }
@endif
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