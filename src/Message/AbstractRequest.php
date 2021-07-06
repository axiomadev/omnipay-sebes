<?php

namespace Omnipay\Sebes\Message;

use Omnipay\Common\Message\AbstractRequest as CommonAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class AbstractRequest extends CommonAbstractRequest
{
    protected string $endpoint = 'https://gate.sebestech.com/api/v1';

    protected string $testEndpoint = 'https://gate.sebestech.com/api/v1';

    abstract public function getEndpoint(): string;

    public function setSecretKey(string $secretKey): void
    {
        $this->setParameter('secret_key', $secretKey);
    }

    public function setBrandId(string $brandId): void
    {
        $this->setParameter('brand_id', $brandId);
    }

    public function getUrl() : string
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->endpoint;
    }

    public function getData(): array
    {
        $this->validate('secret_key');

        return [];
    }

    public function sendData($data): ResponseInterface
    {
        $encoders = [new JsonEncoder()];

        $classMetadataFactory = new ClassMetadataFactory(
            new YamlFileLoader(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'serialization.yml')
        );
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];
        $serializer = new Serializer($normalizers, $encoders);

        $headers = [
            'Authorization' => 'Bearer '.$this->getParameter('secret_key'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $body = $data ? $serializer->serialize(
            $data,
            'json',
            [
                AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                AbstractNormalizer::IGNORED_ATTRIBUTES => ['parameters'],
            ]
        ) : null;

        $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $body);

        return $this->createResponse($httpResponse->getStatusCode(), $httpResponse->getBody()->getContents());
    }

    protected function getHttpMethod(): string
    {
        return 'POST';
    }

    protected function createResponse(int $statusCode, $data) : Response
    {
        $responseClassName = str_replace('Request', 'Response', static::class);

        return $this->response = new $responseClassName($this, $statusCode, $data);
    }
}
