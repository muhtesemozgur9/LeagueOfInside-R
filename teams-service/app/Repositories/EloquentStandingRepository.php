<?php

namespace App\Repositories;

use App\Models\Standing;
use App\Models\Team;
use Illuminate\Support\Collection;

class EloquentStandingRepository implements StandingRepositoryInterface
{
    public function all(): Collection
    {
        $standings = Standing::with('team')
            ->orderByDesc('points')
            ->orderByDesc('goal_difference')
            ->orderByDesc('goals_for')
            ->get();

        return $standings->map(function ($row) {
            return [
                'team_id'         => $row->team_id,
                'team_name'       => $row->team ? $row->team->team_name : null,
                'played'          => $row->played,
                'wins'            => $row->wins,
                'draws'           => $row->draws,
                'losses'          => $row->losses,
                'goals_for'       => $row->goals_for,
                'goals_against'   => $row->goals_against,
                'goal_difference' => $row->goal_difference,
                'points'          => $row->points,
            ];
        });
    }
}
