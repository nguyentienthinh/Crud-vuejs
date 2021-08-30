<?php

namespace App\Exceptions;

use Exception;

/**
 * Bad Request Exception.
 */
class BadRequestException extends Exception
{
    protected $status;
    protected $message;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->status = config('constants.status.ERROR.BAD_REQUEST');
        $this->message = config('constants.message.ERROR.BAD_REQUEST');
        parent::__construct($this->message);
    }

    /**
     * Get status Code
     *
     * @return String
     */
    public function getStatus()
    {
        return $this->status;
    }
}
