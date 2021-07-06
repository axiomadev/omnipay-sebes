<?php

namespace Omnipay\Sebes;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Sebes\Message\AcceptNotificationRequest;
use Omnipay\Sebes\Message\CompletePurchaseRequest;
use Omnipay\Sebes\Message\PublicKeyRequest;
use Omnipay\Sebes\Message\PurchaseRequest;
use Omnipay\Sebes\Message\WebhookRequest;

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Sebes';
    }

    public function getDefaultParameters(): array
    {
        return [
            'secret_key' => '',
            'brand_id' => '',
        ];
    }

    public function setSecretKey(string $secretKey): void
    {
        $this->setParameter('secret_key', $secretKey);
    }

    public function setBrandId(string $brandId): void
    {
        $this->setParameter('brand_id', $brandId);
    }

    public function purchase(array $options = array()): AbstractRequest
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = array()): AbstractRequest
    {
        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function acceptCallback(array $options = array()): AbstractRequest
    {
        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    public function acceptNotification(array $options = array()): AbstractRequest
    {
        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    public function fetchPublicKey(array $options = []): AbstractRequest
    {
        return $this->createRequest(PublicKeyRequest::class, $options);
    }

    public function fetchWebhook(array $options = []): AbstractRequest
    {
        return $this->createRequest(WebhookRequest::class, $options);
    }
}
