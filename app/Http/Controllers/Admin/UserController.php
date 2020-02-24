<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Exception;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

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

    public function getList(Request $request)
    {
        $start = $request->input('start');
        $length = $request->input('length');
        
        $total = User::all()->count();
        $model = User::query()
                    ->select(['id', 'name', 'email'])
                    ->offset($start)
                    ->limit($length);

        return DataTables::eloquent($model)->setTotalRecords($total)->toJson();
    }

    /**
     * 显示创建用户角色表单
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        // 获取所有角色并将其传递到视图
        $roles = Role::get();
        return view('admins.create', ['roles'=>$roles]);
    }

    /**
     * 在数据库中保存新创建的资源
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // 验证 name、email 和 password 字段
        $this->validate($request, [
            'name'=>'required|max:120|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = User::create($request->only('email', 'name', 'password')); //只获取 email、name、password 字段
        $user->assignRole('admin'); //Assigning role to user
        $user->givePermissionTo([1,2,3]);
        
        // 重定向到 users.index 视图并显示消息
        return redirect()->route('users.index')
            ->with('flash_message',
             'User successfully added.');
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

    /**
     * 删除用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $id = $request->id;
        try{
            DB::beginTransaction();
            $user = User::findOrFail($id); 
            $user->delete();
            DB::commit();

            $error = 0;
            $message = 'admin successfully deleted.';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function showResetView()
    {
        return view('admins.passwords.edit');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password'=>'required',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        if (\Hash::check($request->input('old_password'),$user->password)){
            $user->password = bcrypt($request->input('password'));
            $user->save();
            $request->session()->invalidate();
            return redirect('/');
        }
        return back();
    }

    
    public function showUserResetView(Request $request)
    {
        $id = $request->id;
        return view('admins.passwords.reset')->with('id',$id);
    }

    public function updateUserPassword(Request $request)
    {
        $this->validate($request, [
            'password'=>'required|min:6|confirmed'
        ]);

        $id = $request->id;
        $user = User::where('id', $id)->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('users.index')
            ->with('flash_message',
             'User password successfully updated.');
    }
}
