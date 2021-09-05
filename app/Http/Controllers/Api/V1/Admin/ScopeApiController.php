<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScopeRequest;
use App\Http\Requests\UpdateScopeRequest;
use App\Http\Resources\Admin\ScopeResource;
use App\Models\Scope;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('scope_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ScopeResource(Scope::all());
    }

    public function store(StoreScopeRequest $request)
    {
        $scope = Scope::create($request->all());

        return (new ScopeResource($scope))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Scope $scope)
    {
        abort_if(Gate::denies('scope_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ScopeResource($scope);
    }

    public function update(UpdateScopeRequest $request, Scope $scope)
    {
        $scope->update($request->all());

        return (new ScopeResource($scope))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Scope $scope)
    {
        abort_if(Gate::denies('scope_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scope->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
