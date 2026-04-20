<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')
                ->unique();
            $table->boolean('is_system')
                ->default(false);
            $table->foreignId('user_id')
                ->constrained('users')
                ->nullable()
                ->onDelete('set null');
            $table->integer('position')
                ->default(0);
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_name');
            $table->string('type', 20)->index();
            $table->string('mime_type', 100);
            $table->string('extension', 10);
            $table->foreignId('user_id')
                ->constrained('users')
                ->nullable()
                ->onDelete('set null');
            $table->string('path')
                ->unique();
            $table->unsignedBigInteger('size')
                ->nullable();
            $table->text('description')
                ->nullable();
            $table->string('alt_text')
                ->nullable();
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('album_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('media_id')
                ->constrained()
                ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['album_id', 'media_id']);
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('albums');
        Schema::dropIfExists('media');
        Schema::dropIfExists('album_media');
    }
};
