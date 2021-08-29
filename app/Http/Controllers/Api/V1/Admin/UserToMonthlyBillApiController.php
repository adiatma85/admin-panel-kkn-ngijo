<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserToMonthlyBillRequest;
use App\Http\Requests\UpdateUserToMonthlyBillRequest;
use App\Http\Resources\Admin\UserToMonthlyBillResource;
use App\Models\UserToMonthlyBill;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserToMonthlyBillApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_to_monthly_bill_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserToMonthlyBillResource(UserToMonthlyBill::with(['user', 'monthly_bill'])->get());
    }

    public function store(StoreUserToMonthlyBillRequest $request)
    {
        $userToMonthlyBill = UserToMonthlyBill::create($request->all());

        return (new UserToMonthlyBillResource($userToMonthlyBill))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserToMonthlyBill $userToMonthlyBill)
    {
        abort_if(Gate::denies('user_to_monthly_bill_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserToMonthlyBillResource($userToMonthlyBill->load(['user', 'monthly_bill']));
    }

    public function update(UpdateUserToMonthlyBillRequest $request, UserToMonthlyBill $userToMonthlyBill)
    {
        $userToMonthlyBill->update($request->all());

        return (new UserToMonthlyBillResource($userToMonthlyBill))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserToMonthlyBill $userToMonthlyBill)
    {
        abort_if(Gate::denies('user_to_monthly_bill_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userToMonthlyBill->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
