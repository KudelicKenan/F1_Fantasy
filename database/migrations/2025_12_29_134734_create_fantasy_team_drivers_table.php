<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fantasy_team_drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fantasy_team_id')->constrained('fantasy_teams')->onDelete('cascade');
            $table->foreignId('driver_id')->constrained('drivers')->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->timestamps();
            
            // Sprečava duplikate - jedan vozač može biti samo u jednom fantasy timu
            $table->unique(['fantasy_team_id', 'driver_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fantasy_team_drivers');
    }
};
