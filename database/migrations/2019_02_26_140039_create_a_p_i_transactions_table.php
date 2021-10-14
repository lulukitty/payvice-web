<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAPITransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_p_i_transactions', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('walletId')->nullable();
            $table->string('username')->nullable();
            $table->string('category');
            $table->string('category_code')->nullable();
            $table->string('product');
            $table->string('product_code')->nullable();
            $table->string('account');

            $table->string('clientReference')->nullable();
            $table->string('reference')->nullable();
            $table->string('externalReference')->nullable();

            $table->bigInteger('amount');//100000
            $table->bigInteger('numericalAmount');//1000.00
            $table->string('amountHash')->nullable();//Encrypted Amount
            $table->bigInteger('higherDenominationAmount')->nullable();//1000

            $table->string('name')->nullable();//Airtime Top up
            $table->string('description')->nullable();//MTN Recharge of 1000 to 08031234567
            $table->string('narration')->nullable();//Airtime MTN Recharge of 1000 to 08031234567 from 11001100 through 2033FD123

            $table->integer('transactionGroup')->nullable();//

            $table->string('currency')->default("Nigerian Naira");
            $table->string('currencyCountry')->default("Nigeria");
            $table->string('currencyISOAlpha')->default("NGN");
            $table->string('currencyISONumeric')->default(566);

            $table->string('extra')->nullable();//Any other information
            $table->json('details')->nullable();//Please add extra JSON Key value fields here
            $table->enum('status', ['initialized', 'debited', 'pending', 'successful', 'failed', 'declined'])->default('initialized');//Was this transaction successful to the point of releasing value

            $table->string('channel')->nullable();//WEB, MOBILE, POS

            $table->string('reason')->nullable();//Reason for response
            $table->string('message')->nullable();//Message to client
            $table->string('value')->nullable();//Worth of Value returned to client
            $table->string('token')->nullable();//String of Value returned to client


            $table->text('response')->nullable();//Response sent to the client stored in a text field here, mask unsafe fields :-)
            $table->text('request')->nullable();//Request sent by the client stored in a text field here, mask unsafe fields :-)

            $table->timestamps();
        });

        DB::statement("ALTER TABLE a_p_i_transactions AUTO_INCREMENT = 1000111");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_p_i_tranactions');
    }
}
