<?php

namespace Omnipay\Sebes\Message;

class WebhookResponse extends AbstractResponse
{
    public function getPublicKey(): string
    {
        return $this->getData()['public_key'];
    }
}
