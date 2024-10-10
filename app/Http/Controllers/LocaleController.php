<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        if(in_array($locale,['en', 'ar'])){
            Session::put('locale', $locale);
        }
        return redirect()->back();
    }
}
