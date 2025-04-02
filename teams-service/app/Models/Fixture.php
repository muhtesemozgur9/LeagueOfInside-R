<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    protected $primaryKey = 'fixture_id';

    protected $fillable = ['week', 'home_team_id', 'away_team_id'];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function matchResult()
    {
        return $this->hasOne(MatchResult::class, 'fixture_id', 'fixture_id');
    }
}
