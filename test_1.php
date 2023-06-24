<?php
require_once(__DIR__ . '/vendor/autoload.php');
use Fingerprint\ServerAPI\Api\FingerprintApi;
use Fingerprint\ServerAPI\Configuration;
use GuzzleHttp\Client;

$config = Configuration::getDefaultConfiguration(
  "3cQKAbhDAeh1hGrgxPTt", // Replace with your key
  Configuration::REGION_GLOBAL // Replace with your region
);

$client = new FingerprintApi(
  new Client(),
  $config
);

// Get a specific fingerprinting event
try {
  $response = $client->getEvent("1686735220832.Q5DLcC");
  echo "<pre>" . $response->__toString() . "</pre>";
} catch (Exception $e) {
  echo $e->getMessage(), PHP_EOL;
}
