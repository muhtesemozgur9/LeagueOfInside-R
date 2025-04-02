<?php

namespace App\Services;

use App\Repositories\StandingRepositoryInterface;
use Illuminate\Support\Collection;

class StandingService
{

    public function __construct(protected StandingRepositoryInterface $standingRepo) { }

    /**
     * Tüm takım sıralamasını döndürür.
     */
    public function getAllStandings(): Collection
    {
        return $this->standingRepo->all();
    }
}
