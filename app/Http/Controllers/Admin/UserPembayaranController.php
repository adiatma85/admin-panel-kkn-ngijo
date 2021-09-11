<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MonthlyBill;
use App\Models\UserToMonthlyBill;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Controllers\Traits\CheckingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\Request;

class UserPembayaranController extends Controller
{

    use MediaUploadingTrait;
    use CheckingScope;

    public function index()
    {
        // Fetch tagihan sesuai dengan scope
        $monthlyBills = $this->checkingScope() ? 
            MonthlyBill::all() :
            MonthlyBill::where('scope_id', Auth::user()->scope_id)->get();
        return view('admin.pembayarans.index', compact('monthlyBills'));
    }

    public function show($monthlyBillId)
    {
        $monthlyBill = MonthlyBill::where('id', $monthlyBillId)->first();
        $userToMonthlyBill = UserToMonthlyBill::where('user_id', Auth::user()->id)
            ->where('monthly_bill_id', $monthlyBill->id)
            ->first();
        return view('admin.pembayarans.show', compact('monthlyBill', 'userToMonthlyBill'));
    }

    public function edit($monthlyBillId)
    {
        $monthlyBill = MonthlyBill::where('id', $monthlyBillId)->first();
        $userToMonthlyBill = UserToMonthlyBill::where('monthly_bill_id', $monthlyBill->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        return view('admin.pembayarans.edit', compact('monthlyBill', 'userToMonthlyBill'));
    }


    // Special case for storing the data
    public function update(Request $request, $monthlyBillId)
    {
        $userMonthlyBill = UserToMonthlyBill::firstOrCreate(
            [
                'status_pembayaran' => UserToMonthlyBill::STATUS_PEMBAYARAN_SELECT['Not Paid'],
                'user_id' => Auth::user()->id,
                'monthly_bill_id' => $monthlyBillId,
            ]
        );
        foreach ($request->input('images') as $image) {
            $userMonthlyBill->addMedia(storage_path('tmp/uploads/' . basename($image)))->toMediaCollection('images');
        }
        return redirect()->route('admin.pembayarans.index');
    }

    // no delete function in this group
}