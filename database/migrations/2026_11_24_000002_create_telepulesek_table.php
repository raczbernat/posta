<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('telepulesek', function (Blueprint $table) {
            $table->id();
            $table->string('irsz', 4)->index();
            $table->string('nev')->index();
            $table->foreignId('megye_id')->constrained('megyek')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('telepulesek');
    }
};
