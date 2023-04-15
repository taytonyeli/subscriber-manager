<?php
namespace App\Helpers;

use Illuminate\Support\Arr;

class DataTablesHelper
{
    protected $draw = 0;
    protected $length = 0;
    protected $start = 0;

    /**
     * Constructor. Create a dt helper
     *
     * @param int $draw DataTables draw value
     * @param int $length number of records per page
     * @param int $start current index of first item on page
     **/
    public function __construct($draw = 0, $length = 0, $start = 0)
    {
        $this->draw = (int) $draw;
        $this->length = (int) $length;
        $this->start = (int) $start;
    }

    /**
     * Get limit
     *
     * @return int
     **/
    public function getMailerLiteLimit()
    {
        return $this->length;
    }

    /**
     * Get current page
     *
     * @return int
     **/
    public function getMailerLitePage()
    {
        $page = ((int) floor($this->start / $this->length)) + 1;
        return $page;
    }

    /**
     * Increase draw for data table use
     *
     * @return int
     **/
    public function getDraw()
    {
        return $this->draw + 1;
    }

    /**
     * Transform MailerLite Response to Desired Specification for Data tables
     *
     *  @param array $mailerLiteSubscribers mailer lite response array
     *
     * @return array
     **/
    public function getStructuredData($mailerLiteSubscribers)
    {
        $structuredData = array_map(array($this, 'extractStructuredData'), $mailerLiteSubscribers);
        return $structuredData;
    }

    /**
     * Extract desired data from single MailerLite Subscriber Response
     *
     *  @param array $mailerLiteSubscriber mailer lite response array
     *
     * @return array
     **/
    public function extractStructuredData($mailerLiteSubscriber)
    {

        $id = Arr::get($mailerLiteSubscriber, 'id');
        $email = Arr::get($mailerLiteSubscriber, 'email');
        $name = Arr::get($mailerLiteSubscriber, 'fields.name');
        $country = Arr::get($mailerLiteSubscriber, 'fields.country');
        $subscribedAt = Arr::get($mailerLiteSubscriber, 'subscribed_at');

        $formattedDate = $this->formatMailerLiteDate($subscribedAt);
        $extractedData = [
            'DT_RowId' => $id,
            'email' => $email,
            'name' => $name,
            'country' => $country,
            'subscribed_at_date' => $formattedDate["date"],
            'subscribed_at_time' => $formattedDate["time"],
        ];

        return $extractedData;
    }

    /**
     * Format MailerLite Date
     *
     *  @param string mailer lite string date
     *
     * @return array
     **/
    public function formatMailerLiteDate($mailerLiteDate)
    {
        $expectedFormat = "Y-m-d H:i:s";
        $parsedDate = date_create_from_format($expectedFormat, $mailerLiteDate);
        $desiredDate = date_format($parsedDate, "d/m/Y");
        $desiredTime = date_format($parsedDate, "H:i");
        return [
            "date" => $desiredDate,
            "time" => $desiredTime,
        ];
    }
}
