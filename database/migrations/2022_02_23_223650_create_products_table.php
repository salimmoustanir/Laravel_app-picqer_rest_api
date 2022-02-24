<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integer('idproduct');
            $table->integer('idvatgroup')->nullable();
            $table->string('name')->nullable();
            $table->float('price')->nullable();
            $table->float('fixedstockprice')->nullable();
            $table->string('productcode_supplier')->nullable();
                        $table->string('productcode')->nullable();

            $table->integer('deliverytime')->nullable();
            $table->string('description')->nullable();
            $table->string('barcode')->nullable();
            $table->boolean('unlimitedstock')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('hs_code')->nullable();
            $table->boolean('active')->nullable();
            $table->integer('minimum_purchase_quantity')->nullable();
            $table->integer('purchase_in_quantities_of')->nullable();
            	
  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
