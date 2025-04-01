<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use App\Http\Resources\TeamResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Teams",
 *     description="Takım işlemleri"
 * )
 */
class TeamController extends Controller
{
    protected TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Takım listesini döndürür.
     *
     * @OA\Get(
     *     path="/api/teams",
     *     tags={"Teams"},
     *     summary="Tüm takımları getirir",
     *     @OA\Response(
     *         response=200,
     *         description="Takım verileri",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Team")
     *         )
     *     )
     * )
     *
     * @return TeamResource
     */
    public function index(): TeamResource
    {
        $teams = $this->teamService->getAllTeams();

        return new TeamResource($teams);
    }
}
