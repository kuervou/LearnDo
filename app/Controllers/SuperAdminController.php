<?php

namespace App\Controllers;


class SuperAdminController extends BaseController
{
    public function dashboard()
    {
        return view('superAdmin/dashboard');
    }
}