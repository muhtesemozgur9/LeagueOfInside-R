<?php

namespace App\Services;

use App\Repositories\FixtureRepositoryInterface;
use App\Models\Team;

class FixtureService
{
    public function __construct(
        protected FixtureRepositoryInterface $fixtureRepository
    ) {}

    public function generateAndSaveFixtures(): void
    {
        $this->fixtureRepository->truncate();

        $teams = Team::all();

        if ($teams->count() < 2) {
            throw new \Exception('At least 2 teams are required.');
        }

        $teamIds = $teams->pluck('team_id')->toArray();
        shuffle($teamIds);

        $fixtures = $this->generateFixtures($teamIds);

        foreach ($fixtures as $week => $matches) {
            foreach ($matches as [$home, $away]) {
                $this->fixtureRepository->create([
                    'week' => $week + 1,
                    'home_team_id' => $home,
                    'away_team_id' => $away,
                ]);
            }
        }
    }

    private function generateFixtures(array $teamIds): array
    {
        $hasBye = count($teamIds) % 2 !== 0;
        if ($hasBye) {
            $teamIds[] = null;
        }

        $numWeeks = count($teamIds) - 1;
        $fixtures = [];

        $rotation = $teamIds;
        $fixed = array_shift($rotation);

        for ($round = 0; $round < $numWeeks; $round++) {
            $weekMatches = [];

            $pairs = array_chunk(array_merge([$fixed], $rotation), 2);
            foreach ($pairs as [$home, $away]) {
                if ($home !== null && $away !== null && rand(0,1) === 1) {
                    [$home, $away] = [$away, $home];
                }
                $weekMatches[] = [$home, $away];
            }

            $fixtures[] = $weekMatches;
            array_unshift($rotation, array_pop($rotation));
        }

        $secondLeg = [];
        foreach ($fixtures as $matches) {
            $reversed = [];
            foreach ($matches as [$home, $away]) {
                if ($home !== null && $away !== null) {
                    if (rand(0,1) === 1) {
                        $reversed[] = [$home, $away];
                    } else {
                        $reversed[] = [$away, $home];
                    }
                } else {
                    $reversed[] = [$home ?? $away, null];
                }
            }
            $secondLeg[] = $reversed;
        }

        $allFixtures = array_merge($fixtures, $secondLeg);
        shuffle($allFixtures);
        return $allFixtures;
    }

    public function all(): \Illuminate\Support\Collection
    {
        return $this->fixtureRepository->all();
    }

    public function byWeek(int $week): \Illuminate\Support\Collection
    {
        return $this->fixtureRepository->byWeek($week);
    }

    /**
     * Fixture schedule'ı, takım isimleri ve varsa maç sonuçlarıyla birlikte döndürür.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getFixtureSchedule(): \Illuminate\Support\Collection
    {
        return $this->fixtureRepository->getFixtureSchedule();
    }

    public function getLatestPlayedWeekSchedule(): array
    {
    $schedule = $this->fixtureRepository->getFixtureSchedule();

    $playedWeeks = $schedule->filter(function ($weekObj) {
        $playedMatches = $weekObj['matches']->filter(function ($match) {
            return $match['home_goals'] !== null && $match['away_goals'] !== null;
        });
        return $playedMatches->isNotEmpty();
    });

    if ($playedWeeks->isNotEmpty()) {
        $latestWeek = $playedWeeks->sortByDesc('week')->first();
        return $latestWeek;
    } else {
        return $schedule->first();
    }
}

}
