<?php

namespace App\Http\Controllers;

use App\Helpers\MailerLiteClient;
use App\Models\Account;
use App\Models\MailerLiteSubscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
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
     * Add New Subscriber
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

    /**
     * Show edit subscriber page
     *
     *
     * @return \Illuminate\View\View
     **/
    public function showEditSubscriber()
    {
        $account = Account::first();
        if (isset($account)) {
            return view('edit-subscriber');
        }
        return redirect('/');
    }

    /**
     * Update Subscriber
     *
     *
     * @param string $id subscriber id
     * @param Illuminate\Http\Request $request Request object
     * @return Illuminate\Http\Response
     **/
    public function updateSubscriber($id, Request $request)
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
        $result = $mailerLiteCLient->updateSubscriber($id,$subscriber);

        if (!isset($result["errors"])) {
            return response()->view('edit-subscriber', $result, 200);
        }
        return response()->view('edit-subscriber', $result, 422);
    }

}
