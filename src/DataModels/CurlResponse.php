<?php

namespace Mkhodroo\PaystarTest\DataModels;

use stdClass;

class CurlResponse
{
    public $status;
    public $message;
    public $data;

    public function __construct(string $status, string $message, stdClass $data) {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }
}