<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            $table->string("name")->nullable();

            $table->bigInteger("attacks_count");
            $table->bigInteger("current_count_pages");
            $table->bigInteger("previous_count_pages");
            $table->bigInteger("current_attack_page");

            $table->string("base_url", 255)->unique();
            $table->text("driver_class");

            $table->text("current_page_link")->nullable() ;
            $table->text("previous_page_link")->nullable() ;
            $table->text("next_page_link")->nullable() ;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
};
