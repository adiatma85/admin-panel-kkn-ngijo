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
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class UserToMonthlyBillController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('user_to_monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userToMonthlyBills = UserToMonthlyBill::with(['user', 'monthly_bill', 'media'])->get();

        return view('admin.userToMonthlyBills.index', compact('userToMonthlyBills'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_to_monthly_bill_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthly_bills = MonthlyBill::pluck('tahun', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userToMonthlyBills.create', compact('users', 'monthly_bills'));
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

    public function edit(UserToMonthlyBill $userToMonthlyBill)
    {
        abort_if(Gate::denies('user_to_monthly_bill_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $monthly_bills = MonthlyBill::pluck('tahun', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userToMonthlyBill->load('user', 'monthly_bill');

        return view('admin.userToMonthlyBills.edit', compact('users', 'monthly_bills', 'userToMonthlyBill'));
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

    public function show(UserToMonthlyBill $userToMonthlyBill)
    {
        abort_if(Gate::denies('user_to_monthly_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userToMonthlyBill->load('user', 'monthly_bill');

        return view('admin.userToMonthlyBills.show', compact('userToMonthlyBill'));
    }

    public function destroy(UserToMonthlyBill $userToMonthlyBill)
    {
        abort_if(Gate::denies('user_to_monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
}
