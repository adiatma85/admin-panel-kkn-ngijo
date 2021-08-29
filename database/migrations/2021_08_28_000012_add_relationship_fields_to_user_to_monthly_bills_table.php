<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserToMonthlyBillsTable extends Migration
{
    public function up()
    {
        Schema::table('user_to_monthly_bills', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_4741363')->references('id')->on('users');
            $table->unsignedBigInteger('monthly_bill_id')->nullable();
            $table->foreign('monthly_bill_id', 'monthly_bill_fk_4741373')->references('id')->on('monthly_bills');
        });
    }
}
