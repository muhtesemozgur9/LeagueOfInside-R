<?php

namespace App\Services;

use App\Models\Team;
use App\Models\Fixture;
use App\Models\MatchResult;
use Illuminate\Support\Collection;

class ChampionshipService
{
    /**
     * Her takım için şampiyonluk olasılığını hesaplar.
     *
     * Hesaplama:
     * - Eğer tüm maçlar oynanmışsa, en yüksek puana sahip takım %100, diğerleri %0.
     * - Eğer maçlar oynanmadıysa,
     *      expected_final_points = current_points + (remaining_matches * avg_points_per_match)
     *      Olasılık, expected_final_points değerinin toplam içindeki payı olarak hesaplanır ve % olarak döndürülür.
     *
     * @return Collection
     */
    public function getChampionshipProbabilities(): Collection
    {
        // Tüm takımları çek
        $teams = Team::all();
        $numTeams = $teams->count();

        if ($numTeams === 0) {
            return collect();
        }

        $pointsMap = [];
        $playedMap = [];
        foreach ($teams as $team) {
            $matchResults = MatchResult::where(function($q) use ($team) {
                $q->where('home_team_id', $team->team_id)
                  ->orWhere('away_team_id', $team->team_id);
            })->get();

            $points = 0;
            $played = $matchResults->count();
            foreach ($matchResults as $mr) {
                if ($mr->home_team_id == $team->team_id) {
                    $points += $mr->home_points;
                } else {
                    $points += $mr->away_points;
                }
            }
            $pointsMap[$team->team_id] = $points;
            $playedMap[$team->team_id] = $played;
        }

        $fixtureCounts = [];
        foreach ($teams as $team) {
            $fixtureCount = Fixture::where('home_team_id', $team->team_id)
                ->orWhere('away_team_id', $team->team_id)
                ->count();
            $fixtureCounts[$team->team_id] = $fixtureCount;
        }

        $expectedFinalPoints = [];
        $avgPointsPerMatch = 1.5;
        foreach ($teams as $team) {
            $teamId = $team->team_id;
            $currentPoints = $pointsMap[$teamId] ?? 0;
            $played = $playedMap[$teamId] ?? 0;
            $total = $fixtureCounts[$teamId] ?? 0;
            $remaining = max(0, $total - $played);
            $expectedFinalPoints[$teamId] = $currentPoints + ($remaining * $avgPointsPerMatch);
        }

        $allPlayed = true;
        foreach ($teams as $team) {
            $teamId = $team->team_id;
            if (($fixtureCounts[$teamId] - ($playedMap[$teamId] ?? 0)) > 0) {
                $allPlayed = false;
                break;
            }
        }

        if ($allPlayed) {
            $maxPoints = max($expectedFinalPoints);
            return $teams->map(function ($team) use ($expectedFinalPoints, $maxPoints) {
                $teamId = $team->team_id;
                $prob = ($expectedFinalPoints[$teamId] == $maxPoints) ? 100 : 0;
                return [
                    'team_id' => $teamId,
                    'team_name' => $team->team_name,
                    'championship_probability' => $prob,
                ];
            });
        } else {
            $sumExpected = array_sum($expectedFinalPoints);
            return $teams->map(function ($team) use ($expectedFinalPoints, $sumExpected, $numTeams) {
                $teamId = $team->team_id;
                $prob = $sumExpected > 0 ? ($expectedFinalPoints[$teamId] / $sumExpected) * 100 : (100 / $numTeams);
                return [
                    'team_id' => $teamId,
                    'team_name' => $team->team_name,
                    'championship_probability' => round($prob, 2),
                ];
            });
        }
    }
}
