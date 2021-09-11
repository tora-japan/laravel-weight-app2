<?php
/*
 * CreateWeightsTable.php
 *
 * Copyright (c) 2021 tora-japan (s.noda)
 *
 * Released under the MIT license.
 * see https://opensource.org/licenses/MIT
 *
 */


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weights', function (Blueprint $table) {
            $table->string('uid')->unique();  // ユニークID
            $table->unsignedBigInteger('id'); // ユーザーID
            $table->date('date');             // 日付
            $table->double('weight',5,1);     // 体重
            $table->primary('uid');           // ユニークIDをプライマリーキーにする
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weights');
    }
}
