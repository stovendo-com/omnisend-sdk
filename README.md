# Omnisend SDK

Welcome to the Omnisend SDK by **Stovendo**. This SDK allows you to interact with the Omnisend API in a streamlined and efficient manner.

## Important Note
Please note that the SDK does not cover 100% of the Omnisend API functionality. If you require a specific use case that is not covered, feel free to implement it yourself and submit a pull request. We are happy to review and merge your contributions.

## Contributions
Contributions are welcome! Whether it's fixing a bug, implementing a new feature, or improving the documentation, we appreciate your help in making this SDK better.

## Disclaimer
We are not affiliated with, endorsed by, or in any way officially connected to Omnisend. This SDK is an independent project developed by **Stovendo**.

## API Version
This SDK is based on the [Omnisend API v3](https://api-docs.omnisend.com/reference/intro).

## Installation
To install the SDK, use the following command:

```bash
composer require stovendo/omnisend-sdk
```

## Usage

Here is a basic example of how to use the SDK:

```php
require 'vendor/autoload.php';

use Stovendo\Omnisend\OmnisendApiClient;
use \Stovendo\Omnisend\OmnisendFactory;

// use the client directly
$client = new OmnisendApiClient('YOUR_API_KEY');

// or use the factory
$client = (new OmnisendFactory())->create('YOUR_API_KEY');

// check connection
$isConnected = $client->ping();

print_r($isConnected);
```

## Documentation
For detailed API usage and examples, please refer to the [Omnisend API v3 Documentation](https://api-docs.omnisend.com/reference/intro).

## Support
If you encounter any issues or have questions, please open an issue on this repository.

## License
This project is licensed under the MIT License. See the LICENSE file for more details.

Thank you for using the Omnisend SDK by Stovendo. Happy coding!