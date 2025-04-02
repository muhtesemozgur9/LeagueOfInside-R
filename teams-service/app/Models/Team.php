<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Team",
 *     title="Team",
 *     description="Takım modeli",
 *     @OA\Property(property="team_id", type="integer", format="int64", example=1),
 *     @OA\Property(property="team_name", type="string", example="Beşiktaş"),
 * )
 */
class Team extends Model
{
    protected $primaryKey = 'team_id';
    protected $table = 'teams';

    protected $fillable = [
        'team_name',
        'attack',
        'defense',
        'motivation'
    ];

    public function standing()
    {
        return $this->hasOne(Standing::class, 'team_id');
    }
}
