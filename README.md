
# PAY. PHP SDK
PAY.'s PHP software development kit for communicating with the PAY. REST API.

---

## Installation
### Composer
Require it from composer. Just run `composer require paynl/sdk:^2.0` in order to get the latest stable.

For more information how to install/use composer, please visit: https://github.com/composer/composer.

### Without composer
If you don't have experience with composer, it is possible to use the SDK without using composer.

You can download the zip on the projects [releases](https://github.com/paynl/sdk/releases) page.

1. Download the package zip (SDKvx.x.x.zip).
2. Unzip the contents of the zip, and upload the vendor directory to your server.
3. In your project, require the file vendor/autoload.php
4. You can now use the SDK in your project

## Requirements
The PAY. PHP SDK works with PHP version 7.1 and up and uses the JSON-extension.

## Configuration
First of all, require the global configuration (or copy it to your own codebase's configuration). After that copy the config.local.dist.php (or its contents) and add it to your codebase.
Short explaination:
``` php
'config_paths' => [

],
'api' => [
    'url'  => 'https://rest.pay.nl/',
],
'authentication' => [
    'username' => '',
    'password' => '',
],
'request' => [
    'format' => 'objects',
],
'response' => [
    'format' => 'objects',
],

'debug'         => false,
```
- config_paths: An array which can contain your own custom "modules". Add the paths to the configprovider class of the module(s). Make sure your ConfigProvider.php implements the `PayNL\Sdk\Config\ProviderInterface`.
- api:
    - url: The URL of the REST API; defaults to https://rest.pay.nl
    - version: Version of the REST API to use; defaults to 1
- authentication:
    - type: The type of authentication; defaults to 'Basic' which is currently the only method to use.  
    _Note: other authentication methods will be added in the future_
    - username: Your authentication username
    - password: Password corresponding with the given username
- request:
    - format: The desired method of sending the requests; defaults to 'objects'. You've got the choose between `objects`, `json` or `xml`
- response:
    - format: The desired method of receiving the responses; defaults to 'objects'. You've got the choose between `objects`, `json` or `xml`
- debug: Boolean to set whether you'd like to see debug information when executing the request. When symfony's var-dumper is present it uses dump, otherwise var_dump; defaults to `false`.

## Quickstart and examples
To use the SDK recommended to use the Application within the package. Initialize it through the following:
```php
$config = new PayNL\Sdk\Config(<YOUR CONFIG ARRAY HERE>);

$app = PayNL\Sdk\Application\Application::init($config);
```
Now you have got the `$app` available it's very easy to make the request to the PAY. REST API.

```php
$response = $app->setRequest('<REQUEST CLASS NAME OR ALIAS>', [
        $args
    ])
    ->run()
;
```
The request names and/or aliases can be found in the Request's ConfigProvider (`PayNL\Sdk\Request\ConfigProvider::getRequestConfig()`).

**Examples**: For more information see the `samples` folder.

## Functions
Besides classes the SDK also provide some functions which can be used for implementation easiness:
- paynl_split_address;
- paynl_calc_vat_percentage;
- paynl_determine_vat_class

_Note: for more information see the files in the Resources\functions folder of the SDK._
