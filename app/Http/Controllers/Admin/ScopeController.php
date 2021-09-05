<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyScopeRequest;
use App\Http\Requests\StoreScopeRequest;
use App\Http\Requests\UpdateScopeRequest;
use App\Models\Scope;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ScopeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('scope_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scopes = Scope::all();

        return view('admin.scopes.index', compact('scopes'));
    }

    public function create()
    {
        abort_if(Gate::denies('scope_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.scopes.create');
    }

    public function store(StoreScopeRequest $request)
    {
        $scope = Scope::create($request->all());

        return redirect()->route('admin.scopes.index');
    }

    public function edit(Scope $scope)
    {
        abort_if(Gate::denies('scope_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.scopes.edit', compact('scope'));
    }

    public function update(UpdateScopeRequest $request, Scope $scope)
    {
        $scope->update($request->all());

        return redirect()->route('admin.scopes.index');
    }

    public function show(Scope $scope)
    {
        abort_if(Gate::denies('scope_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.scopes.show', compact('scope'));
    }

    public function destroy(Scope $scope)
    {
        abort_if(Gate::denies('scope_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scope->delete();

        return back();
    }

    public function massDestroy(MassDestroyScopeRequest $request)
    {
        Scope::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
