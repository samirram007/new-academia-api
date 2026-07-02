<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use League\CommonMark\Node\Block\Document;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->enum('document_type',['folder','image','doc','pdf'])->nullable();
            $table->string('path')->nullable();
            $table->string('name');
            $table->string('original_name')->nullable();
            $table->string('caption')->nullable();
            $table->string('description')->nullable();
            $table->string('extension')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('size')->nullable();
            $table->boolean('is_private')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->text('tags')->nullable();

            $table->unsignedBigInteger('cover_image_id')->nullable();
            $table->timestamps();
        });
        Schema::create('documents_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('folder_id');
            $table->unique(['document_id', 'folder_id']);
            // Define foreign keys
            $table->foreign('document_id')
                ->references('id')
                ->on('documents')
                ->where('document_type', '<>', 'folder')
                ->onDelete('cascade');

            $table->foreign('folder_id')
                ->references('id')
                ->on('documents')
                ->where('document_type', '=', 'folder')
                ->onDelete('cascade');

            $table->timestamps();
        });
        Schema::create('shared_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('document_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');

        $table->foreign('document_id')
            ->references('id')
            ->on('documents')
            ->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
