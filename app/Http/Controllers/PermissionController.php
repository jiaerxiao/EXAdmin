<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->authorizeResource(Permission::class, 'permission');
    }

    public function index()
    {
        return PermissionResource::collection(Permission::latest()->filter(request(['search']))->paginate(request('per_page', 15)));
    }

    public function store(StorePermissionRequest $request)
    {
        $this->authorize('create', Permission::class);
        $role = Permission::create(['name' => $request->name, 'title' => $request->title]);
        return $this->success('权限添加成功', $role);
    }

    public function show(Permission $role)
    {
        return $this->success(data: new PermissionResource($role));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->authorize('update', $permission);
        $permission->fill($request->input())->save();
        return $this->success('角色编辑成功', $permission);
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete', $permission);
        $permission->delete();
        return $this->success('权限删除成功');
    }
}
