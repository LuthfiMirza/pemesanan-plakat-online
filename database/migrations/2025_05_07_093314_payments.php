<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->string('bank_name');
            $table->decimal('amount', 10, 2);
            $table->string('custom_design')->nullable();
            $table->text('design_notes')->nullable();
            $table->string('proof_of_payment');
            $table->enum('payment_method', ['bank', 'ewallet']);
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};