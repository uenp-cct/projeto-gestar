<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->nullable()->after('password');
            }
            if (! Schema::hasColumn('users', 'papel')) {
                $table->string('papel')->nullable()->after('role');
            }
            if (! Schema::hasColumn('users', 'unidade')) {
                $table->string('unidade')->nullable()->after('papel');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'unidade')) {
                $table->dropColumn('unidade');
            }
            if (Schema::hasColumn('users', 'papel')) {
                $table->dropColumn('papel');
            }
        });
    }
};
