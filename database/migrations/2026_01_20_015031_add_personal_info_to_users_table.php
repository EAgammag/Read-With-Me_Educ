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
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('email');
            $table->integer('age')->nullable()->after('birthdate');
            $table->enum('sex', ['male', 'female'])->nullable()->after('age');
            $table->string('year_level')->nullable()->after('sex');
            $table->string('section')->nullable()->after('year_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['birthdate', 'age', 'sex', 'year_level', 'section']);
        });
    }
};
