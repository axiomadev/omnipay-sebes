<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Sebes\Client;
use Omnipay\Sebes\ItemBag;

class PurchaseRequest extends AbstractRequest
{
    public function getEndpoint(): string
    {
        return $this->getUrl().'/purchases/';
    }

    public function setClient(Client $client)
    {
        $this->setParameter('client', $client);
    }

    public function setProducts(ItemBag $products)
    {
        $this->setParameter('products', $products);
    }

    public function setSuccessCallback(string $successCallback)
    {
        $this->setParameter('success_callback', $successCallback);
    }

    public function setSuccessRedirect(string $successRedirect)
    {
        $this->setParameter('success_redirect', $successRedirect);
    }

    public function setFailureRedirect(string $failureRedirect)
    {
        $this->setParameter('failure_redirect', $failureRedirect);
    }

    public function getData(): array
    {
        $data = parent::getData();

        $this->validate('brand_id', 'client', 'products');

        return array_merge($data, [
            'brand_id' => $this->getParameter('brand_id'),
            'client' => $this->getParameter('client'),
            'purchase' => [
                'products' => $this->getParameter('products'),
            ],
            'success_callback' => $this->getParameter('success_callback'),
            'success_redirect' => $this->getParameter('success_redirect'),
            'failure_redirect' => $this->getParameter('failure_redirect'),
        ]);
    }
}
