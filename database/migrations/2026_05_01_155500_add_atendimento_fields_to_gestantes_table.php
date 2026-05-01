<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gestantes', function (Blueprint $table) {
            if (! Schema::hasColumn('gestantes', 'numero_sus')) {
                $table->string('numero_sus', 20)->nullable()->after('nome');
                $table->index('numero_sus');
            }

            if (! Schema::hasColumn('gestantes', 'gestor_id')) {
                $table->foreignId('gestor_id')
                    ->nullable()
                    ->after('numero_sus')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('gestantes', 'medico_id')) {
                $table->foreignId('medico_id')
                    ->nullable()
                    ->after('gestor_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('gestantes', function (Blueprint $table) {
            if (Schema::hasColumn('gestantes', 'medico_id')) {
                $table->dropConstrainedForeignId('medico_id');
            }
            if (Schema::hasColumn('gestantes', 'gestor_id')) {
                $table->dropConstrainedForeignId('gestor_id');
            }
            if (Schema::hasColumn('gestantes', 'numero_sus')) {
                $table->dropIndex(['numero_sus']);
                $table->dropColumn('numero_sus');
            }
        });
    }
};
