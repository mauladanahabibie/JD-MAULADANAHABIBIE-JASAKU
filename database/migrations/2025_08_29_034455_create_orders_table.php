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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('mitra_id')->constrained('users')->onDelete('cascade');
            $table->text('description');
            $table->decimal('price', 15, 2); 
            $table->string('status')->default('belum_bayar');
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
