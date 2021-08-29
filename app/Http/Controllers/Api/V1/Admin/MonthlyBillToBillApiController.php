<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonthlyBillToBillRequest;
use App\Http\Requests\UpdateMonthlyBillToBillRequest;
use App\Http\Resources\Admin\MonthlyBillToBillResource;
use App\Models\MonthlyBillToBill;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyBillToBillApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_bill_to_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MonthlyBillToBillResource(MonthlyBillToBill::with(['bill', 'monthly_bill'])->get());
    }

    public function store(StoreMonthlyBillToBillRequest $request)
    {
        $monthlyBillToBill = MonthlyBillToBill::create($request->all());

        return (new MonthlyBillToBillResource($monthlyBillToBill))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MonthlyBillToBill $monthlyBillToBill)
    {
        abort_if(Gate::denies('monthly_bill_to_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MonthlyBillToBillResource($monthlyBillToBill->load(['bill', 'monthly_bill']));
    }

    public function update(UpdateMonthlyBillToBillRequest $request, MonthlyBillToBill $monthlyBillToBill)
    {
        $monthlyBillToBill->update($request->all());

        return (new MonthlyBillToBillResource($monthlyBillToBill))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MonthlyBillToBill $monthlyBillToBill)
    {
        abort_if(Gate::denies('monthly_bill_to_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBillToBill->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
