<?php

namespace App\Http\Controllers;

use App\Helpers\MailerLiteClient;
use App\Models\Account;
use Illuminate\Http\Request;

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

    /**
     * Save Client API Key
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function addApiKey(Request $request)
    {
        $request->validate([
            'apiKey' => 'required|max:1024',
        ]);

        $apiKey = $request->input('apiKey');
        $mailerLiteCLient = new MailerLiteClient($apiKey);
        $isApiKeyValid = $mailerLiteCLient->validate();

        if ($isApiKeyValid) {
            Account::create([
                'api_key' => $apiKey,
            ]);
            return redirect('/subscribers');
        }
        $unauthorized_error = [
            'api_errors' => [
                ["title" => "Unauthorized", "message" => "Invalid API Key"],
            ],
        ];
        return response()->view('validate', $unauthorized_error, 401);
    }

    /**
     * Show subscribers page
     *
     *
     * @return \Illuminate\View\View
     **/
    public function showSubscribers()
    {
        $account = Account::first();
        if (isset($account)) {
            return view('subscribers');
        }
        return redirect('/');
    }
}
