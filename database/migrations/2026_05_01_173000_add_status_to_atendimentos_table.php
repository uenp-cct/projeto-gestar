<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            if (! Schema::hasColumn('atendimentos', 'status')) {
                $table->string('status')->default('finalizado')->after('tipo_atendimento');
            }
        });
    }

    public function down(): void
    {
        Schema::table('atendimentos', function (Blueprint $table) {
            if (Schema::hasColumn('atendimentos', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
