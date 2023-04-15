<?php
namespace App\Helpers;

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
     * Get page
     *
     * @return int
     **/
    public function getMailerLitePage()
    {
        $page = ((int) floor($this->start / $this->length)) + 1;
        return $page;
    }

    /**
     * Get page
     *
     * @return int
     **/
    public function getDraw()
    {
        return $this->draw + 1;
    }
}
