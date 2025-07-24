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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('client_vat_no')->nullable();
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('after_discount_total', 10, 2)->default(0);
            $table->decimal('after_sscl_total', 10, 2)->default(0);
            $table->decimal('final_total', 10, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'client_vat_no',
                'discount_percentage',
                'discount_amount',
                'after_discount_total',
                'sscl',
                'after_sscl_total',
                'vat',
                'final_total'
            ]);
        });
    }

};
