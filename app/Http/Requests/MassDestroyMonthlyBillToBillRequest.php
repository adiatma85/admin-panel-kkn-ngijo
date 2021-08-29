<?php

namespace App\Http\Requests;

use App\Models\MonthlyBillToBill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMonthlyBillToBillRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('monthly_bill_to_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:monthly_bill_to_bills,id',
        ];
    }
}
