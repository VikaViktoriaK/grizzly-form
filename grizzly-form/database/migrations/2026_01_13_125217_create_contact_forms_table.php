<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->id();

            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('middle_name', 100)->nullable();

            $table->date('birth_date');

            $table->string('email')->nullable();

            $table->enum('country_code', ['+375', '+7'])->nullable();
            $table->string('phone', 255)->nullable();

            $table->enum('marital_status', [
                'single',
                'married',
                'divorced',
                'widowed'
            ]);

            $table->text('about')->nullable();

            $table->boolean('agreed');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_forms');
    }
};

