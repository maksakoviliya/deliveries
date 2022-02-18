<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->enum('type', ['ip', 'ooo']);
            $table->string('title');

            $table->string('long_title')->nullable();
            $table->string('opf')->nullable();
            $table->string('inn')->nullable();
            $table->string('ogrn')->nullable();
            $table->string('okpo')->nullable();
            $table->string('address')->nullable();
            $table->string('oktmo')->nullable();
            $table->string('okved')->nullable();
            $table->string('pfr')->nullable();
            $table->string('rs')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bik')->nullable();
            $table->string('ks')->nullable();
            $table->string('phone')->nullable();
            $table->string('mail')->nullable();
            $table->string('kpp')->nullable();
            $table->string('okato')->nullable();

            $table->foreignId('tarif_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
