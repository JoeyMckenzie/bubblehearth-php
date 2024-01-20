# BubbleHearth

PHP bindings for Blizzard's [Game Data APIs](https://develop.battle.net/documentation/world-of-warcraft/game-data-apis)!

[![CI](https://github.com/JoeyMckenzie/bubblehearth-php/actions/workflows/ci.yml/badge.svg)](https://github.com/JoeyMckenzie/bubblehearth-php/actions/workflows/ci.yml)

## Overview

The BubbleHearth is a convenient and easy-to-use PHP wrapper for accessing the Blizzard Game Data APIs. It
simplifies the process of making requests to various Blizzard game data endpoints, allowing developers to seamlessly
integrate Blizzard game data into their PHP applications.

## Features

- **Ease of Use:** Simple and intuitive interface for interacting with Blizzard Game Data APIs.
- **Authentication:** Handles OAuth 2.0 authentication with Blizzard, making it easy to access secure endpoints.
- **Multiple Endpoints:** Supports multiple game data endpoints, including World of Warcraft, Diablo, Hearthstone, and
  more.

## Installation

Install the BubbleHearth PHP Library using Composer:

```bash
composer require bubblehearth/bubblearth
```

## Usage

```php
<?php

use BubbleHearth\BubbleHearth;

// Initialize the library with your Blizzard API credentials
$clientId = (string) getenv('CLIENT_ID');
$clientSecret = (string) getenv('CLIENT_SECRET');
$client = new BubbleHearthClient($clientId, $clientSecret, AccountRegion::US, Locale::EnglishUS);

// Get World of Warcraft Classic realm data
$regions = $client
    ->classic()
    ->regions()
    ->getRegionIndex();
    
var_dump($characterData);

?>
```
