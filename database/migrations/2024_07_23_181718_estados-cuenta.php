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
        Schema::create('estados_cuenta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('estado', ['completo', 'incompleto']);
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->foreign('cuenta_id')->references('id')->on('cuentas_bancarias')->onDelete('cascade');
            $table->string('fecha_emision');
            $table->longText('descripcion_detallada');
            $table->string('concepto');
            $table->string('deposito')->nullable();
            $table->string('retiro')->nullable();
            $table->string('folio')->nullable();
            $table->string('complemento_pago')->nullable();

            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estados_cuenta', function (Blueprint $table) {
            $table->dropForeign(['cliente_id']);
            $table->dropColumn('cliente_id');
        });
    }
};
