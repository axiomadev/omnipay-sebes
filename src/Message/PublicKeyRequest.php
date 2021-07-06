<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Sebes\Parameter\Product\Products;

class PublicKeyRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        return $this->getUrl().'/public_key/';
    }

    protected function getHttpMethod(): string
    {
        return 'GET';
    }
}
