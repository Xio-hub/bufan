<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Category;
use App\Models\Merchant;
use App\Models\MerchantBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Introduction;
use App\Models\MerchantIndex;
use Spatie\Permission\Models\Permission;
use Auth;
use Illuminate\Support\Carbon;

class MerchantController extends Controller
{
    public function index()
    {
        return view('admins.merchants.index');
    }

    public function create()
    {
        $categories = Category::all();
        $permissions = Permission::where('guard_name','merchant')->get();
        return view('admins.merchants.create')->with(['categories' => $categories, 'permissions' => $permissions]);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'username'=>'required|max:120',
            'email'=>'required|email|unique:merchants',
            'password'=>'required|min:6',
            'merchant_name'=>'required',
            'categories'=>'required',
            'permissions'=>'required'
        ]);

        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $merchant_name = $request->input('merchant_name');
        $slogan = $request->input('slogan') ?? '';
        $categories = $request->input('categories') ?? '';
        $permissions = $request->input('permissions') ?? '';

        $merchant = Merchant::create([
            'username' => $username,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $top_logo = '';
        if ($request->hasFile('top_logo')) {
            $this->validate($request, ['top_logo'=>'image',]);
            $top_logo =  $request->top_logo->store("images/top_logo/{$merchant->id}");
        }

        $sitebar_logo = '';
        if ($request->hasFile('sitebar_logo')) {
            $this->validate($request, ['sitebar_logo'=>'image',]);
            $sitebar_logo =  $request->sitebar_logo->store("images/sitebar_logo/{$merchant->id}");
        }
        
        MerchantBase::create([
            'merchant_id' => $merchant->id,
            'name' => $merchant_name,
            'top_logo' => $top_logo,
            'sitebar_logo' => $sitebar_logo,
            'slogan' => $slogan,
            'category_ids' => implode(',', $categories)
        ]);

        MerchantIndex::create([
            'merchant_id' => $merchant->id,
        ]);

        $now = Carbon::now()->toDateTimeString();
        Introduction::insert(
            [
                [
                    'merchant_id' => $merchant->id,
                    'title' => '品牌介绍',
                    'content' => '',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'merchant_id' => $merchant->id,
                    'title' => '企业文化',
                    'content' => '',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'merchant_id' => $merchant->id,
                    'title' => '发展历程',
                    'content' => '',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'merchant_id' => $merchant->id,
                    'title' => '硬件实力',
                    'content' => '',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'merchant_id' => $merchant->id,
                    'title' => '员工风采',
                    'content' => '',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'merchant_id' => $merchant->id,
                    'title' => '实际案例',
                    'content' => '',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
            ]
        );

        $merchant->givePermissionTo($permissions);

        return redirect()->route('merchants.index')
        ->with('flash_message',
         'Merchant successfully added.');
    }

    public function show()
    {
        //
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $merchant = Merchant::where('id', $id)->whereNull('deleted_at')->firstOrFail();
        
        $merchant_base = $merchant->base;
        $category_ids = $merchant_base->category_ids;
        $categories = Category::whereIn('id', explode(',',$category_ids))->get();
        $permissions = $merchant->getAllPermissions();

        return view('admins.merchants.edit')->with([
            'merchant'=>$merchant,
            'merchant_base'=>$merchant_base,
            'permissions'=>$permissions,
            'categories'=>$categories]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'categories'=>'required',
            'permissions'=>'required',
        ]);

        $id = $request->id;
        $merchant = Merchant::where('id', $id)->whereNull('deleted_at')->firstOrFail();

        $merchant_name = $request->input('merchant_name');
        $slogan = $request->input('slogan') ?? '';
        $categories = $request->input('categories');
        $permissions = $request->input('permissions');

        $top_logo = '';
        if ($request->hasFile('top_logo')) {
            $this->validate($request, ['top_logo'=>'image',]);
            $top_logo =  $request->top_logo->store('top_logo');
        }

        $sitebar_logo = '';
        if ($request->hasFile('sitebar_logo')) {
            $this->validate($request, ['sitebar_logo'=>'image',]);
            $sitebar_logo =  $request->sitebar_logo->store('sitebar_logo');
        }

        $merchant_base = $merchant->base;
        $merchant_base->fill([
            'name' => $merchant_name,
            'slogan' => $slogan,
            'top_logo' => $top_logo,
            'sitebar_logo' => $sitebar_logo,
            'category_ids' => implode(',', $categories)
        ])->save();
        $merchant->syncPermissions($permissions);

        return redirect()->route('merchants.index')
        ->with('flash_message',
         'Merchant successfully updated.');
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        try{
            DB::beginTransaction();
            $merchant = Merchant::findOrFail($id);
            $merchant->delete();
            $merchant->base->delete();
            DB::commit();

            $error = 0;
            $message = 'merchant successfully deleted.';
        }catch(Exception $e){
            DB::rollBack();
            $error = 1;
            $message = '';
            Log::error($e);
        }finally{
            return response()->json(compact('error','message'));
        }
    }

    public function showResetView(Request $request)
    {
        $id = $request->id;
        $merchant = Merchant::where('id', $id)->firstOrFail();
        return view('admins.merchants.reset')->with('merchant', $merchant);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password'=>'required|min:6|confirmed',
        ]);

        $id = $request->id;
        $merchant = Merchant::where('id', $id)->firstOrFail();
        $merchant->password = bcrypt($request->password);
        $merchant->save();
        return redirect()->route('merchants.index')
        ->with('flash_message',
         'Merchant password successfully updated.');
    }
}
