<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('direction')->nullable();
            $table->string('number')->nullable();
            $table->string('floor')->nullable();
            $table->unsignedSmallInteger('municipe_id')->nullable()->index('municipe_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('parent_category')->nullable()->index('parent_category')->comment('Parent category');
        });

        Schema::create('ccaa', function (Blueprint $table) {
            $table->comment('Lista de Comunicades Autónomas');
            $table->unsignedTinyInteger('id')->primary();
            $table->string('name', 100);
        });


        Schema::create('municipes', function (Blueprint $table) {
            $table->comment('Lista de Municipios');
            $table->smallIncrements('id');
            $table->unsignedSmallInteger('idProvince')->index('idProvince');
            $table->integer('codMunicipe');
            $table->integer('DC');
            $table->string('name', 100);
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->index('order_id');
            $table->unsignedBigInteger('product_id')->nullable()->index('product_id');
            $table->integer('quantity')->nullable()->default(1);
            $table->unsignedBigInteger('vendor_id')->nullable()->index('vendor_id');
            $table->boolean('enviado')->default(false);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->enum('status', ['cart', 'confirmed', 'to_center', 'delivering', 'recieved', 'alt_recieved', 'refused', 'returned'])->nullable();
            $table->smallInteger('tries')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('delivery_address')->nullable()->index('delivery_address');
            $table->unsignedBigInteger('shippingcompany')->nullable()->index('shippingcompany');
        });

        Schema::create('product_stock', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->nullable();
            $table->decimal('unit_price', 10, 2, true)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('product_id')->nullable()->index('product_id');
            $table->unsignedBigInteger('vendor_id')->nullable()->index('vendor_id');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['out_of_stock', 'in_stock', 'running_low'])->nullable();
            $table->unsignedBigInteger('category')->nullable()->index('category');
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->comment('Lista de Provincias. El campo idProvincia coincide con los dos primeros dígitos del código postal
# de la provincia (los que tienen un dígito, añadir el 0 delante).');
            $table->unsignedSmallInteger('id')->primary();
            $table->unsignedTinyInteger('idCCAA')->index('idCCAA');
            $table->string('name', 30)->nullable();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('password');
            $table->string('NIF')->nullable();
            $table->string('status')->nullable();
            $table->integer('avisos')->default(0);
            $table->string('email')->unique();
            $table->integer('role_id')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('shippingcompany', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
        });

        Schema::create('shipping_provinces', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('province_id')->index('province_id');
            $table->unsignedBigInteger('shipping_company_id')->index('shipping_company_id');
        });

        Schema::table('address', function (Blueprint $table) {
            $table->foreign('municipe_id')->references(['id'])->on('municipes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });


        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_category')->references('id')->on('categories')->onDelete('cascade')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });


        Schema::table('municipes', function (Blueprint $table) {
            $table->foreign('idProvince')->references('id')->on('provinces')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('vendor_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('delivery_address')->references('id')->on('address');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shippingcompany')->references('id')->on('shippingcompany');
        });

        Schema::table('product_stock', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('product_id')->references('id')->on('products');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category')->references('id')->on('categories');
        });

        Schema::table('provinces', function (Blueprint $table) {
            $table->foreign('idCCAA')->references('id')->on('ccaa')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('shipping_provinces', function (Blueprint $table) {
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('shipping_company_id')->references('id')->on('shippingcompany');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        Schema::dropIfExists('users');

        Schema::dropIfExists('provinces');

        Schema::dropIfExists('products');

        Schema::dropIfExists('product_stock');

        Schema::dropIfExists('orders');

        Schema::dropIfExists('order_items');

        Schema::dropIfExists('municipes');

        Schema::dropIfExists('ccaa');

        Schema::dropIfExists('categories');

        Schema::dropIfExists('address');

        Schema::dropIfExists('shippingcompany');

        Schema::dropIfExists('shipping_provinces');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
