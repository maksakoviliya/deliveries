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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid()->nullable();
            $table->enum('type', ['car', 'foot']);
            $table->unsignedBigInteger('recipient_id')->nullable();
            $table->date('delivery_date');
            $table->boolean('today')->default(false);
            $table->json('delivery_interval');
            $table->float('assessed_value');
            $table->float('weight');
            $table->float('price');
            $table->integer('quantity');
            $table->boolean('cod')->default(false);
            $table->float('cod_price')->nullable();
            $table->enum('payment_type', ['cash', 'card']);
            $table->text('comment')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->enum('status', ['processing', 'work', 'delivered', 'undelivered'])->default('processing');
            $table->enum('payment', ['pending', 'payed'])->default('pending');
            $table->foreignId('act_id')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
};
