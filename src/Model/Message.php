<?php

namespace App\Model;

/**
 * @Title("message")
 */
class Message
{
    /**
     * @Type("boolean")
     */
    protected $success;

    /**
     * @Type("string")
     */
    protected $message;

    public function __construct($success = null, $message = null)
    {
        $this->success = $success;
        $this->message = $message;
    }

    public function getSuccess()
    {
        return $this->success;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}
