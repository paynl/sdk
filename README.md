# PAY. PHP SDK

---

## Installation
### Composer
Require it from composer. Just run `composer require paynl/sdk` in order to get the latest stable.

For more information how to install/use composer, please visit: https://github.com/composer/composer.

### Without composer
If you don't have experience with composer, it is possible to use the SDK without using composer.

You can download the zip on the projects [releases](https://github.com/paynl/sdk/releases) page.

1. Download the package zip (SDKvx.x.x.zip).
2. Unzip the contents of the zip, and upload the vendor directory to your server.
3. In your project, require the file vendor/autoload.php
4. You can now use the SDK in your project

## Requirements
The PAY. PHP SDK works on PHP version 7.1 and up and uses the JSON-extension.

## Quickstart and examples
To quickly implement the package within your project you can use the samples included in the `samples` folder.

## Testing
In order to test the SDK, run codeception
`vendor\bin\codecept run`
