<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Http\ClientInterface;
use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Omnipay\Common\Message\NotificationInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class AcceptNotificationRequest extends CommonAbstractRequest implements NotificationInterface
{
    private const STATUS_PAID = 'paid';

//    private const EVENT_PAID = 'purchase.paid';

    private array $data;
    private string $publicKey;

    public function __construct(ClientInterface $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);

        $this->data = json_decode($httpRequest->getContent(), true);
    }

    public function getTransactionReference(): string
    {
        return $this->data['id'];
    }

    public function getTransactionStatus(): string
    {
//        if (self::EVENT_PAID === $this->data['event_type']) {
//            return NotificationInterface::STATUS_COMPLETED;
//        }
        if (self::STATUS_PAID === $this->data['status']) {
            return NotificationInterface::STATUS_COMPLETED;
        }

        return NotificationInterface::STATUS_FAILED;
    }

    public function getMessage()
    {
        throw new \RuntimeException('Not implemented');
    }

    public function setPublicKey(string $publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function sendData($data)
    {
        return $this;
    }

    public function isValid()
    {
        $signature = $this->httpRequest->headers->get('X-Signature');

        return 1 === openssl_verify(
            $this->httpRequest->getContent(),
            base64_decode($signature),
            $this->publicKey,
            'sha256WithRSAEncryption'
        );
    }
}
