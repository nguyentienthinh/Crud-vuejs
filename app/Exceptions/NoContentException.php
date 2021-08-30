<?php

namespace App\Exceptions;

use Exception;

/**
 * No Content Exception.
 */
class NoContentException extends Exception
{
    protected $status;
    protected $message;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->status = config('constants.status.ERROR.NO_CONTENT');
        $this->message = config('constants.message.ERROR.NO_CONTENT');
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
