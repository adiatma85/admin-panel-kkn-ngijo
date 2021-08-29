<?php

namespace App\Http\Requests;

use App\Models\MonthlyBillToBill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMonthlyBillToBillRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('monthly_bill_to_bill_edit');
    }

    public function rules()
    {
        return [];
    }
}
