<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('payer_id');
            $table->foreignUuid('payee_id');
            $table->bigInteger('value');
            $table->timestamps();

            $table->foreign('payer_id')
                ->references('id')
                ->on('users');

            $table->foreign('payee_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_payer_id_foreign');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_payee_id_foreign');
        });

        Schema::dropIfExists('transfers');
    }
}
