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
            // Fields that can be edited by user
            $table->string('email_active')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('nip')->nullable();
            $table->text('home_address')->nullable();
            $table->text('work_address')->nullable();

            // Fields that can only be edited by HRD
            $table->string('position')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('employment_status', ['tetap', 'kontrak'])->nullable();
            $table->integer('contract_duration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_photo',
                'email_active',
                'birth_date',
                'nip',
                'home_address',
                'work_address',
                'position',
                'join_date',
                'employment_status',
                'contract_duration',
            ]);
        });
    }
}; 