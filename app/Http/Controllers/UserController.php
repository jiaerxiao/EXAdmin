<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        return UserResource::collection(User::latest()->filter(request(['search', 'filters']))->paginate(request('per_page', 15)));
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        $user = new User();
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->avatar = $request->avatar;
        $user->number = $request->number;
        $user->name = $request->name;
        $user->real_name = $request->real_name;
        $user->sex = $request->sex;
        $user->password = Hash::make("123456");
        $user->save();
        return $this->success('用户添加成功');
    }

    public function show(User $user)
    {
        return $this->success(data: new UserResource($user));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->fill($request->input())->save();
        return $this->success('用户编辑成功', $user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return $this->success('用户删除成功');
    }

    public function info()
    {
        if (Auth::check()) {
            return new UserResource(Auth::user());
        }
    }
}
