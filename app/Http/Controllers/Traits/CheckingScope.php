<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;

trait CheckingScope
{
    public function checkingScope()
    {
        // If scope null, return true
        // Null mengembalikan master admin
        // Tidak null mengembalikan bukan admin
        return Auth::user()->scope_id != null ? false : true;
    }
}
