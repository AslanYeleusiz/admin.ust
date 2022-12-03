<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_skidka', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doc_id')->on('doc')->cascadeOnDelete();
            $table->integer('skidka');
//            $table->integer('is_active');
            $table->date('from_date');
            $table->date('to_date');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_skidkas');
    }
};
