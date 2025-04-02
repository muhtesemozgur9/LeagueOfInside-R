<?php

namespace App\Services;

use App\Models\Fixture;
use App\Models\Team;
use App\Models\MatchResult;
use App\Models\Standing;
use Illuminate\Support\Facades\DB;

class MatchSimulationService
{
    /**
     * Belirtilen hafta için maç simülasyonunu gerçekleştirir.
     * Eğer $week parametresi null verilirse, tüm haftaları simüle eder.
     */
    public function simulate(?int $week = null): void
    {
        DB::transaction(function () use ($week) {
            $query = Fixture::query();
            if (!is_null($week)) {
                $query->where('week', $week);
            }
            $fixtures = $query->get();

            foreach ($fixtures as $fixture) {
                $existing = MatchResult::where('fixture_id', $fixture->getKey())
                    ->where('home_team_id', $fixture->home_team_id)
                    ->where('away_team_id', $fixture->away_team_id)
                    ->first();
                if ($existing) {
                    continue;
                }

                $homeTeam = Team::find($fixture->home_team_id);
                $awayTeam = Team::find($fixture->away_team_id);

                $homeExpected = ($homeTeam->attack * ($homeTeam->motivation / 100)) / ($awayTeam->defense + 1);
                $awayExpected = ($awayTeam->attack * ($awayTeam->motivation / 100)) / ($homeTeam->defense + 1);

                $homeGoals = max(0, round($homeExpected + (mt_rand(-50, 50) / 100)));
                $awayGoals = max(0, round($awayExpected + (mt_rand(-50, 50) / 100)));

                if ($homeGoals > $awayGoals) {
                    $homePoints = 3;
                    $awayPoints = 0;
                } elseif ($homeGoals < $awayGoals) {
                    $homePoints = 0;
                    $awayPoints = 3;
                } else {
                    $homePoints = $awayPoints = 1;
                }

                MatchResult::create([
                    'fixture_id' => $fixture->getKey(),
                    'home_team_id' => $fixture->home_team_id,
                    'away_team_id' => $fixture->away_team_id,
                    'home_goals' => $homeGoals,
                    'away_goals' => $awayGoals,
                    'home_points' => $homePoints,
                    'away_points' => $awayPoints,
                ]);

                // Standings tablosunu güncelleyelim:
                $this->updateStandings($homeTeam->team_id, $homeGoals, $awayGoals, $homePoints);
                $this->updateStandings($awayTeam->team_id, $awayGoals, $homeGoals, $awayPoints);
            }
        });
    }

    /**
     * Verilen takım için Standings tablosunu günceller.
     *
     * @param int $teamId Takım ID
     * @param int $goalsFor Atılan gol
     * @param int $goalsAgainst Yenen gol
     * @param int $points O maçtan alınan puan
     */
    protected function updateStandings(int $teamId, int $goalsFor, int $goalsAgainst, int $points): void
    {
        $standing = Standing::firstOrNew(['team_id' => $teamId]);
        $standing->played = ($standing->played ?? 0) + 1;
        $standing->goals_for = ($standing->goals_for ?? 0) + $goalsFor;
        $standing->goals_against = ($standing->goals_against ?? 0) + $goalsAgainst;
        $standing->goal_difference = ($standing->goals_for - $standing->goals_against);
        $standing->points = ($standing->points ?? 0) + $points;

        if ($goalsFor > $goalsAgainst) {
            $standing->wins = ($standing->wins ?? 0) + 1;
        } elseif ($goalsFor < $goalsAgainst) {
            $standing->losses = ($standing->losses ?? 0) + 1;
        } else {
            $standing->draws = ($standing->draws ?? 0) + 1;
        }

        $standing->save();
    }

    public function resetSimulations(): void
    {
        MatchResult::truncate();
        
        Standing::truncate();
    }

}
