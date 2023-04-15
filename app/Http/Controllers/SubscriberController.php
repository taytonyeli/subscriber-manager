<?php

namespace App\Http\Controllers;

use App\Helpers\DataTablesHelper;
use App\Helpers\MailerLiteClient;
use App\Models\Account;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Get subscribers
     *
     *
     * @param Illuminate\Http\Request $request Request object
     * @return Illuminate\Http\Response
     **/
    public function getSubscribers(Request $request)
    {
        $request->validate([
            'draw' => 'nullable|max:1024',
        ]);
        $account = Account::first();
        $mailerLiteCLient = new MailerLiteClient($account->api_key);

        $data = $mailerLiteCLient->getSubscribers();
        $count = $mailerLiteCLient->getSubscriberCount();

        $dataTablesHelper = new DataTablesHelper($request->query('draw'));
        $finalResponse = [
            'draw' => $dataTablesHelper->getDraw(),
            'data' => $data,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ];
        return response()->json($finalResponse);
    }
}
