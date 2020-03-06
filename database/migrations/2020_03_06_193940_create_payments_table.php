<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('clients')->onDelete('cascade');
            $table->date('payment_date')->nullable();
            $table->date('expires_at');
            $table->integer('clp_usd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
