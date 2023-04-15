<?php

namespace App\Http\Controllers;

use App\Helpers\MailerLiteClient;
use App\Models\Account;
use App\Models\MailerLiteSubscriber;
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
     *
     * @param Illuminate\Http\Request $request Request object
     * @return Illuminate\Http\Response
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

    /**
     * Show new subscriber page
     *
     *
     * @return \Illuminate\View\View
     **/
    public function showAddSubscriber()
    {
        $account = Account::first();
        if (isset($account)) {
            return view('new-subscriber');
        }
        return redirect('/');
    }

    /**
     * Add New Subscriber API Key
     *
     *
     * @param Illuminate\Http\Request $request Request object
     * @return Illuminate\Http\Response
     **/
    public function addSubscriber(Request $request)
    {
        $request->validate([
            'email' => 'bail|email|required|max:255',
            'name' => 'bail|required|max:255',
            'country' => 'required|max:255',
        ]);

        $email = $request->input('email');
        $name = $request->input('name');
        $country = $request->input('country');

        $account = Account::first();
        if (!isset($account)) {
            return redirect('/');
        }
        $mailerLiteCLient = new MailerLiteClient($account->api_key);
        $subscriber = new MailerLiteSubscriber(
            $email,
            $name,
            $country
        );
        $result = $mailerLiteCLient->createSubscriber($subscriber);

        if (!isset($result["errors"])) {
            return response()->view('new-subscriber', $result, 200);
        }
        return response()->view('new-subscriber', $result, 422);
    }
}
