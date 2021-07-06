<?php

namespace Omnipay\Sebes;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Sebes\Message\AcceptNotificationRequest;
use Omnipay\Sebes\Message\CompletePurchaseRequest;
use Omnipay\Sebes\Message\PublicKeyRequest;
use Omnipay\Sebes\Message\PurchaseRequest;
use Omnipay\Sebes\Message\WebhookRequest;

class Gateway extends AbstractGateway
{
    public const NOTIFICATION_TYPE_CALLBACK = 'callback';
    public const NOTIFICATION_TYPE_WEBHOOK = 'webhook';

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

    public function acceptNotification(array $options = array()): AbstractRequest
    {
        if (array_key_exists('type', $options)) {
            if (!in_array($options['type'], [self::NOTIFICATION_TYPE_CALLBACK, self::NOTIFICATION_TYPE_WEBHOOK])) {
                throw new InvalidRequestException("The 'type' parameter can be only 'callback' or 'webhook'");
            }

            if ($options['type'] === self::NOTIFICATION_TYPE_CALLBACK) {
                $publicKey = $this->fetchPublicKey()->send()->getData();
            }

            if ($options['type'] === self::NOTIFICATION_TYPE_WEBHOOK) {
                if (!array_key_exists('webhook_id', $options)) {
                    throw new InvalidRequestException("The 'webhook_id' parameter is mandatory when type is equal to 'webhook'");
                }

                $publicKey = $this->fetchWebhook([
                    'id' => $options['webhook_id'],
                ])->send()->getPublicKey();
            }

            $options = array_merge($options, [
                'public_key' => $publicKey,
            ]);
        }

        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    private function fetchPublicKey(array $options = []): AbstractRequest
    {
        return $this->createRequest(PublicKeyRequest::class, $options);
    }

    private function fetchWebhook(array $options = []): AbstractRequest
    {
        return $this->createRequest(WebhookRequest::class, $options);
    }
}
