<?php

namespace App\Http\Requests;

use App\Models\UserToMonthlyBill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserToMonthlyBillRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_to_monthly_bill_create');
    }

    public function rules()
    {
        return [];
    }
}
