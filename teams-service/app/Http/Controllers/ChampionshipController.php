<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\ChampionshipService;

class ChampionshipController extends Controller
{
    public function __construct(protected ChampionshipService $championshipService) {}

    /**
     * Get championship probabilities for all teams.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/championship-probabilities",
     *     summary="Get championship probabilities for each team",
     *     tags={"Championship"},
     *     @OA\Response(
     *         response=200,
     *         description="Championship probabilities",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="team_id", type="integer"),
     *                      @OA\Property(property="team_name", type="string"),
     *                      @OA\Property(property="championship_probability", type="number", format="float")
     *                  )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $data = $this->championshipService->getChampionshipProbabilities();
        return response()->json(['data' => $data]);
    }
}
