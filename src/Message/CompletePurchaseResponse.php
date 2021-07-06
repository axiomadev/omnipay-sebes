<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

class CompletePurchaseResponse extends Response
{
    private const STATUS_SUCCESS = 'success';

    public function isSuccessful(): bool
    {
        return parent::isSuccessful() && self::STATUS_SUCCESS === $this->getData()['result'];
    }
}
