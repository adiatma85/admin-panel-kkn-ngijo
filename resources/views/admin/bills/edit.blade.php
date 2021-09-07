@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.bill.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bills.update", [$bill->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.bill.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $bill->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bill.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="description">{{ trans('cruds.bill.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $bill->description) }}" required>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bill.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="price">{{ trans('cruds.bill.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $bill->price) }}" step="0.01" required>
                @if($errors->has('price'))
                    <span class="text-danger">{{ $errors->first('price') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.bill.fields.price_helper') }}</span>
            </div>
            {{-- Scope --}}
            @if (Auth::user()->scope_id != null)
                <input type="hidden" name="scope_id" value="{{Auth::user()->scope_id}}">
            @else
                <div class="form-group">
                    <label for="scope_id" class="required">{{ trans('cruds.bill.fields.scope') }}</label>
                    <select class="form-control {{ $errors->has('scope_id') ? 'is-invalid' : '' }}" name="scope_id" id="scope_id" required>
                        <option value disabled {{ old('scope_id', $bill->scope_id) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach($scopes as $scope)
                            <option value="{{ $scope->id }}" {{ old('scope_id', $bill->scope->id) === $scope->id ? 'selected' : '' }}>{{ $scope->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('scope_id'))
                        <span class="text-danger">{{ $errors->first('scope_id') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.bill.fields.scope_helper') }}</span>
                </div>
            @endif
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection