<?php

namespace App\Http\Requests;

use App\Models\Scope;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateScopeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('scope_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
