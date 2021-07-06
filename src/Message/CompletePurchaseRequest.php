<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        throw new \RuntimeException('Not implemented');
    }

    public function getData(): array
    {
        return [
            'result' => $this->getParameter('result'),
        ];
    }

    public function sendData($data): ResponseInterface
    {
        return $this->createResponse(200, json_encode($data));
    }

    public function setResult(string $result)
    {
        $this->setParameter('result', $result);
    }

    public function getResult()
    {
        return $this->getParameter('result');
    }
}
