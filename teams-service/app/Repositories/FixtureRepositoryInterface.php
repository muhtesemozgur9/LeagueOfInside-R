<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface FixtureRepositoryInterface
{
    public function all(): Collection;
    public function byWeek(int $week): Collection;
    public function create(array $data): mixed;
    public function truncate(): void;
    public function getFixtureSchedule(): Collection;
}
