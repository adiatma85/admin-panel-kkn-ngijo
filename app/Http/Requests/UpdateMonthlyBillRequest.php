<?php

namespace App\Http\Requests;

use App\Models\MonthlyBill;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMonthlyBillRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('monthly_bill_edit');
    }

    public function rules()
    {
        return [
            'tahun' => [
                'string',
                'required',
            ],
            'bulan' => [
                'required',
            ],
        ];
    }
}
