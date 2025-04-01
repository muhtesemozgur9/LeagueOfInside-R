<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class TeamDTO extends DataTransferObject
{
    public int $team_id;
    public string $team_name;
    public int $attack;
    public int $defense;
    public int $motivation;
    public string $created_at;
    public string $updated_at;
}
