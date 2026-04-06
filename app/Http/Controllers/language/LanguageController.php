<?php

namespace App\Http\Controllers\language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
  public function swap(Request $request, $locale)
  {
    if (!in_array($locale, ['en', 'fr'])) {
      return redirect()->back()->with('error', 'Langue invalide');
    }
    $request->session()->put('locale', $locale);
    App::setLocale($locale);
    return redirect()->back()->with('success', 'Langue changée avec succès');
  }
}
