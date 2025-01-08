<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->boolean('is_video')->default(false)->after('is_image');
            $table->boolean('is_audio')->default(false)->after('is_video');
            $table->boolean('is_document')->default(false)->after('is_audio');
        });
    }

    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['is_video', 'is_audio', 'is_document']);
        });
    }
};
