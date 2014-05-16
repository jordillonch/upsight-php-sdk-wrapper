# Upsight/Kontagent PHP SDK wrapper

This is a wrapper that uses `composer` for Upsight PHP SDK library (http://help.analytics.upsight.com/api-sdk-reference/php/).

Current Upsight library version is 0.1.

## Debug mode

You can enable the `debug` mode adding:

```php
$api = new UpsightApi(self::API_KEY, ['debug' => true]);
```

In this mode two requests are sended. One to production server and other to the test server.
