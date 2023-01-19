<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function verify(Request $request)
    {
        echo UserService::doLogin($request->input());
    }
	
	public function error503()
    {
        return view('503');
    }

    public function logout()
    {
        session()->flush();

        return redirect()->to('/');
    }
}
