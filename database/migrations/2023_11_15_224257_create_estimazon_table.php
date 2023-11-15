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
            $table->integer('id', true);
            $table->string('direction')->nullable();
            $table->integer('municipe_id')->nullable()->index('municipe_id');
            $table->string('number')->nullable();
            $table->string('floor')->nullable();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->integer('parent_category')->nullable()->index('parent_category')->comment('Subcategories');
        });

        Schema::create('ccaa', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name')->nullable();
        });

        Schema::create('incidences', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('description')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('order_id')->nullable()->index('order_id');
            $table->integer('product_id')->nullable()->index('product_id');
            $table->integer('vendor_id')->nullable()->index('vendor_id');
            $table->integer('controller_id')->nullable()->index('controller_id');
        });

        Schema::create('municipe', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name')->nullable();
            $table->integer('code')->nullable();
            $table->integer('Province_id')->nullable()->index('Province_id');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->integer('order_id')->nullable()->index('order_id');
            $table->integer('product_id')->nullable()->index('product_id');
            $table->integer('quantity')->nullable()->default(1);
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->index('user_id');
            $table->enum('status', ['pending', 'confirmed', 'sent', 'recieved', 'canceled', 'returned'])->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent()->comment('When order created');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('delivery_address')->nullable()->index('delivery_address');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('merchant_id')->nullable()->index('merchant_id');
            $table->integer('unit_price')->nullable();
            $table->enum('status', ['out_of_stock', 'in_stock', 'running_low'])->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('category')->nullable()->index('category');
        });

        Schema::create('province', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name')->nullable();
            $table->integer('CCAA_id')->nullable()->index('CCAA_id');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('full_name')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('country_code')->nullable();
            $table->string('NIF')->nullable();
            $table->string('mail')->nullable();
            $table->integer('role_id')->nullable()->default(1);
            $table->integer('address')->nullable()->index('address');
        });

        Schema::table('address', function (Blueprint $table) {
            $table->foreign(['municipe_id'], 'address_ibfk_1')->references(['id'])->on('municipe');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign(['parent_category'], 'categories_ibfk_1')->references(['id'])->on('categories');
        });

        Schema::table('incidences', function (Blueprint $table) {
            $table->foreign(['product_id'], 'incidences_ibfk_2')->references(['id'])->on('products');
            $table->foreign(['controller_id'], 'incidences_ibfk_4')->references(['id'])->on('users');
            $table->foreign(['order_id'], 'incidences_ibfk_1')->references(['id'])->on('orders');
            $table->foreign(['vendor_id'], 'incidences_ibfk_3')->references(['id'])->on('users');
        });

        Schema::table('municipe', function (Blueprint $table) {
            $table->foreign(['Province_id'], 'municipe_ibfk_1')->references(['id'])->on('province');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign(['product_id'], 'order_items_ibfk_2')->references(['id'])->on('products');
            $table->foreign(['order_id'], 'order_items_ibfk_1')->references(['id'])->on('orders');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign(['delivery_address'], 'orders_ibfk_2')->references(['id'])->on('address');
            $table->foreign(['user_id'], 'orders_ibfk_1')->references(['id'])->on('users');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['category'], 'products_ibfk_2')->references(['id'])->on('categories');
            $table->foreign(['merchant_id'], 'products_ibfk_1')->references(['id'])->on('users');
        });

        Schema::table('province', function (Blueprint $table) {
            $table->foreign(['CCAA_id'], 'province_ibfk_1')->references(['id'])->on('ccaa');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['address'], 'users_ibfk_1')->references(['id'])->on('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_ibfk_1');
        });

        Schema::table('province', function (Blueprint $table) {
            $table->dropForeign('province_ibfk_1');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_ibfk_2');
            $table->dropForeign('products_ibfk_1');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_ibfk_2');
            $table->dropForeign('orders_ibfk_1');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('order_items_ibfk_2');
            $table->dropForeign('order_items_ibfk_1');
        });

        Schema::table('municipe', function (Blueprint $table) {
            $table->dropForeign('municipe_ibfk_1');
        });

        Schema::table('incidences', function (Blueprint $table) {
            $table->dropForeign('incidences_ibfk_2');
            $table->dropForeign('incidences_ibfk_4');
            $table->dropForeign('incidences_ibfk_1');
            $table->dropForeign('incidences_ibfk_3');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_ibfk_1');
        });

        Schema::table('address', function (Blueprint $table) {
            $table->dropForeign('address_ibfk_1');
        });

        Schema::dropIfExists('users');

        Schema::dropIfExists('province');

        Schema::dropIfExists('products');

        Schema::dropIfExists('orders');

        Schema::dropIfExists('order_items');

        Schema::dropIfExists('municipe');

        Schema::dropIfExists('incidences');

        Schema::dropIfExists('ccaa');

        Schema::dropIfExists('categories');

        Schema::dropIfExists('address');
    }
};
