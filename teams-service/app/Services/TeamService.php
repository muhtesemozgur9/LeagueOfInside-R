<?php

namespace App\Services;

use App\Repositories\TeamRepositoryInterface;
use Illuminate\Support\Collection;

class TeamService
{
    protected TeamRepositoryInterface $teamRepository;

    public function __construct(TeamRepositoryInterface $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Tüm takım verilerini DTO koleksiyonu olarak döndürür.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllTeams(): Collection
    {
        return $this->teamRepository->all();
    }
}
