<?php

declare(strict_types=1);

namespace Bubblehearth\Bubblehearth\Classic\Regions;

use Bubblehearth\Bubblehearth\BubbleHearthClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * A client connector for searching regions for World of Warcraft Classic.
 */
final readonly class RegionClient
{
    public function __construct(private BubbleHearthClient $internalClient)
    {
    }

    /**
     * Retrieves a list of available regions for the locale.
     *
     * @throws GuzzleException
     */
    public function getRegionIndex(): RegionIndex
    {
        $uri = 'data/wow/region/index';

        /** @var RegionIndex $response */
        $response = $this->internalClient->sendAndDeserialize($uri, RegionIndex::class);

        return $response;
    }

    /**
     * Retrieves a region based on the ID.
     *
     * @throws GuzzleException
     */
    public function getRegion(string $regionId): Region
    {
        $uri = "data/wow/region/$regionId";

        /** @var Region $response */
        $response = $this->internalClient->sendAndDeserialize($uri, Region::class);

        return $response;
    }
}
