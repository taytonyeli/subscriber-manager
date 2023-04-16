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

    /**
     * Test updating subscriber.
     *
     * @return void
     */
    public function test_updating_subscriber()
    {
        // initial setup
        $faker = Factory::create();
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));

        // get a subscriber to test
        $limit = 1;
        $data = $mailerLiteCLient->getSubscribers($limit);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual($limit, sizeof($data));

        // check and use relevant details
        $subscriber = $data[0];
        $this->assertArrayHasKey("id", $subscriber);
        $this->assertArrayHasKey("email", $subscriber);
        $subscriberId = $subscriber["id"];
        $subscriberEmail = $subscriber["email"];

        // create subscriber to update
        $subscriber = new MailerLiteSubscriber(
            $subscriberEmail,
            $faker->name(),
            $faker->country()
        );

        // update
        $result = $mailerLiteCLient->updateSubscriber($subscriberId, $subscriber);

        // check successful response
        $this->assertIsArray($result);
        $this->assertArrayHasKey("message", $result);
        $this->assertArrayHasKey("data", $result);
        $this->assertArrayNotHasKey("errors", $result);
        $this->assertStringContainsString("Updated", $result["message"]);

        // check data actually updated
        $updatedData = $result["data"];
        $this->assertArrayHasKey("fields", $updatedData);
        $this->assertEquals($subscriber->email, $updatedData["email"]);
        $this->assertEquals($subscriber->fields->name, $updatedData["fields"]["name"]);
        $this->assertEquals($subscriber->fields->country, $updatedData["fields"]["country"]);

    }

    
    /**
     * Test updating subscriber via api.
     *
     * @return void
     */
    public function test_updating_subscriber_via_api()
    {
        // initial setup
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);
        $faker = Factory::create();
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));

        // get a subscriber to test
        $limit = 1;
        $data = $mailerLiteCLient->getSubscribers($limit);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual($limit, sizeof($data));

        // check and use relevant details
        $subscriber = $data[0];
        $this->assertArrayHasKey("id", $subscriber);
        $this->assertArrayHasKey("email", $subscriber);
        $subscriberId = $subscriber["id"];
        $subscriberEmail = $subscriber["email"];

        // update using api
        $subscriberResponse = $this->post('/edit-subscriber/' . $subscriberId, [
            "email" => $subscriberEmail,
            "name" => $faker->name(),
            "country" => $faker->country(),
        ]);
        

        // check success
        $subscriberResponse->assertRedirect();

        $account->delete();
        $this->assertDeleted($account);


    }

    /**
     * Test fetching subscriber data.
     *
     * @return void
     */
    public function test_fetching_single_subscriber()
    {
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));
        $limit = 1;
        $data = $mailerLiteCLient->getSubscribers($limit);
        $this->assertNotEmpty($data);
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual($limit, sizeof($data));

        $subscriber = $data[0];
        $this->assertArrayHasKey("id", $subscriber);
        $subscriberId = $subscriber["id"];

        $result = $mailerLiteCLient->getSubscriber($subscriberId);
        $this->assertArrayHasKey("message", $result);
        $this->assertArrayHasKey("data", $result);
        $this->assertArrayNotHasKey("errors", $result);
        
        // check and use relevant details
        $subscriber = $result["data"];
        $this->assertArrayHasKey("id", $subscriber);
        $this->assertArrayHasKey("email", $subscriber);
        $this->assertArrayHasKey("name", $subscriber);
        $this->assertArrayHasKey("country", $subscriber);
        $this->assertEquals($subscriberId, $subscriber["id"]);

    }


    public function tearDown(): void
    {
        Account::truncate();
        parent::tearDown();
    }
}
