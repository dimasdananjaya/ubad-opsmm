<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.admin-home');
    }

    public function kelolaUser(){
        return view('admin.admin-users');
    }
}
