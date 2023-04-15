<?php

namespace Tests\Feature;

use App\Models\Account;
use Tests\TestCase;

class DataTablesTest extends TestCase
{
    // public function setUp(): void
    // {
    //     Account::factory()->create([
    //         'api_key' => env('MAILER_LITE_API_KEY', '1111'),
    //     ]);
    //     parent::setUp();
    // }

    /**
     * Test that basic data tables meta data is in response.
     *
     * @return void
     */
    public function test_subscribers_has_data_tables_meta()
    {
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);
        $params = http_build_query([
            "draw" => 7,
            "length" => 10,
            "start" => 30,
        ]);
        $response = $this->get('/api/v1/subscribers?' . $params);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data',
        ]);
        $account->delete();

    }

    /**
     * Ensure draw is being updated.
     *
     * @return void
     */
    public function test_subscribers_updated_draw()
    {
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);
        $params = http_build_query([
            "draw" => 7,
            "length" => 10,
            "start" => 30,
        ]);
        $response = $this->get('/api/v1/subscribers?' . $params);

        $response->assertStatus(200);
        $response->assertJsonPath('draw', 8);
        $account->delete();

    }

    /**
     * Test that basic data tables meta data is in response.
     *
     * @return void
     */
    public function test_subscribers_has_right_data_structure()
    {
        $account = Account::factory()->create([
            'api_key' => env('MAILER_LITE_API_KEY', '1111'),
        ]);
        $params = http_build_query([
            "draw" => 7,
            "length" => 10,
            "start" => 30,
        ]);
        $response = $this->get('/api/v1/subscribers?' . $params);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'draw',
            'recordsTotal',
            'recordsFiltered',
            'data' => [
                '*' => [
                    'email',
                    'name',
                    'country',
                    'subscribed_at_date',
                    'subscribed_at_time',
                    'DT_RowId'
                ],
            ],
        ]);
        $account->delete();

    }

    public function tearDown(): void
    {
        Account::truncate();
        parent::tearDown();
    }
}
