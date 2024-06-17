<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $lid = Role::create(['name' => 'lid']);
        $sales = Role::create(['name' => 'sales']);
        $analytic = Role::create(['name' => 'analytic']);
        $admin = Role::create(['name' => 'admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_role_and_users');
    }
};
