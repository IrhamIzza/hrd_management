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
        $table->date('birth_date')->nullable();
        $table->string('nip')->nullable();
        $table->text('home_address')->nullable();
        $table->text('work_address')->nullable();
        $table->date('join_date')->nullable();
        $table->string('position')->nullable();
        $table->enum('employment_status', ['tetap', 'kontrak'])->nullable();
        $table->integer('contract_duration')->nullable();
        $table->integer('work_duration_days')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
            'birth_date',
            'nip',
            'home_address',
            'work_address',
            'join_date',
            'position',
            'employment_status',
            'contract_duration',
            'work_duration_days',
        ]);
        });
    }
};
