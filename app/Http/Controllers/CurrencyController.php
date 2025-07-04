<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function set(Request $request)
    {
        $request->validate([
            'sign' => 'required|string|exists:currencies,sign',
        ]);
        $currency = Currency::where('sign', $request->input('sign'))->first();
        session(['currency' => $currency]);
        return redirect()->back();
    }
}
