<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vendor_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('expense_number')->unique();
            $table->string('category')->nullable();
            $table->date('expense_date');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('payment_method')->default('cash');
            $table->string('reference_number')->nullable();
            $table->string('status')->default('paid');
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
