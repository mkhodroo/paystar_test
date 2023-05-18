<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('user_info')){
            Schema::create('user_info', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('user_id')->unsigned();
                $table->string('key');
                $table->string('value');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
            });
        }

        Schema::create('mk_orders', function(Blueprint $table){
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('amount');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('mk_transactions', function(Blueprint $table){
            $table->id();
            $table->bigInteger('order_id')->unsigned();
            $table->string('amount');
            $table->string('ref_num');
            $table->string('card_number');
            $table->string('paystar_transaction_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->enum('transaction_status', ['ok', 'cancel', 'pending'])->nullable();
            $table->json('transaction_result')->nullable();
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('mk_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
