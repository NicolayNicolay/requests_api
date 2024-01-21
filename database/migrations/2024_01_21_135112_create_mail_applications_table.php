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
        Schema::create('mail_applications', function (Blueprint $table) {
            $table->id();
            $table->text('text')->comment('Текст сообщения');
            $table->unsignedBigInteger('user_id')->nullable()->default(null)->comment('Ответственное лицо');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('application_id')->nullable()->default(null)->comment('Заявка');
            $table->foreign('application_id')
                ->references('id')->on('applications');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_applications');
    }
};
