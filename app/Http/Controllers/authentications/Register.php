<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Register extends Controller
{
  public function index()
  {
    return redirect()->route('login');
  }

  public function store(Request $request)
  {
    return redirect()->route('login');
  }
}
