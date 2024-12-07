<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->restricted('users', 'id');
            $table->string("sender_email");
            $table->string("sender_name");
            $table->string("sender_phone");
            $table->string("receiver_name");
            $table->string("receiver_phone");
            $table->string("delivery_option");
            $table->date("delivery_date");
            $table->string("delivery_time");
            $table->string("province");
            $table->string("city");
            $table->string("postal_code");
            $table->string("delivery_address");
            $table->string("payment_method");
            $table->string("subtotal");
            $table->string("delivery_cost");
            $table->string("service_fee");
            $table->string("total_price");
            $table->string("delivery_status");
            $table->string("payment_status");
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_headers');
    }
}
