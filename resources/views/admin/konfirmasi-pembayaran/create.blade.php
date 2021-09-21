@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.userToMonthlyBill.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.konfirmasi-pembayaran.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.userToMonthlyBill.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="monthly_bill_id">{{ trans('cruds.userToMonthlyBill.fields.monthly_bill') }}</label>
                <select class="form-control select2 {{ $errors->has('monthly_bill') ? 'is-invalid' : '' }}" name="monthly_bill_id" id="monthly_bill_id">
                    @foreach($monthly_bills as $id => $entry)
                        <option value="{{ $id }}" {{ old('monthly_bill_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('monthly_bill'))
                    <span class="text-danger">{{ $errors->first('monthly_bill') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.monthly_bill_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.userToMonthlyBill.fields.status_pembayaran') }}</label>
                <select class="form-control {{ $errors->has('status_pembayaran') ? 'is-invalid' : '' }}" name="status_pembayaran" id="status_pembayaran">
                    <option value disabled {{ old('status_pembayaran', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\UserToMonthlyBill::STATUS_PEMBAYARAN_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status_pembayaran', 'Not Paid') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status_pembayaran'))
                    <span class="text-danger">{{ $errors->first('status_pembayaran') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.userToMonthlyBill.fields.status_pembayaran_helper') }}</span>
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



@endsection

@section('scripts')
<script>
    var uploadedImagesMap = {}
Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.konfirmasi-pembayaran.storeMedia') }}',
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
@if(isset($userToMonthlyBill) && $userToMonthlyBill->images)
      var files = {!! json_encode($userToMonthlyBill->images) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview)
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