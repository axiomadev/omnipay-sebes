<?php

namespace Omnipay\Sebes;

class Client
{
    private string $email;

    public function __construct(
        string $email
    ) {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
