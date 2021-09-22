<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBillRequest;
use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Bill;
use App\Models\MonthlyBillToBill;
use App\Models\Scope;
use App\Http\Controllers\Traits\CheckingScope;
use App\Models\MonthlyBill;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BillController extends Controller
{
    use CheckingScope;

    public function index()
    {
        abort_if(Gate::denies('bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bills = $this->checkingScope() ? Bill::all() : Bill::where('scope_id', Auth::user()->scope_id)->get();

        return view('admin.bills.index', compact('bills'));
    }

    public function create()
    {
        abort_if(Gate::denies('bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scopes = $this->checkingScope() ? Scope::all() : [];

        return view('admin.bills.create', compact('scopes'));
    }

    public function store(StoreBillRequest $request)
    {
        $bill = Bill::create($request->all());

        return redirect()->route('admin.bills.index');
    }

    public function edit(Bill $bill)
    {
        abort_if(Gate::denies('bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scopes = $this->checkingScope() ? Scope::all() : [];

        return view('admin.bills.edit', compact('bill', 'scopes'));
    }

    public function update(UpdateBillRequest $request, Bill $bill)
    {
        $bill->update($request->all());

        return redirect()->route('admin.bills.index');
    }

    public function show(Bill $bill)
    {
        abort_if(Gate::denies('bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.bills.show', compact('bill'));
    }

    public function destroy(Bill $bill)
    {
        abort_if(Gate::denies('bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // Clean up
        MonthlyBillToBill::where('bill_id', $bill->id)->delete();

        $bill->delete();

        return back();
    }

    public function massDestroy(MassDestroyBillRequest $request)
    {
        Bill::whereIn('id', request('ids'))->delete();

        // Cleanup
        MonthlyBillToBill::whereIn('bill_id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
