<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * LibDogCeo
 *
 * @package App\Libraries
 * @author Lee Benedict F. Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class LibDogCeo
{
    /**
     * @var string
     */
    private $sUrl;

    /**
     * @var string
     */
    private $sCurrentDateTime;

    /**
     * @const string
     */
    const LOG_CATEGORY = 'API_DOG_CEO';

    /**
     * LibDogCeo constructor.
     * @since 2023.08.02
     */
    public function __construct()
    {
        $this->sUrl = config('app.api.dog_ceo');
        $this->sCurrentDateTime = date('Y-m-d H:i:s');
    }

    /**
     * sendRequest
     * @since 2023.08.02
     * @param string $sRoute
     * @return array
     */
    public function sendRequest(string $sRoute) : array
    {
        try {
            $oResponse = Http::get($this->sUrl . $sRoute);
            return $oResponse->json();
        } catch (Exception $mException) {
            $aContext = [
                'status'      => $mException->getCode(),
                'body'        => $mException->getMessage(),
                'dateAndTime' => $this->sCurrentDateTime
            ];

            Log::error(self::LOG_CATEGORY, $aContext);

            return [];
        }
    }
}
