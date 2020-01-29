<?php

namespace App\Http\Controllers\Merchant;

use Auth;
use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * 显示用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admins.index');
    }

    /**
     * 显示编辑用户角色表单
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::findOrFail($id); // 通过给定id获取用户
        $roles = Role::get(); // 获取所有角色
        return view('admins.edit', compact('user', 'roles')); // 将用户和角色数据传递到视图
    }

    /**
     * 更新数据库中的给定用户
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id); // 通过id获取给定角色

        // 验证 name, email 和 password 字段
        $this->validate($request, [
            'email'=>'required|email|unique:users,email,'.$id,
        ]);
        $input = $request->only(['email']); // 获取 name, email 和 password 字段
        $user->fill($input)->save();

        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully edited.');
    }

    public function showResetView()
    {
        return view('merchants.passwords.edit');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'=>'required',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = Auth::guard('merchant')->user();

        if (\Hash::check($request->input('old_password'),$user->password)){
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $request->session()->invalidate();
        }
        return back();
    }
}
