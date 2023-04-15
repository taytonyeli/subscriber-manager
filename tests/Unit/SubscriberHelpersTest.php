<?php

namespace Tests\Unit;

use App\Helpers\DataTablesHelper;
use PHPUnit\Framework\TestCase;

class SubscriberHelpersTest extends TestCase
{
    /**
     * Test date produces desired format.
     *
     * @return void
     */
    public function test_date_format()
    {

        $dataTablesHelper = new DataTablesHelper();

        $sampleDate = "2023-04-11 21:33:24";
        $result = $dataTablesHelper->formatMailerLiteDate($sampleDate);

        $this->assertEquals("11/04/2023", $result["date"]);
        $this->assertEquals("21:33", $result["time"]);

        $sampleDate = "2021-12-09 00:10:44";
        $result = $dataTablesHelper->formatMailerLiteDate($sampleDate);

        $this->assertEquals("09/12/2021", $result["date"]);
        $this->assertEquals("00:10", $result["time"]);
    }

    /**
     * Test desired structure.
     *
     * @return void
     */
    public function test_desired_subscriber_structure()
    {
        $rawSubscriber = '        {
            "id": "85195546188318236",
            "email": "taytonyeli@gmail.com",
            "status": "active",
            "source": "manual",
            "sent": 0,
            "opens_count": 0,
            "clicks_count": 0,
            "open_rate": 0,
            "click_rate": 0,
            "ip_address": null,
            "subscribed_at": "2023-04-11 21:33:24",
            "unsubscribed_at": null,
            "created_at": "2023-04-11 21:33:24",
            "updated_at": "2023-04-11 21:33:24",
            "fields": {
                "name": "Tonyeli Tay",
                "last_name": null,
                "company": null,
                "country": null,
                "city": null,
                "phone": null,
                "state": null,
                "z_i_p": null
            },
            "opted_in_at": null,
            "optin_ip": null
        }';

        $parsedSubscriber = json_decode($rawSubscriber, true);
        $dataTablesHelper = new DataTablesHelper();
        $result = $dataTablesHelper->extractStructuredData($parsedSubscriber);

        $this->assertArrayHasKey("email", $result);
        $this->assertArrayHasKey("name", $result);
        $this->assertArrayHasKey("country", $result);
        $this->assertArrayHasKey("subscribed_at_date", $result);
        $this->assertArrayHasKey("subscribed_at_time", $result);

        $this->assertEquals($parsedSubscriber["email"], $result["email"]);
        $this->assertEquals($parsedSubscriber["fields"]["name"], $result["name"]);
        $this->assertEquals(null, $result["country"]);
        $this->assertEquals("11/04/2023", $result["subscribed_at_date"]);
        $this->assertEquals("21:33", $result["subscribed_at_time"]);
    }
}
