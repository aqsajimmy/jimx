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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            //im using midtrans
            $table->string('transaction_id');
            $table->string('status');
            $table->string('payment_type');
            $table->string('va_number');
            $table->string('bank');
            $table->string('pdf_url');
            $table->string('qr_url');
            $table->string('gross_amount');
            $table->string('currency');
            $table->string('payment_code');
            $table->string('signature_key');
            $table->string('signature_method');
            $table->string('signature');
            $table->string('message');
            $table->string('status_code');
            $table->string('transaction_time');
            $table->string('transaction_status');
            $table->string('settlement_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
