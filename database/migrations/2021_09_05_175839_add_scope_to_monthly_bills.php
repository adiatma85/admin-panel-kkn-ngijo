<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScopeToMonthlyBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthly_bills', function (Blueprint $table) {
            $table->unsignedBigInteger('scope_id')->nullable();
            $table->foreign('scope_id', 'monthly_bills_to_scope_fk_1')->references('id')->on('scopes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('monthly_bills', function (Blueprint $table) {
            $table->dropForeign('monthly_bills_to_scope_fk_1');
            $table->dropColumn('scope_id');
        });
    }
}
