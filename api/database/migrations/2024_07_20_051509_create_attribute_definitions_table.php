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
        Schema::create('attribute_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_definition_name');
            $table->string('attribute_definition_short_name');
            $table->foreignId('attribute_category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('attribute_group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('attribute_unit_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('priority');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_definitions');
    }
};
