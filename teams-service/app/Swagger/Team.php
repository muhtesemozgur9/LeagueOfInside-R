/**
 * @OA\Schema(
 *     schema="Team",
 *     type="object",
 *     title="Team",
 *     required={"team_id", "team_name", "attack", "defense", "motivation"},
 *     @OA\Property(
 *         property="team_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="team_name",
 *         type="string",
 *         example="Liverpool"
 *     ),
 *     @OA\Property(
 *         property="attack",
 *         type="integer",
 *         example=80
 *     ),
 *     @OA\Property(
 *         property="defense",
 *         type="integer",
 *         example=70
 *     ),
 *     @OA\Property(
 *         property="motivation",
 *         type="integer",
 *         example=95
 *     )
 * )
 */
