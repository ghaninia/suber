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

            $table->bigInteger("attacks_count")->default(0);
            $table->bigInteger("latest_count_pages")->default(0);
            $table->bigInteger("current_attack_page")->nullable();

            $table->string("base_url", 255)->unique();
            $table->text("driver_class");

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
