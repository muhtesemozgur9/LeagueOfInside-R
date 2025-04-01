<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface TeamRepositoryInterface
{
    /**
     * Tüm takım verilerini DTO koleksiyonu olarak döndür.
     *
     * @return \Illuminate\Support\Collection|TeamDTO[]
     */
    public function all(): Collection;
}
