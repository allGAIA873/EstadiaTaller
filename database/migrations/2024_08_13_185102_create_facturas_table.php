<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas_bancarias')->onDelete('cascade');
            $table->string('concepto');
            $table->string('deposito')->nullable();
            $table->string('retiro')->nullable();
            $table->longText('detalle');
            $table->string('folio')->nullable();
            $table->enum('tipo_factura',['PPD', 'PUE'])->nullable();
            $table->string('complemento_pago')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
