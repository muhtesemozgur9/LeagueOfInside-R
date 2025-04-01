<?php

namespace App\Repositories;

use App\Models\Team;
use App\DTO\TeamDTO;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class EloquentTeamRepository implements TeamRepositoryInterface
{
    protected string $cacheKey = 'teams.all';
    protected int $cacheTime = 60;

    public function all(): Collection
    {
        return Cache::remember($this->cacheKey, $this->cacheTime, function () {
            $teams = Team::all();

            return $teams->map(function ($team) {
                return new TeamDTO([
                    'team_id'    => $team->team_id,
                    'team_name'  => $team->team_name,
                    'attack'     => $team->attack,
                    'defense'    => $team->defense,
                    'motivation' => $team->motivation,
                    'created_at' => $team->created_at->toDateTimeString(),
                    'updated_at' => $team->updated_at->toDateTimeString(),
                ]);
            });
        });
    }
}
