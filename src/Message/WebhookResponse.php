<?php

namespace Omnipay\Sebes\Message;

class WebhookResponse extends Response
{
    public function getPublicKey(): string
    {
        return $this->getData()['public_key'];
    }
}
