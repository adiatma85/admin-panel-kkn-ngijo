<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMonthlyBillToBillRequest;
use App\Http\Requests\StoreMonthlyBillToBillRequest;
use App\Http\Requests\UpdateMonthlyBillToBillRequest;
use App\Models\Bill;
use App\Models\MonthlyBill;
use App\Models\MonthlyBillToBill;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyBillToBillController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('monthly_bill_to_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBillToBills = MonthlyBillToBill::with(['bill', 'monthly_bill'])->get();

        return view('admin.monthlyBillToBills.index', compact('monthlyBillToBills'));
    }

    public function create()
    {
        abort_if(Gate::denies('monthly_bill_to_bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bills = Bill::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthly_bills = MonthlyBill::pluck('tahun', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.monthlyBillToBills.create', compact('bills', 'monthly_bills'));
    }

    public function store(StoreMonthlyBillToBillRequest $request)
    {
        $monthlyBillToBill = MonthlyBillToBill::create($request->all());

        return redirect()->route('admin.monthly-bill-to-bills.index');
    }

    public function edit(MonthlyBillToBill $monthlyBillToBill)
    {
        abort_if(Gate::denies('monthly_bill_to_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bills = Bill::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthly_bills = MonthlyBill::pluck('tahun', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthlyBillToBill->load('bill', 'monthly_bill');

        return view('admin.monthlyBillToBills.edit', compact('bills', 'monthly_bills', 'monthlyBillToBill'));
    }

    public function update(UpdateMonthlyBillToBillRequest $request, MonthlyBillToBill $monthlyBillToBill)
    {
        $monthlyBillToBill->update($request->all());

        return redirect()->route('admin.monthly-bill-to-bills.index');
    }

    public function show(MonthlyBillToBill $monthlyBillToBill)
    {
        abort_if(Gate::denies('monthly_bill_to_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBillToBill->load('bill', 'monthly_bill');

        return view('admin.monthlyBillToBills.show', compact('monthlyBillToBill'));
    }

    public function destroy(MonthlyBillToBill $monthlyBillToBill)
    {
        abort_if(Gate::denies('monthly_bill_to_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBillToBill->delete();

        return back();
    }

    public function massDestroy(MassDestroyMonthlyBillToBillRequest $request)
    {
        MonthlyBillToBill::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
