<?php

namespace App\Http\Controllers;

use App\Http\Services\DogCeoService;
use Illuminate\Http\JsonResponse;

/**
 * DogCeoController
 *
 * @package App\Http\Controllers
 * @author Lee Benedict Baniqued
 * @since 2023.08.02
 * @version 1.0
 */
class DogCeoController extends Controller
{
    /**
     * @var DogCeoService $oDogCeoService
     */
    private DogCeoService $oDogCeoService;

    /**
     * DogCeoController constructor
     * @since 2023.08.02
     */
    public function __construct(DogCeoService $oDogCeoService)
    {
        $this->oDogCeoService = $oDogCeoService;
    }

    /**
     * fetchImage
     * @since 2023.08.02
     * @return JsonResponse
     */
    public function fetchImage() : JsonResponse
    {
        $aResponse = $this->oDogCeoService->fetchImage();
        return response()->json($aResponse['data'], $aResponse['code']);
    }
}
