<?php

namespace App\Http\Services;

use App\Libraries\LibDogCeo;

/**
 * DogCeoService
 *
 * @package App\Http\Services
 * @author Lee Benedict F. Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class DogCeoService
{
    /**
     * @var LibDogCeo $oLibDogCeo
     */
    private LibDogCeo $oLibDogCeo;

    /**
     * DogCeoService constructor
     * @since 2023.08.02
     */
    public function __construct(LibDogCeo $oLibDogCeo)
    {
        $this->oLibDogCeo = $oLibDogCeo;
    }

    /**
     * fetchImage
     * @since 2023.08.02
     * @return array
     */
    public function fetchImage() : array
    {
        $aResponse = $this->oLibDogCeo->sendRequest('breeds/image/random');
        if (empty($aResponse) === true || $aResponse['status'] !== 'success') {
            return [
                'code' => $aResponse['code'],
                'data' => [
                    'message' => 'There is an error while requesting to API. Please try again later.'
                ]
            ];
        }

        return [
            'code' => 200,
            'data' => $aResponse['message']
        ];
    }
}
