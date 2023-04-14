<?php

namespace Tests\Feature;

use App\Helpers\MailerLiteClient;
use App\Models\Account;
use Tests\TestCase;

class ValidateAccount extends TestCase
{
    const INVALID_API_KEY = "12345";

    /**
     * Check if Mailer Lite API Validation Works With Wrong Key.
     *
     * @return void
     */
    public function test_validation_with_wrong_key()
    {
        $mailerLiteCLient = new MailerLiteClient(self::INVALID_API_KEY);
        $this->assertFalse($mailerLiteCLient->validate());
    }

    /**
     * Check if Mailer Lite API Validation Works With Good Key.
     *
     * @return void
     */
    public function test_validation_with_good_key()
    {
        $mailerLiteCLient = new MailerLiteClient(env('MAILER_LITE_API_KEY', '1111'));
        $this->assertTrue($mailerLiteCLient->validate());
    }

    /**
     * Check if validation api fails when wrong key.
     *
     * @return void
     */
    public function test_validate_api_fails_wrong_key()
    {
        $response = $this->postJson('/api/v1/account', ['apiKey' => self::INVALID_API_KEY]);

        // should not be saved
        $this->assertDatabaseMissing('accounts', [
            'api_key' => self::INVALID_API_KEY,
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'errors' => [
                    ["title" => "Unauthorized", "detail" => "Invalid API Key"],
                ],
            ]);
    }

    /**
     * Check if validation api successful when right key is provided
     *
     * @return void
     */
    public function test_validate_api_success()
    {
        $response = $this->postJson('/api/v1/account', ['apiKey' => env('MAILER_LITE_API_KEY', '1111')]);

        // should return right status code with key in body
        $response->assertStatus(200);
        $this->assertEquals($response['data']['key'], env('MAILER_LITE_API_KEY', '1111'));

        // database should have key stored
        $this->assertDatabaseHas('accounts', [
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);
    }

    /**
     * Check if new user is forced to add key
     *
     * @return void
     */
    public function test_new_user_should_add_key()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Check if existing user is automatically redirected
     *
     * @return void
     */
    public function test_existing_user_redirect()
    {
        $account = Account::factory()->create();
        $response = $this->get('/');

        // manual cleanup due to lack of migrations
        $account->delete();
        $this->assertDeleted($account);

        // assert user redirect
        $response->assertRedirect("/subscribers");

    }
}
