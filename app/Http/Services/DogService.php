<?php

namespace App\Http\Services;

use App\Models\DogModel;

/**
 * DogService
 *
 * @package App\Http\Services
 * @author Lee Benedict F. Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class DogService
{
    /**
     * @var DogModel $oDogModel
     */
    private DogModel $oDogModel;

    /**
     * DogService constructor.
     * @since 2023.08.02
     */
    public function __construct(DogModel $oDogModel)
    {
        $this->oDogModel = $oDogModel;
    }

    /**
     * fetchDog
     * @since 2023.08.02
     * @return array
     */
    public function fetchDog() : array
    {
        $aResponseData = $this->oDogModel->fetchDog();
        if (empty($aResponseData) === true) {
            return [
                'code' => 404,
                'data' => [
                    'message' => 'No data found.'
                ]
            ];
        }

        return [
            'code' => 200,
            'data' => $aResponseData
        ];
    }

    /**
     * fetchDogById
     * @since 2023.08.02
     * @param int $iId
     * @return array
     */
    public function fetchDogById(int $iId) : array
    {
        return [
            'code' => 200,
            'data' => $this->oDogModel->fetchDogById($iId)
        ];
    }

    /**
     * storeDog
     * @since 2023.08.02
     * @param array $aFormData
     * @return array
     */
    public function storeDog(array $aFormData) : array
    {
        $aFormData['created_at'] = now();
        $bResponseData = $this->oDogModel->storeDog($aFormData);
        if ($bResponseData === false) {
            return [
                'code' => 500,
                'data' => [
                    'message' => 'The new data could not be registered. Please try again.'
                ]
            ];
        }

        return [
            'code' => 200,
            'data' => $bResponseData
        ];
    }

    /**
     * updateDog
     * @since 2023.08.02
     * @param array $aFormData
     * @return array
     */
    public function updateDog(array $aFormData) : array
    {
        $aFormData['updated_at'] = now();
        $iId = $aFormData['id'];
        unset($aFormData['id']);
        $bResponse = $this->oDogModel->updateDog($iId, $aFormData);
        if ($bResponse === false) {
            return [
                'code' => 500,
                'data' => [
                    'message' => 'The data could not be updated. Please try again.'
                ]
            ];
        }

        return [
            'code' => 200,
            'data' => $bResponse
        ];
    }

    /**
     * deleteDog
     * @since 2023.08.02
     * @param int $iId
     * @return array
     */
    public function deleteDog(int $iId) : array
    {
        return [
            'code' => 200,
            'data' => $this->oDogModel->deleteDog($iId)
        ];
    }
}
