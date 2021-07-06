<?php

namespace Omnipay\Sebes\Message;

class CompletePurchaseResponse extends AbstractResponse
{
    private const STATUS_SUCCESS = 'success';

    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && self::STATUS_SUCCESS === $this->getData()['result'];
    }
}
