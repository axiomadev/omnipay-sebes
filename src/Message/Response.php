<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

abstract class Response extends AbstractResponse implements RedirectResponseInterface
{
    private int $statusCode;
    private bool $decodeData = true;

    public function __construct(RequestInterface $request, int $statusCode, string $data)
    {
        parent::__construct($request, $data);

        $this->statusCode = $statusCode;

        if ($this->decodeData) {
            $this->data = json_decode($data, true);
        } else {
            $this->data = $data;
        }
    }

    public function isSuccessful(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }
}
