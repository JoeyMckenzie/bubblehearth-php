# BubbleHearth

![BubbleHearth Logo](https://your-library-logo-url.png)

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
composer require your-vendor/bubble-hearth-php-library
```

## Usage

```php
<?php

use YourVendor\BubbleHearth\BubbleHearth;

// Initialize the library with your Blizzard API credentials
$bubbleHearth = new BubbleHearth('YOUR_CLIENT_ID', 'YOUR_CLIENT_SECRET');

// Get World of Warcraft character data
$characterData = $bubbleHearth->getCharacterData('us', 'realm', 'characterName');

// Display character data
print_r($characterData);

?>
```

## Documentation

For detailed documentation on using the BubbleHearth PHP Library and available methods, refer to
the [Wiki](https://github.com/your-vendor/bubble-hearth-php-library/wiki).

## Examples

Explore the `examples` directory for sample usage scenarios and code snippets.

## Contributing

Contributions are welcome! Please read our [contribution guidelines](CONTRIBUTING.md) before submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- Special thanks to Blizzard for providing the awesome Game Data APIs.

## Contact

For issues or questions, please open an [issue](https://github.com/your-vendor/bubble-hearth-php-library/issues).

---

Replace `'YOUR_CLIENT_ID'` and `'YOUR_CLIENT_SECRET'` with your actual Blizzard API credentials. Also, update the logo
URL, Wiki link, and other details as needed.