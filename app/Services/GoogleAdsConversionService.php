<?php

namespace App\Services;

use Google\Ads\GoogleAds\Lib\V13\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\V13\Services\ClickConversion;
use Google\Ads\GoogleAds\V13\Services\ClickConversionUploadServiceClient;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use GuzzleHttp\Client;

class GoogleAdsConversionService
{
    private $customerId;
    private $developerToken;
    private $googleAdsClient;

    public function __construct($customerId, $developerToken, $jsonPath)
    {
        $this->customerId = $customerId;
        $this->developerToken = $developerToken;

        $oAuth2Credential = (new OAuth2TokenBuilder())
            ->fromFile($jsonPath)
            ->build();

        $this->googleAdsClient = (new GoogleAdsClientBuilder())
            ->withOAuth2Credential($oAuth2Credential)
            ->withDeveloperToken($this->developerToken)
            ->build();
    }

    public function sendConversion($gclid, $conversionActionResourceName, $conversionValue, $currencyCode)
    {
        try {
            $conversion = new ClickConversion([
                'gclid' => $gclid,
                'conversion_action' => $conversionActionResourceName,
                'conversion_date_time' => date('Y-m-d H:i:s'),
                'conversion_value' => $conversionValue,
                'currency_code' => $currencyCode,
            ]);

            $conversionService = $this->googleAdsClient->getClickConversionUploadServiceClient();
            $response = $conversionService->uploadClickConversions(
                new \Google\Ads\GoogleAds\V13\Services\UploadClickConversionsRequest([
                    'customer_id' => $this->customerId,
                    'conversions' => [$conversion],
                    'partial_failure' => false,
                ])
            );

            printf("Conversión subida exitosamente. Total: %d\n", count($response->getResults()));
        } catch (\Exception $e) {
            echo "Error al enviar la conversión: " . $e->getMessage();
        }
    }
}
