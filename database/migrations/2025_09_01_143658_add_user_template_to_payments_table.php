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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->nullable()->constrained()->onDelete('cascade');
            
            // Make some fields nullable for Duitku compatibility
            $table->string('va_number')->nullable()->change();
            $table->string('bank')->nullable()->change();
            $table->string('pdf_url')->nullable()->change();
            $table->string('qr_url')->nullable()->change();
            $table->string('payment_code')->nullable()->change();
            $table->string('signature_key')->nullable()->change();
            $table->string('signature_method')->nullable()->change();
            $table->string('signature')->nullable()->change();
            $table->string('message')->nullable()->change();
            $table->string('status_code')->nullable()->change();
            $table->string('settlement_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['template_id']);
            $table->dropColumn(['user_id', 'template_id']);
        });
    }
};
