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
            $table->unsignedSmallInteger('municipe_id')->nullable()->index('municipe_id');
            $table->string('number')->nullable();
            $table->string('floor')->nullable();
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

        Schema::create('incidences', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('order_id')->nullable()->index('order_id');
            $table->unsignedBigInteger('product_id')->nullable()->index('product_id');
            $table->unsignedBigInteger('vendor_id')->nullable()->index('vendor_id');
            $table->unsignedBigInteger('controller_id')->nullable()->index('controller_id');
            $table->integer('intentos')->default(0);
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
            $table->unsignedBigInteger('order_id')->nullable()->index('order_id');
            $table->unsignedBigInteger('product_id')->nullable()->index('product_id');
            $table->integer('quantity')->nullable()->default(1);
            $table->unsignedBigInteger('vendor_id')->nullable()->index('vendor_id');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->enum('status', ['pending', 'confirmed', 'sent', 'recieved', 'canceled', 'returned'])->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('delivery_address')->nullable()->index('delivery_address');
        });

        Schema::create('product_stock', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->nullable();
            $table->decimal('unit_price', 10)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('product_id')->nullable()->index('product_id');
            $table->unsignedBigInteger('vendor_id')->nullable()->index('vendor_id');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
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
            $table->unsignedBigInteger('address')->nullable()->index('address');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('address', function (Blueprint $table) {
            $table->foreign('municipe_id')->references(['id'])->on('municipes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });


        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_category')->references('id')->on('categories')->onDelete('cascade')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });



        Schema::table('incidences', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('controller_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('vendor_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');

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

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('address')->references('id')->on('address');
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

        Schema::dropIfExists('incidences');

        Schema::dropIfExists('ccaa');

        Schema::dropIfExists('categories');

        Schema::dropIfExists('address');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
};
