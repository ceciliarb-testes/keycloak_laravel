<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretController extends Controller
{
    public function index()
    {
        var_dump(Auth::user());
        return 'hello';
    }
}
