<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface StandingRepositoryInterface
{
    /**
     * Tüm takım sıralamasını (Standings) döndürür.
     *
     * @return Collection
     */
    public function all(): Collection;
}
