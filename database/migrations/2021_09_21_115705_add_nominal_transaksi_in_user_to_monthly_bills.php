<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNominalTransaksiInUserToMonthlyBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_to_monthly_bills', function (Blueprint $table) {
            $table->integer('nominal_pembayaran')->after('metode_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_to_monthly_bills', function (Blueprint $table) {
            $table->dropColumn('nominal_pembayaran');
        });
    }
}
