<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->increments('fixture_id');
            $table->unsignedInteger('week');
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('away_team_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('home_team_id')->references('team_id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('team_id')->on('teams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
