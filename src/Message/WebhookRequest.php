<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Sebes\Parameter\Product\Products;

class WebhookRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        $this->validate('id');

        return $this->getUrl().'/webhooks/'.$this->getParameter('id').'/';
    }

    public function setId(string $id): void
    {
        $this->setParameter('id', $id);
    }

    protected function getHttpMethod(): string
    {
        return 'GET';
    }
}
