<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyBillRequest;
use App\Http\Requests\UpdateMonthlyBillRequest;
use App\Http\Resources\Admin\MonthlyBillResource;
use App\Models\MonthlyBill;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyBillApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MonthlyBillResource(MonthlyBill::all());
    }

    public function store(StoreMonthlyBillRequest $request)
    {
        $monthlyBill = MonthlyBill::create($request->all());

        return (new MonthlyBillResource($monthlyBill))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MonthlyBillResource($monthlyBill);
    }

    public function update(UpdateMonthlyBillRequest $request, MonthlyBill $monthlyBill)
    {
        $monthlyBill->update($request->all());

        return (new MonthlyBillResource($monthlyBill))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBill->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
