<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetodePembayaranInUserToMonthlyBill extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_to_monthly_bills', function (Blueprint $table) {
            $table->string('metode_pembayaran')->after('status_pembayaran');
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
            $table->dropColumn('metode_pembayaran');
        });
    }
}
