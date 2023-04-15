<?php

namespace Tests\Feature;

use App\Helpers\MailerLiteClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
