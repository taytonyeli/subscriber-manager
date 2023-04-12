<?php

namespace App\Http\Controllers;

use App\Models\Account;

class AccountController extends Controller
{
    /**
     * Show validate view or redirect if api key exists
     *
     *
     * @return \Illuminate\View\View
     **/
    public function showOrRedirect()
    {
        $account = Account::first();
        if (isset($account)) {
            return redirect('/subscribers');
        }
        return view('validate');
    }
}
