<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.admin.tpl.user.index');
    }

    public function show()
    {
        echo UserService::showUsers();
    }

    public function add()
    {
        return view('pages.admin.tpl.user.modals.add', [
            'group' => UserService::userGroup()
        ]);
    }

    public function save(Request $request)
    {
        echo UserService::saveUser($request->input());
    }

    public function edit(Request $request)
    {
        return view('pages.admin.tpl.user.modals.edit', [
            'detail' => UserService::userDetails($request->segment(3)),
            'group'  => UserService::userGroup()
        ]);
    }

    public function update(Request $request)
    {
        echo UserService::modifyUserDetails($request->input());
    }

    public function status(Request $request)
    {
        echo UserService::userStatus($request->input());
    }

    public function reset(Request $request)
    {
        echo UserService::resetPassword($request->input('userID'));
    }

    public function changePassword()
    {
        return view('pages.auth.modals.change_pass');
    }

    public function updatePassword(Request $request)
    {
        echo UserService::modifyUserPassword($request->input());
    }
}
