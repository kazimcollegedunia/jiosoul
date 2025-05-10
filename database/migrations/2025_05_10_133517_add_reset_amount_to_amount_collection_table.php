<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResetAmountToAmountCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('amount_collections', function (Blueprint $table) {
            $table->tinyInteger('reset_amount')->default(0)->after('status');
            $table->integer('reset_by')->default(0)->after('reset_amount');
            $table->date('reset_date')->nullable()->after('reset_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('amount_collections', function (Blueprint $table) {
            $table->dropColumn('reset_amount');
            $table->dropColumn('reset_by');
            $table->dropColumn('reset_date');
        });
    }
}
