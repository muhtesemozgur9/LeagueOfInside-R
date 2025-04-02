<?php

namespace App\Repositories;

use App\Models\Fixture;
use App\DTO\FixtureDTO;
use Illuminate\Support\Collection;

class EloquentFixtureRepository implements FixtureRepositoryInterface
{
    public function all(): Collection
    {
        return Fixture::with(['homeTeam', 'awayTeam'])->get()
            ->map(fn ($fixture) => new FixtureDTO(
                week: $fixture->week,
                home_team_id: $fixture->home_team_id,
                away_team_id: $fixture->away_team_id,
                home_team_name: optional($fixture->homeTeam)->team_name,
                away_team_name: optional($fixture->awayTeam)->team_name
            ));
    }

    public function byWeek(int $week): Collection
    {
        return Fixture::with(['homeTeam', 'awayTeam'])->where('week', $week)->get()
            ->map(fn ($fixture) => new FixtureDTO(
                week: $fixture->week,
                home_team_id: $fixture->home_team_id,
                away_team_id: $fixture->away_team_id,
                home_team_name: optional($fixture->homeTeam)->team_name,
                away_team_name: optional($fixture->awayTeam)->team_name
            ));
    }

    public function create(array $data): Fixture
    {
        return Fixture::create($data);
    }

    public function truncate(): void
    {
        Fixture::truncate();
    }

     /**
     * Fixture schedule verilerini, takım isimleri ve (varsa) maç sonuçları ile birlikte haftalara göre gruplar.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFixtureSchedule(): Collection
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam', 'matchResult'])
            ->orderBy('week')
            ->get();

        // Her fixture kaydını hafta bazında gruplandıralım:
        $grouped = $fixtures->groupBy('week')->map(function ($fixtures, $week) {
            return [
                'week'    => (int)$week,
                'matches' => $fixtures->map(function ($fixture) {
                    return [
                        'home_team'  => $fixture->homeTeam ? $fixture->homeTeam->team_name : null,
                        'away_team'  => $fixture->awayTeam ? $fixture->awayTeam->team_name : null,
                        'home_goals' => $fixture->matchResult ? $fixture->matchResult->home_goals : null,
                        'away_goals' => $fixture->matchResult ? $fixture->matchResult->away_goals : null,
                    ];
                })->values(),
            ];
        })->values();

        return $grouped;
    }
}
