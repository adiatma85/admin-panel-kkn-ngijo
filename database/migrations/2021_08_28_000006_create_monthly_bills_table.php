<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyBillsTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tahun');
            $table->string('bulan');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
