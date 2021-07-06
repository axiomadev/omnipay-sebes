<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends Response implements RedirectResponseInterface
{
    public function getTransactionReference(): string
    {
        return $this->data['id'];
    }

    public function isRedirect() : bool
    {
        return isset($this->data['checkout_url']);
    }

    public function getRedirectUrl(): string
    {
        return $this->data['checkout_url'];
    }
}
