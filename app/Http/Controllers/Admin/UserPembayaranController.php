<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MonthlyBill;
use App\Models\UserToMonthlyBill;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;

class UserPembayaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $scope = $user->scope_id;

        // Fetch tagihan sesuai dengan scope
        $monthlyBills = Auth::user()->scope_id != 0 ? MonthlyBill::all() : MonthlyBill::where('scope_id', Auth::user()->scope_id)->get();

        return view('pembayarans.index', compact('monthlyBills'));
    }

    public function show($monthlyBillId)
    {
        $monthlyBill = MonthlyBill::where('id', $monthlyBillId)->first();
        return view('pembayarans.show', compact('monthlyBill'));
    }

    public function edit($monthlyBillId)
    {
        $monthlyBill = MonthlyBill::where('id', $monthlyBillId)->first();
        return view('pembayarans.edit', compact('monthlyBill'));
    }


    // Special case for storing the data
    public function update(Request $request, $monthlyBillId)
    {
        $userMonthlyBill = UserToMonthlyBill::firstOrCreate(
            ['user_id' => Auth::user()->id, 'monthly_bill_id' => $monthlyBillId]
        );
        foreach ($request->input('image') as $image) {
            $userMonthlyBill->addMedia(storage_path('tmp/uploads/' . basename($image)))->toMediaCollection('attachment');
        }
        return redirect()->route('pembayaran.index');
    }

    // no delete function in this group
}
