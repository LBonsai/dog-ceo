<?php

namespace App\Http\Controllers;

use App\Http\Requests\DogFormRequest;
use App\Http\Services\DogService;
use Illuminate\Http\JsonResponse;

/**
 * DogController
 *
 * @package App\Http\Controllers
 * @author Lee Benedict Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class DogController extends Controller
{
    /**
     * @var DogService $oDogService
     */
    private DogService $oDogService;

    /**
     * DogController constructor
     * @since 2023.08.02
     */
    public function __construct(DogService $oDogService)
    {
        $this->oDogService = $oDogService;
    }

    /**
     * fetchDog
     * @since 2023.08.02
     * @return JsonResponse
     */
    public function fetchDog() : JsonResponse
    {
        $aResponse = $this->oDogService->fetchDog();
        return response()->json($aResponse['data'], $aResponse['code']);
    }

    /**
     * storeDog
     * @since 2023.08.02
     * @param DogFormRequest $oRequest
     * @return JsonResponse
     */
    public function storeDog(DogFormRequest $oRequest) : JsonResponse
    {
        $aResponse = $this->oDogService->storeDog($oRequest->validated());
        return response()->json($aResponse['data'], $aResponse['code']);
    }

    /**
     * fetchDogById
     * @since 2023.08.02
     * @param int $iId
     * @return JsonResponse
     */
    public function fetchDogById(int $iId) : JsonResponse
    {
        $aResponse = $this->oDogService->fetchDogById($iId);
        return response()->json($aResponse['data'], $aResponse['code']);
    }

    /**
     * updateDog
     * @since 2023.08.02
     * @param DogFormRequest $oRequest
     * @return JsonResponse
     */
    public function updateDog(DogFormRequest $oRequest) : JsonResponse
    {
        $aResponse = $this->oDogService->updateDog($oRequest->validated());
        return response()->json($aResponse['data'], $aResponse['code']);
    }

    /**
     * deleteDog
     * @since 2023.08.02
     * @param int $iId
     * @return JsonResponse
     */
    public function deleteDog(int $iId) : JsonResponse
    {
        $aResponse = $this->oDogService->deleteDog($iId);
        return response()->json($aResponse['data'], $aResponse['code']);
    }
}
