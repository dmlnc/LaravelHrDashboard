<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantVacancyPivotTable extends Migration
{
    public function up()
    {
        Schema::create('restaurant_vacancy', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restaurant_id');
            $table->unsignedBigInteger('vacancy_id');
            $table->decimal('price_per_hour', 8, 2);
            $table->timestamps();

            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('restaurant_vacancy');
    }
}
