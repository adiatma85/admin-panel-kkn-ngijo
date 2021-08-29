<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToMonthlyBillToBillsTable extends Migration
{
    public function up()
    {
        Schema::table('monthly_bill_to_bills', function (Blueprint $table) {
            $table->unsignedBigInteger('bill_id')->nullable();
            $table->foreign('bill_id', 'bill_fk_4741369')->references('id')->on('bills');
            $table->unsignedBigInteger('monthly_bill_id')->nullable();
            $table->foreign('monthly_bill_id', 'monthly_bill_fk_4741374')->references('id')->on('monthly_bills');
        });
    }
}
