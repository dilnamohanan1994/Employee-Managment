<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->binary('logo')->nullable(); // Use binary for storing images
            $table->string('website')->nullable();
            $table->timestamps();
        });

        // The logo size is at least 100x100
        DB::statement('ALTER TABLE companies ADD CONSTRAINT chk_logo_size CHECK (CHAR_LENGTH(logo) >= 100*100)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
