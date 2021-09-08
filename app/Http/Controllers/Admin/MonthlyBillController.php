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

        $iurans = Bill::all();

        $scopes = Scope::all();

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

        $iurans = Bill::all();

        $scopes = Scope::all();

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
    private function sendEmailNotification($bulan,$nama,$email)
    {
        // Code here @Ibad
        $nama = '<td>'.$nama.'</td>';
        $bulan = '<td>'.$bulan.'</td>';
        $to = $email;
        $subject = "Pembayaran Bulanan";
        $txt =' 
        <html> 
            <head> 
                <title>Selamat datang di Aplikasi Iuran Warga</title> 
            </head> 
            <body> 
                <h1>Pembayaran Iuran Bulanan</h1> 
                <table cellspacing="0" style="border: 2px dashed #FB4314; width: 100%;"> 
                    <tr> 
                        <th>Ditujukan ke saudara :</th>'.$nama.' 
                    </tr> 
                    <tr style="background-color: #e0e0e0;"> 
                        <th>Bulan:</th>'.$bulan.'
                    </tr>  
                    <tr> 
                        <th>Status :</th><td>Terbayar</td> 
                    </tr> 
                </table> 
            </body> 
        </html>';
        $headers = "MIME-Version: 1.0" . "\r\n"; 
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
        $headers .= "From: adiatma86.dec@gmail.com" . "\r\n";
        mail($to,$subject,$txt,$headers);
        //IMPROVE WITH YOUR CREATIVITY and BASED OF PROCESS
    }
} 
