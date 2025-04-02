<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class FixtureDTO extends DataTransferObject
{
    public function __construct(
        public int $week,
        public ?int $home_team_id,
        public ?int $away_team_id,
        public ?string $home_team_name = null,
        public ?string $away_team_name = null,
    ) {}
}
