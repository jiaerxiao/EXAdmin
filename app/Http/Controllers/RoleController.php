<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        return RoleResource::collection(Role::latest()->filter(request(['search']))->paginate(request('per_page', 15)));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);
        $role = Role::create(['name' => $request->name, 'title' => $request->title]);
        return $this->success('角色添加成功', $role);
    }

    public function show(Role $role)
    {
        return $this->success(data: new RoleResource($role));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);
        $role->fill($request->input())->save();
        return $this->success('角色编辑成功', $role);
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);
        $role->delete();
        return $this->success('角色删除成功');
    }
}
