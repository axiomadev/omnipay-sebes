<?php

namespace Omnipay\Sebes\Message;

class PublicKeyResponse extends AbstractResponse
{
    public function getPublicKey()
    {
        return $this->getData();
    }
}
