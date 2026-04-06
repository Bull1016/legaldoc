<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class Dashboard extends Controller
{
  public function index()
  {
    $this->authorize("dashboard");
    $nbUsers = User::count();
    return view('content.dashboard', compact('nbUsers'));
  }
}
