<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function showUsersView()
    {
        return view('user.users');
    }

    public function showAddUserView()
    {
        return view('user.create');
    }

    public function showRolesView()
    {
        return view('user.roles');
    }

    public function showPermissionsView()
    {
        return view('user.permissions');
    }
}
