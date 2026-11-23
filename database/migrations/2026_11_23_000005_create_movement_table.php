<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movement', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('kind')->comment('1=ingreso, 2=gasto');
            $table->decimal('amount', 12, 2);
            $table->date('movement_date');
            $table->string('description');
            $table->foreignId('category_id')->constrained('category')->restrictOnDelete();
            $table->foreignId('payment_method_id')->constrained('payment_method')->restrictOnDelete();
            $table->foreignId('account_id')->constrained('account')->restrictOnDelete();
            $table->foreignId('person_id')->nullable()->constrained('person')->nullOnDelete();
            $table->foreignId('user_id')->constrained('user')->restrictOnDelete();
            $table->timestamps();

            $table->index(['kind', 'movement_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movement');
    }
};
