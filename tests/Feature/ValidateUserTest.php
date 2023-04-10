<?php

namespace Tests\Feature;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidateUser extends TestCase
{
    // use RefreshDatabase;
    const VALID_API_KEY = "1111";
    const INVALID_API_KEY = "12345";

    /**
     * Check if validation page exists.
     *
     * @return void
     */
    public function test_page_exists()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Check if validation page has correct view.
     *
     * @return void
     */
    public function test_validate_view()
    {
        $view = $this->view('validate');

        $view->assertSee('Enter Your API Key');
        $view->assertSee('Validate');
    }

    /**
     * Check if validation api fails when wrong key.
     *
     * @return void
     */
    public function test_validate_api_fails_wrong_key()
    {
        $response = $this->postJson('/api/v1/account', ['apiKey' => self::INVALID_API_KEY]);

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
        $response = $this->postJson('/api/v1/account', ['apiKey' => self::VALID_API_KEY]);

        // should return right status code with key in body
        $response->assertStatus(200);
        $this->assertEquals($response['data']['key'], self::VALID_API_KEY);

        // database should have key stored
        $this->assertDatabaseHas('accounts', [
            'apiKey' => self::VALID_API_KEY,
        ]);
    }

    /**
     * Check if existing user is automatically redirected
     *
     * @return void
     */
    public function test_existing_user_redirect()
    {
        $account = Account::factory()->make([
            'apiKey' => self::VALID_API_KEY,
        ]);
        $response = $this->get('/');
        $response->assertRedirect("/subscribers");

    }
}
