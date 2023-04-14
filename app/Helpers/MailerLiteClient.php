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
        $subscriberCountEndPoint = "/api/subscribers?limit=0";
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->get(self::MAILER_LITE_API_HOST . $subscriberCountEndPoint);

        if ($response->ok()) {
            return true;
        }
        return false;
    }
}
