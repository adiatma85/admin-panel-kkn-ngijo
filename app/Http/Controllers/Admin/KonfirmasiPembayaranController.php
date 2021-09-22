<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyUserToMonthlyBillRequest;
use App\Http\Requests\StoreUserToMonthlyBillRequest;
use App\Http\Requests\UpdateUserToMonthlyBillRequest;
use App\Models\MonthlyBill;
use App\Models\User;
use App\Models\UserToMonthlyBill;
use App\Models\MonthlyBillToBill;
use Gate;
use App\Http\Controllers\Traits\CheckingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class KonfirmasiPembayaranController extends Controller
{
    use MediaUploadingTrait;
    use CheckingScope;


    public function index()
    {
        // Ditambahi bulan di kolom tampilannya
        abort_if(Gate::denies('user_to_monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $monthlyBills = $this->checkingScope() ? MonthlyBill::all() : MonthlyBill::where('scope_id', Auth::user()->scope_id)->get();

        return view('admin.konfirmasi-pembayaran.index', compact('monthlyBills'));
    }

    public function detailed_index($monthlyBill_Id)
    {
        abort_if(Gate::denies('user_to_monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = $this->checkingScope() ?
            User::with(['roles', 'itemPembayaran' => function ($query) use ($monthlyBill_Id) {
                 $query->where('monthly_bill_id', $monthlyBill_Id)
                    ->with(['media']);
            }])
            ->get() :
            User::where('scope_id', Auth::user()->scope_id)
                ->with(['roles', 'itemPembayaran' => function ($query) use ($monthlyBill_Id) {
                    $query->where('monthly_bill_id', $monthlyBill_Id)
                        ->with(['media']);
                }])
                ->get();
        $monthlyBill = MonthlyBill::where('id', $monthlyBill_Id)->first();

        $userToMonthlyBills = UserToMonthlyBill::where('monthly_bill_id', $monthlyBill_Id)
            ->with(['user', 'monthly_bill', 'media'])
            ->get();

        return view('admin.konfirmasi-pembayaran.detailed-index', compact('userToMonthlyBills', 'monthlyBill', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_to_monthly_bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthly_bills = MonthlyBill::pluck('tahun', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.konfirmasi-pembayaran.create', compact('users', 'monthly_bills'));
    }

    public function store(StoreUserToMonthlyBillRequest $request)
    {
        $userToMonthlyBill = UserToMonthlyBill::create($request->all());

        foreach ($request->input('images', []) as $file) {
            $userToMonthlyBill->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $userToMonthlyBill->id]);
        }

        return redirect()->route('admin.user-to-monthly-bills.index');
    }

    public function edit($userToMonthlyBillId)
    {
        abort_if(Gate::denies('user_to_monthly_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userToMonthlyBill = UserToMonthlyBill::findOrFail($userToMonthlyBillId);

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthly_bills = MonthlyBill::pluck('tahun', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userToMonthlyBill->load('user', 'monthly_bill');

        return view('admin.konfirmasi-pembayaran.edit', compact('users', 'monthly_bills', 'userToMonthlyBill'));
    }

    public function update(UpdateUserToMonthlyBillRequest $request, UserToMonthlyBill $userToMonthlyBill)
    {
        $userToMonthlyBill->update($request->all());

        if (count($userToMonthlyBill->images) > 0) {
            foreach ($userToMonthlyBill->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }
        $media = $userToMonthlyBill->images->pluck('file_name')->toArray();
        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $userToMonthlyBill->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.user-to-monthly-bills.index');
    }

    public function show($userToMonthlyBillId)
    {
        abort_if(Gate::denies('user_to_monthly_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userToMonthlyBill = UserToMonthlyBill::findOrFail($userToMonthlyBillId);

        $userToMonthlyBill->load('user', 'monthly_bill');

        return view('admin.konfirmasi-pembayaran.show', compact('userToMonthlyBill'));
    }

    public function destroy($userToMonthlyBillId)
    {
        abort_if(Gate::denies('user_to_monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userToMonthlyBill = UserToMonthlyBill::where('id', $userToMonthlyBillId);

        $userToMonthlyBill->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserToMonthlyBillRequest $request)
    {
        UserToMonthlyBill::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('user_to_monthly_bill_create') && Gate::denies('user_to_monthly_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new UserToMonthlyBill();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }

    public function editStatus(Request $request)
    {
        UserToMonthlyBill::where('id', $request->id)->update(['status_pembayaran' => $request->status_pembayaran]);
        return redirect()->route('admin.user-to-monthly-bills.index');
    }
}
