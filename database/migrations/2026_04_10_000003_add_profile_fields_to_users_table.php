<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->unsignedTinyInteger('age')->after('password');
            $table->string('gender', 20)->after('age');
            $table->string('civil_status', 20)->after('gender');
            $table->string('mobile', 15)->after('civil_status');
            $table->text('address')->after('mobile');
            $table->string('zip', 4)->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'age', 'gender', 'civil_status', 'mobile', 'address', 'zip']);
        });
    }
};
