<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FrontController extends Controller
{
  public function index()
  {
    $organisation = getCurrentOrganisation();
    $social = optional($organisation)->social;
    return view('content.front.home', compact('organisation', 'social'));
  }
}
