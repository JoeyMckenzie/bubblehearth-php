<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth;

use Bubblehearth\Bubblehearth\Authentication\AuthenticationContext;
use Bubblehearth\Bubblehearth\Classic\ClassicClient;
use Doctrine\Common\Annotations\AnnotationReader;
use GuzzleHttp\Client;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Default HTTP timeout, can be overridden when building the client.
 */
const DEFAULT_TIMEOUT_SECONDS = 5;

/**
 * A top-level client for interacting with Blizzard Game Data APIs.
 */
final readonly class BubbleHearthClient
{
    /**
     * @var ClassicClient a client connector for World of Warcraft Classic.
     */
    public ClassicClient $classic;

    public function __construct(
        string $clientId,
        string $clientSecret,
        AccountRegion $accountRegion,
        Locale $locale,
        int $timeoutSeconds = DEFAULT_TIMEOUT_SECONDS)
    {
        $client = new Client(['timeout' => $timeoutSeconds]);
        $serializer = self::initializeSerializer();
        $authenticationContext = new AuthenticationContext($client, $serializer, $accountRegion, $clientId, $clientSecret, $timeoutSeconds);
        $this->classic = new ClassicClient($client, $accountRegion, $locale, $authenticationContext, $serializer);
    }

    /**
     * Initializes a new Symfony serializer to marshal responses from the Game Data APIs.
     *
     * @return Serializer Symfony serializer.
     */
    private function initializeSerializer(): Serializer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());
        $extractor = new PropertyInfoExtractor([], [
            new PhpDocExtractor(),
            new ReflectionExtractor(),
        ]);
        $normalizer = new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, $extractor);

        return new Serializer([$normalizer, new ArrayDenormalizer()], [new JsonEncoder()]);
    }
}
