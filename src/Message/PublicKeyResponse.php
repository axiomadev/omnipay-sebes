<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

class PublicKeyResponse extends Response
{
    public function getPublicKey()
    {
        return $this->getData();
    }
}
