# Fingerprint\ServerAPI\FingerprintApi

All URIs are relative to *https://api.fpjs.io*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getEvent**](FingerprintApi.md#getEvent) | **GET** /events/{request_id} | Get event by requestId
[**getVisits**](FingerprintApi.md#getVisits) | **GET** /visitors/{visitor_id} | Get visits by visitorId

# **getEvent**
> \Fingerprint\ServerAPI\Model\EventResponse getEvent($request_id)

Get event by requestId

This endpoint allows you to retrieve an individual analysis event with all the information from each activated product (Identification, Bot Detection, and others). Products that are not activated for your application or not relevant to the event's detected platform (web, iOS, Android) are not included in the response.   Use `requestId` as the URL path parameter. This API method is scoped to a request, i.e. all returned information is by `requestId`.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
    $config
);

$request_id = "request_id_example"; // string | The unique [identifier](https://dev.fingerprint.com/docs/js-agent#requestid) of each analysis request.

try {
    $result = $client->getEvent($request_id);
    echo "<pre>" . $response->__toString() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **request_id** | **string**| The unique [identifier](https://dev.fingerprint.com/docs/js-agent#requestid) of each analysis request. |

### Return type

[**\Fingerprint\ServerAPI\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getVisits**
> \Fingerprint\ServerAPI\Model\Response getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before)

Get visits by visitorId

This endpoint allows you to get a history of visits for a specific `visitorId`. Use the `visitorId` as a URL path parameter. Only information from the _Identification_ product is returned.  #### Headers  * `Retry-After` — Present in case of `429 Too many requests`. Indicates how long you should wait before making a follow-up request. The value is non-negative decimal integer indicating the seconds to delay after the response is received.

### Example
```php
<?php

require_once(__DIR__ . '/vendor/autoload.php');

const FPJS_API_SECRET = "Your Fingerprint Secret API Key"; // Fingerprint Secret API Key

// Import Fingerprint Classes and Guzzle HTTP Client
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

// Create new Configuration instance with defaultValues, added our API Secret and our Region
$config = Configuration::getDefaultConfiguration(FPJS_API_SECRET, Configuration::REGION_EUROPE);
$client = new FingerprintApi(
    new Client(),
    $config
);

$visitor_id = "visitor_id_example"; // string | Unique identifier of the visitor issued by Fingerprint Pro.
$request_id = "request_id_example"; // string | Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/docs/js-agent#requestid). When you filter visits by `requestId`, only one visit will be returned.
$linked_id = "linked_id_example"; // string | Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/docs/js-agent#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier.
$limit = 56; // int | Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500.
$pagination_key = "pagination_key_example"; // string | Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned.
$before = 789; // int | ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results.

try {
    $result = $client->getVisits($visitor_id, $request_id, $linked_id, $limit, $pagination_key, $before);
    echo "<pre>" . $response->__toString() . "</pre>";
} catch (Exception $e) {
    echo 'Exception when calling FingerprintApi->getVisits: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **visitor_id** | **string**| Unique identifier of the visitor issued by Fingerprint Pro. |
 **request_id** | **string**| Filter visits by `requestId`.   Every identification request has a unique identifier associated with it called `requestId`. This identifier is returned to the client in the identification [result](https://dev.fingerprint.com/docs/js-agent#requestid). When you filter visits by `requestId`, only one visit will be returned. | [optional]
 **linked_id** | **string**| Filter visits by your custom identifier.   You can use [`linkedId`](https://dev.fingerprint.com/docs/js-agent#linkedid) to associate identification requests with your own identifier, for example: session ID, purchase ID, or transaction ID. You can then use this `linked_id` parameter to retrieve all events associated with your custom identifier. | [optional]
 **limit** | **int**| Limit scanned results.   For performance reasons, the API first scans some number of events before filtering them. Use `limit` to specify how many events are scanned before they are filtered by `requestId` or `linkedId`. Results are always returned sorted by the timestamp (most recent first). By default, the most recent 100 visits are scanned, the maximum is 500. | [optional]
 **pagination_key** | **string**| Use `paginationKey` to get the next page of results.   When more results are available (e.g., you requested 200 results using `limit` parameter, but a total of 600 results are available), the `paginationKey` top-level attribute is added to the response. The key corresponds to the `requestId` of the last returned event. In the following request, use that value in the `paginationKey` parameter to get the next page of results:  1. First request, returning most recent 200 events: `GET api-base-url/visitors/:visitorId?limit=200` 2. Use `response.paginationKey` to get the next page of results: `GET api-base-url/visitors/:visitorId?limit=200&paginationKey=1683900801733.Ogvu1j`  Pagination happens during scanning and before filtering, so you can get less visits than the `limit` you specified with more available on the next page. When there are no more results available for scanning, the `paginationKey` attribute is not returned. | [optional]
 **before** | **int**| ⚠️ Deprecated pagination method, please use `paginationKey` instead. Timestamp (in milliseconds since epoch) used to paginate results. | [optional]

### Return type

[**\Fingerprint\ServerAPI\Model\Response**](../Model/Response.md)

### Authorization

[ApiKeyHeader](../../README.md#ApiKeyHeader), [ApiKeyQuery](../../README.md#ApiKeyQuery)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

