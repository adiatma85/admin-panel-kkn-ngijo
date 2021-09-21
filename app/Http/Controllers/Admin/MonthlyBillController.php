<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMonthlyBillRequest;
use App\Http\Requests\StoreMonthlyBillRequest;
use App\Http\Requests\UpdateMonthlyBillRequest;
use App\Models\MonthlyBill;
use App\Models\Bill;
use App\Models\MonthlyBillToBill;
use App\Models\Scope;
use App\Http\Controllers\Traits\CheckingScope;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthlyBillController extends Controller
{

    use CheckingScope;

    public function index()
    {
        abort_if(Gate::denies('monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $monthlyBill = MonthlyBill::get();
        $monthlyBills = $this->checkingScope() ? MonthlyBill::all() : MonthlyBill::where('scope_id', Auth::user()->scope_id)->get();

        return view('admin.monthlyBills.index', compact('monthlyBills', 'monthlyBill'));
    }

    public function create()
    {
        abort_if(Gate::denies('monthly_bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $iurans = $this->checkingScope() ? Bill::all() : Bill::where('scope_id', Auth::user()->scope_id)->get();

        $scopes = $this->checkingScope() ? Scope::all() : [];

        return view('admin.monthlyBills.create', compact('iurans', 'scopes'));
    }

    public function store(StoreMonthlyBillRequest $request)
    {
        $monthlyBill = MonthlyBill::create($request->all());
        $arrayedBills = [];

        // Inserting iurans in id of array
        foreach ($request->input('iurans') as $iuran) {
            $itemIuran = [
                'bill_id' => $iuran,
                'monthly_bill_id' => $monthlyBill->id,
            ];
            array_push($arrayedBills, $itemIuran);
        }

        $this->resolverArrayedBill($arrayedBills);

        // Sending email verification
        $this->sendEmailNotification();

        return redirect()->route('admin.monthly-bills.index');
    }

    public function edit(MonthlyBill $monthlyBill)
    {
        abort_if(Gate::denies('monthly_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $iurans = $this->checkingScope() ? Bill::all() : Bill::where('scope_id', Auth::user()->scope_id)->get();

        $scopes = $this->checkingScope() ? Scope::all() : [];

        $arrayedBillId = $monthlyBill->monthlyBilltoBill
            ->pluck('bill_id')
            ->toArray();

        return view('admin.monthlyBills.edit', compact('monthlyBill', 'iurans', 'arrayedBillId', 'scopes'));
    }

    public function update(UpdateMonthlyBillRequest $request, MonthlyBill $monthlyBill)
    {
        $monthlyBill->update($request->all());
        $arrayedBill = [];

        // Delete the bill
        if (count($monthlyBill->getArrayOnlyBills()) > 0) {
            foreach ($monthlyBill->getArrayOnlyBills() as $bill) {
                if (!in_array($bill, $request->input('iurans', []))) {
                    MonthlyBillToBill::where('bill_id', $bill)
                        ->where('monthly_bill_id', $monthlyBill->id)
                        ->delete();
                }
            }
        }

        // Inserting new bill if exist
        $bills = $monthlyBill->getArrayOnlyBills();
        foreach ($request->input('iurans', []) as $iuran) {

            if (count($bills) === 0 || !in_array($iuran, $bills)) {
                $itemIuran = [
                    'bill_id' => $iuran,
                    'monthly_bill_id' => $monthlyBill->id
                ];
                array_push($arrayedBill, $itemIuran);
            }
        }

        $this->resolverArrayedBill($arrayedBill);

        // Sending email verification
        $this->sendEmailNotification();
        
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

    // Helpers to resolve arrayed bill
    private function resolverArrayedBill($arrayedBill)
    {
        foreach ($arrayedBill as $itemBill) {
            MonthlyBillToBill::create($itemBill)->save();
        }
    }

    // Sending email verification
    private function sendEmailNotification()
    {
        // Code here @Ibad
    }
}
