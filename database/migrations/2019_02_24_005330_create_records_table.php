<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id')->comment('域名ID');
            $table->string('type', 16)->comment('类型');
            $table->string('record', 32)->comment('记录');
            $table->string('content')->comment('记录值');
            $table->string('remark')->nullable()->comment('备注');
            $table->timestamps();
            $table->unique(['domain_id', 'type', 'record'], 'domain_record');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
