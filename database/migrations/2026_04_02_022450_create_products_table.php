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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');         // Хоолны нэр
        $table->string('category');     // Ангилал (bagts, pizza, undaa, nemelt)
        $table->integer('price');       // Үнэ
        $table->string('image')->nullable(); // Зурагны зам эсвэл URL
        $table->text('description')->nullable(); // Тайлбар
        $table->timestamps();           // Үүсгэсэн, зассан хугацаа
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
