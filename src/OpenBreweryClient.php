<?php

declare(strict_types=1);

namespace OpenBrewery\OpenBrewery;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use OpenBrewery\OpenBrewery\Breweries\BreweryClient;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * A top-level Open Brewery DB client.
 */
final readonly class OpenBreweryClient
{
    private const int DEFAULT_TIMEOUT_SECONDS = 5;

    private const string API_BASE_URL = 'https://api.openbrewerydb.org';

    /**
     * @var Client Internal Guzzle HTTP client instance, configurable based on options.
     */
    private Client $client;

    /**
     * @var Serializer Internal serializer for marshalling responses from the Blizzard API.
     */
    private Serializer $serializer;

    public function __construct(int $timeout = self::DEFAULT_TIMEOUT_SECONDS)
    {
        $this->serializer = self::initializeSerializer();
        $this->client = new Client([
            'base_uri' => self::API_BASE_URL,
            'timeout' => $timeout,
        ]);
    }

    /**
     * Initializes a new Symfony serializer to marshal responses from the Game Data APIs.
     *
     * @return Serializer Symfony serializer.
     */
    private function initializeSerializer(): Serializer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader);
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter);
        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
            new PhpStanExtractor(),
        ]);

        $normalizers = [
            new BackedEnumNormalizer(),
            new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, $extractor),
            new ArrayDenormalizer(),
        ];

        return new Serializer($normalizers, ['json' => new JsonEncoder()]);
    }

    /**
     * Sends a request to Blizzard and attempts to
     * deserialize the response into the target type.
     *
     * @param  string  $uri  target Game Data API URI.
     * @param  string  $type  target type to deserialize into.
     * @param  array<string, string|int>|null  $query  optional query parameters.
     *
     * @throws GuzzleException
     */
    public function sendAndDeserialize(string $uri, string $type, ?array $query = null, bool $allowNullable = false): mixed
    {
        try {
            $response = self::sendRequest($uri, $query);
            $body = $response->getBody()->getContents();

            return $this->serializer->deserialize($body, $type, 'json');
        } catch (ClientException $e) {
            $code = $e->getCode();

            if ($allowNullable && $code == 404) {
                return null;
            }

            throw $e;
        }
    }

    /**
     * Sends a request to Blizzard, used by all child client connectors.
     * Requests can include optional query parameters in which, if they
     * are included, will be merged with the default locale included on
     * each request. Internally, we'll point to the correct subdomain
     * based on the account region, so adapters need only to pass the endpoint.
     *
     * @param  string  $uri  target Game Data API URI.
     * @param  array<string, string|int>|null  $query  optional query parameters.
     *
     * @throws GuzzleException
     */
    public function sendRequest(string $uri, ?array $query = null): ResponseInterface
    {
        $requestOptions = [
            'headers' => [
            ],
        ];

        if (isset($query)) {
            $requestOptions['query'] = $query;
        }

        $url = '/v1/breweries/'.$uri;

        return $this->client->get($url, $requestOptions);
    }

    public function breweries(): BreweryClient
    {
        return new BreweryClient($this);
    }
}