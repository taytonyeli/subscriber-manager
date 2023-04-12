<?php

namespace Tests\Unit;

use App\Helpers\MailerLiteClient;
use PHPUnit\Framework\TestCase;

class MLApiKeyValidateTest extends TestCase
{
    const VALID_API_KEY = "1";
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
        $mailerLiteCLient = new MailerLiteClient(self::VALID_API_KEY);
        $this->assertTrue($mailerLiteCLient->validate());
    }
}
