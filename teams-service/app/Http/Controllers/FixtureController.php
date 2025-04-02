<?php

namespace App\Http\Controllers;

use App\Services\FixtureService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function __construct(
        protected FixtureService $fixtureService
    ) {}

    /**
     * Generate all fixtures from current teams.
     *
     * @OA\Post(
     *     path="/api/fixtures/generate",
     *     summary="Generate full fixture schedule",
     *     tags={"Fixtures"},
     *     @OA\Response(
     *         response=200,
     *         description="Fixtures successfully generated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error generating fixtures"
     *     )
     * )
     */
    public function generate(): JsonResponse
    {
        try {
            $this->fixtureService->generateAndSaveFixtures();
            return response()->json(['message' => 'Fixtures generated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get fixture schedule with team names and match results (if available).
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/fixtures/schedule",
     *     summary="Get fixture schedule",
     *     tags={"Fixtures"},
     *     @OA\Response(
     *         response=200,
     *         description="Fixture schedule data",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function schedule(): JsonResponse
    {
        $schedule = $this->fixtureService->getFixtureSchedule();
        return response()->json(['data' => $schedule]);
    }

    /**
     * Get the latest played week schedule.
     *
     * If no matches have been played, returns the first week schedule.
     *
     * @return JsonResponse
     *
     * @OA\Get(
     *     path="/api/fixtures/schedule/latest",
     *     summary="Get latest played week schedule, or first week if none played",
     *     tags={"Fixtures"},
     *     @OA\Response(
     *         response=200,
     *         description="Latest played week schedule",
     *         @OA\JsonContent(type="object")
     *     )
     * )
     */
    public function latestSchedule(): JsonResponse
    {
        $latest = $this->fixtureService->getLatestPlayedWeekSchedule();
        return response()->json(['data' => $latest]);
    }
}
