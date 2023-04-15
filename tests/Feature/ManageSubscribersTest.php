<?php

namespace Tests\Feature;

use App\Helpers\MailerLiteClient;
use App\Models\Account;
use App\Models\MailerLiteSubscriber;
use Faker\Factory;
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
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);

        $subscriberResponse = $this->get('/api/v1/subscribers');
        $subscriberResponse->assertStatus(200);

        $account->delete();
        $this->assertDeleted($account);
    }

    /**
     * Test creating subscriber
     *
     * @return void
     */
    public function test_creating_subscriber()
    {
        $faker = Factory::create();
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));
        $subscriber = new MailerLiteSubscriber(
            $faker->email(),
            $faker->name(),
            $faker->country()
        );
        $result = $mailerLiteCLient->createSubscriber($subscriber);
        // dd($result);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message", $result);
        $this->assertArrayNotHasKey("errors", $result);
        $this->assertStringContainsString("Created", $result["message"]);

    }

    /**
     * Test creating subscriber via API.
     *
     * @return void
     */
    public function test_creating_subscriber_via_api()
    {
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);

        $faker = Factory::create();
        $subscriberResponse = $this->post('/create-subscriber',
            [
                "email" => $faker->email(),
                "name" => $faker->name(),
                "country" => $faker->country(),
            ]);
        $subscriberResponse->assertStatus(200);

        $account->delete();
        $this->assertDeleted($account);

    }

    /**
     * Test deleting subscriber.
     *
     * @return void
     */
    public function test_deleting_subscriber()
    {
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));
        $limit = 1;
        $data = $mailerLiteCLient->getSubscribers($limit);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual($limit, sizeof($data));

        $totalCount = $mailerLiteCLient->getSubscriberCount();

        $subscriber = $data[0];
        $this->assertArrayHasKey("id", $subscriber);

        $subscriberId = $subscriber["id"];
        $result = $mailerLiteCLient->deleteSubscriber($subscriberId);

        $postTotalCount = $mailerLiteCLient->getSubscriberCount();

        $this->assertTrue($result);
        $this->assertEquals($totalCount - 1, $postTotalCount);

    }

    /**
     * Test deleting subscriber using json api.
     *
     * @return void
     */
    public function test_deleting_subscriber_via_api()
    {
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);

        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));
        $limit = 1;
        $data = $mailerLiteCLient->getSubscribers($limit);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual($limit, sizeof($data));

        $totalCount = $mailerLiteCLient->getSubscriberCount();

        $subscriber = $data[0];
        $this->assertArrayHasKey("id", $subscriber);

        $subscriberId = $subscriber["id"];
        $subscriberResponse = $this->delete('/api/v1/subscribers/' . $subscriberId);
        $subscriberResponse->assertStatus(204);

        $postTotalCount = $mailerLiteCLient->getSubscriberCount();
        $this->assertEquals($totalCount - 1, $postTotalCount);

        $account->delete();
        $this->assertDeleted($account);

    }

    public function tearDown(): void
    {
        Account::truncate();
        parent::tearDown();
    }
}
