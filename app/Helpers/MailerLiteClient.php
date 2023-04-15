<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class MailerLiteClient
{

    /** @var string $apiKey Mailer Lite API Key */
    protected $apiKey = null;

    const MAILER_LITE_API_HOST = "https://connect.mailerlite.com";

    /**
     * Constructor. Create a client
     *
     *
     * @param string $apiKey
     **/
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Validates API Key
     *
     * @return boolean
     **/
    public function validate()
    {
        $subscriberCountEndPoint = "/api/subscribers";
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->get(self::MAILER_LITE_API_HOST . $subscriberCountEndPoint, [
            'limit' => 0,
        ]);

        if ($response->ok()) {
            return true;
        }
        return false;
    }

    /**
     * Fetches a list of subscribers
     *
     *
     * @param int $limit max number of items returned
     * @return array
     **/
    public function getSubscribers(int $limit = 25)
    {
        $getSubscribersEndPoint = "/api/subscribers";
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->get(self::MAILER_LITE_API_HOST . $getSubscribersEndPoint, [
            'limit' => $limit,
        ]);

        if ($response->ok()) {
            $subscriberResponse = $response->json();
            return $subscriberResponse["data"];
        }
        return [];
    }

    /**
     * Retrieves total subscriber count
     *
     *
     * @return int
     **/
    public function getSubscriberCount()
    {
        $getSubscribersEndPoint = "/api/subscribers";
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->get(self::MAILER_LITE_API_HOST . $getSubscribersEndPoint, [
            'limit' => 0,
        ]);

        if ($response->ok()) {
            $subscriberResponse = $response->json();
            return $subscriberResponse["total"];
        }
        return 0;
    }
}
