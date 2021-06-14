<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEzshipOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ezship_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable()->comment('商店訂單編號');
            $table->string('sn_id')->nullable()->comment('店到店編號。若訂單無法建立，會回傳八個零');
            $table->string('order_status')->nullable()->comment('訂單狀態');
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
        Schema::dropIfExists('ezship_orders');
    }
}
