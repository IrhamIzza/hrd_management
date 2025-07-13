<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('archived_pengumuman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('pengumuman_id');
            $table->boolean('is_read')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pengumuman_id')->references('id')->on('pengumuman')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('archived_pengumuman');
    }
}; 