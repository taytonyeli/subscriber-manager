<?php

namespace Tests\Feature;

use App\Helpers\MailerLiteClient;
use App\Models\Account;
use Tests\TestCase;

class ManageSubscribersTest extends TestCase
{
    /**
     * Test fetching subscriber data.
     *
     * @return void
     */
    public function test_fetching_subscriber_data()
    {
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));
        $limit = 1;
        $data = $mailerLiteCLient->getSubscribers($limit);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual($limit, sizeof($data));
    }

    /**
     * Test fetching subscriber data via API.
     *
     * @return void
     */
    public function test_fetching_subscriber_data_with_api()
    {
        $response = $this->postJson('/', ['apiKey' => env('MAILER_LITE_API_KEY', '1111')]);

        // database should have key stored
        $this->assertDatabaseHas('accounts', [
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);

        $subscriberResponse = $this->get('/api/v1/subscribers');

        $subscriberResponse->assertStatus(200);

        // $subscriberResponse->assertJson(fn($json) =>
        //     $json->has('fields')
        // );

        // manual cleanup due to lack of migrations
        $account = Account::firstWhere('api_key', env('MAILER_LITE_API_KEY', '1111'));
        $account->delete();
        $this->assertDeleted($account);
    }

    public function tearDown(): void
    {
        Account::truncate();
        parent::tearDown();
    }
}
