<?php

namespace App\Exceptions;

use Exception;

/**
 * Not Found Exception.
 */
class NotFoundException extends Exception
{
    protected $status;
    protected $message;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->status = config('constants.status.ERROR.NOT_FOUND');
        $this->message = config('constants.message.ERROR.NOT_FOUND');
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
