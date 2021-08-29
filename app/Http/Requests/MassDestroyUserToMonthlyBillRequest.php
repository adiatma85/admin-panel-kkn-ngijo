<?php

namespace App\Http\Requests;

use App\Models\UserToMonthlyBill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserToMonthlyBillRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_to_monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:user_to_monthly_bills,id',
        ];
    }
}
