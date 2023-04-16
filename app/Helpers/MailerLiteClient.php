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

    /**
     * Creates a subscriber
     *
     * @param \App\Models\MailerLiteSubscriber $subscriber subscriber object
     *
     * @return int
     **/
    public function createSubscriber($subscriber)
    {
        $createSubscriberEndPoint = "/api/subscribers";
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->post(self::MAILER_LITE_API_HOST . $createSubscriberEndPoint, $subscriber->getAsArrayForCreateAPI());

        if ($response->status() === 201) {
            return [
                "message" => "Successfully Created Subscriber",
            ];
        }
        if ($response->status() === 200) {
            return [
                "errors" => [
                    "email" => ["Subscriber with email $subscriber->email already exists"],
                ],
                "message" => "Subscriber with email $subscriber->email already exists",
            ];
        }
        if ($response->status() === 422) {
            return $response->json();
        }
        return [
            "errors" => [],
            "message" => "There was an error processing your request",
        ];
    }

    /**
     * Updates a subscriber by id
     *
     *  @param string $subscriberId subscriber id
     * @param \App\Models\MailerLiteSubscriber $subscriber subscriber object
     *
     * @return int
     **/
    public function updateSubscriber($subscriberId, $subscriber)
    {
        $updateSubscriberEndPoint = "/api/subscribers/" . $subscriberId;
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->put(self::MAILER_LITE_API_HOST . $updateSubscriberEndPoint, $subscriber->getAsArrayForUpdateAPI());

        if ($response->status() === 200) {
            return [
                "message" => "Successfully Updated Subscriber",
                "data" => $response->json()["data"],
            ];
        }
        if ($response->status() === 422) {
            return $response->json();
        }
        return [
            "errors" => [],
            "message" => "There was an error processing your request",
        ];
    }

    /**
     * Deletes a subscriber by id
     *
     * @param string $subscriberId subscriber id
     * @return boolean
     **/
    public function deleteSubscriber($subscriberId)
    {
        $deleteSubscriberEndPoint = "/api/subscribers/" . $subscriberId;
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->delete(self::MAILER_LITE_API_HOST . $deleteSubscriberEndPoint);

        if ($response->status() === 204) {
            return true;
        }
        return false;
    }

    /**
     * Gets a subscriber by id
     *
     * @param string $subscriberId subscriber id
     * @return boolean
     **/
    public function getSubscriber($subscriberId)
    {
        $getSubscriberEndPoint = "/api/subscribers/" . $subscriberId;
        $response = Http::withHeaders([
            'Authorization' => "Bearer $this->apiKey",
        ])->withOptions([
            'verify' => false,
        ])->get(self::MAILER_LITE_API_HOST . $getSubscriberEndPoint);

        if ($response->status() === 200) {
            return [
                "message" => "Subscriber found",
                "data" => $response->json()["data"],
            ];
        }
        return [
            "errors" => [],
            "message" => "No subscribers found",
        ];
    }
}
