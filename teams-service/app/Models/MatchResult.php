<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchResult extends Model
{
    protected $table = 'match_results';

    protected $fillable = [
        'fixture_id',
        'home_team_id',
        'away_team_id',
        'home_goals',
        'away_goals',
        'home_points',
        'away_points',
    ];

    /**
     * Ev sahibi takım ilişkisi.
     */
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * Deplasman takım ilişkisi.
     */
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
