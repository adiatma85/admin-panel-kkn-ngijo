<?php

namespace App\Http\Requests;

use App\Models\MonthlyBill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyMonthlyBillRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:monthly_bills,id',
        ];
    }
}
