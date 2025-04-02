<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('match_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fixture_id');

            //$table->unsignedInteger('week');
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('away_team_id');
            $table->integer('home_goals')->default(0);
            $table->integer('away_goals')->default(0);
            $table->unsignedInteger('home_points')->default(0);
            $table->unsignedInteger('away_points')->default(0);
            $table->timestamps();

            $table->foreign('home_team_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
            $table->foreign('away_team_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
        });

        Schema::create('standings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('team_id')->unique();
            $table->unsignedInteger('played')->default(0);
            $table->unsignedInteger('wins')->default(0);
            $table->unsignedInteger('draws')->default(0);
            $table->unsignedInteger('losses')->default(0);
            $table->integer('goals_for')->default(0);
            $table->integer('goals_against')->default(0);
            $table->integer('goal_difference')->default(0);
            $table->unsignedInteger('points')->default(0);
            $table->timestamps();

            $table->foreign('team_id')
                  ->references('team_id')->on('teams')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
        Schema::dropIfExists('match_results');
    }
};
