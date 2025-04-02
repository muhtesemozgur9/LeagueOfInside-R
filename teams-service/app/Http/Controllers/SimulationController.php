<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\MatchSimulationService;

class SimulationController extends Controller
{
    protected MatchSimulationService $simulationService;

    public function __construct(MatchSimulationService $simulationService)
    {
        $this->simulationService = $simulationService;
    }

    /**
     * Simulate match results for a given week or all weeks.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/simulate",
     *     summary="Simulate match results",
     *     tags={"Simulation"},
     *     @OA\Parameter(
     *         name="week",
     *         in="query",
     *         description="Week number to simulate. If not provided, all weeks are simulated.",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Simulation completed successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Match simulation completed successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Simulation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Simulation error: [error details]")
     *         )
     *     )
     * )
     */
    public function simulateMatches(Request $request): JsonResponse
    {
        $week = $request->query('week');
        try {
            $this->simulationService->simulate($week ? (int)$week : null);
            return response()->json(['message' => 'Match simulation completed successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Simulation error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Reset simulation data (match results and standings).
     *
     * @return JsonResponse
     *
     * @OA\Post(
     *     path="/api/simulate/reset",
     *     summary="Reset simulation data",
     *     tags={"Simulation"},
     *     @OA\Response(
     *         response=200,
     *         description="Simulation reset successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Simulation reset successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Simulation reset error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Simulation reset error: [error details]")
     *         )
     *     )
     * )
     */
    public function reset(): JsonResponse
    {
        try {
            $this->simulationService->resetSimulations();
            return response()->json(['message' => 'Simulation reset successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Simulation reset error: ' . $e->getMessage()], 500);
        }
    }
}
