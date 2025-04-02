<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\StandingService;

class StandingsController extends Controller
{
    protected StandingService $standingService;

    public function __construct(StandingService $standingService)
    {
        $this->standingService = $standingService;
    }

    /**
     * Tüm takım sıralamasını döndürür.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/standings",
     *     summary="Get all team standings",
     *     tags={"Standings"},
     *     @OA\Response(
     *         response=200,
     *         description="Standings list",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $standings = $this->standingService->getAllStandings();
        return response()->json(['data' => $standings]);
    }
}
