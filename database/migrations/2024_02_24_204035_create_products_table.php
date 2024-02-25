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
            $table->increments('intProductDataId');
            $table->string('strProductDataCode', 50);
            $table->string('strProductName', 50);
            $table->string('strProductDesc', 255);
            $table->integer('intProductStock');
            $table->decimal('decProductCost', 10, 2)->nullable();
            $table->dateTime('dtmAdded')->useCurrent();
            $table->dateTime('dtmDiscontinued')->nullable()->default(null);
            $table->timestamp('stmTimestamp')->useCurrent()->useCurrentOnUpdate();
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
