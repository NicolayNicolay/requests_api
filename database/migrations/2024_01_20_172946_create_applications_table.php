<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('Имя пользователя');
            $table->text('email')->comment('Email пользователя');
            $table->string('status')->default('active')->comment('Статус');
            $table->longText('message')->comment('Сообщение пользователя');
            $table->longText('comment')->nullable()->default(null)->comment('Ответ ответственного лица');
            $table->unsignedBigInteger('user_id')->nullable()->default(null)->comment('Ответственное лицо');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
