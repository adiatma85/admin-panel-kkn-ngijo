<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMonthlyBillRequest;
use App\Http\Requests\StoreMonthlyBillRequest;
use App\Http\Requests\UpdateMonthlyBillRequest;
use App\Models\MonthlyBill;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyBillController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBills = MonthlyBill::all();

        return view('admin.monthlyBills.index', compact('monthlyBills'));
    }

    public function create()
    {
        abort_if(Gate::denies('monthly_bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyBills.create');
    }

    public function store(StoreMonthlyBillRequest $request)
    {
        $monthlyBill = MonthlyBill::create($request->all());

        return redirect()->route('admin.monthly-bills.index');
    }

    public function edit(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyBills.edit', compact('monthlyBill'));
    }

    public function update(UpdateMonthlyBillRequest $request, MonthlyBill $monthlyBill)
    {
        $monthlyBill->update($request->all());

        return redirect()->route('admin.monthly-bills.index');
    }

    public function show(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.monthlyBills.show', compact('monthlyBill'));
    }

    public function destroy(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBill->delete();

        return back();
    }

    public function massDestroy(MassDestroyMonthlyBillRequest $request)
    {
        MonthlyBill::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
