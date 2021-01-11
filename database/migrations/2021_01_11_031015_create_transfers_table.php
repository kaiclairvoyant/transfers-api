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
            $table->foreignUuid('sender_id');
            $table->foreignUuid('receiver_id');
            $table->bigInteger('value');

            $table->foreign('sender_id')
                ->references('id')
                ->on('users');

            $table->foreign('receiver_id')
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
            $table->dropForeign('transfers_sender_id_foreign');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_receiver_id_foreign');
        });

        Schema::dropIfExists('transfers');
    }
}
