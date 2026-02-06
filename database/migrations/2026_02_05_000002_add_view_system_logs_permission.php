<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        // Check if permission already exists
        if (!Permission::where('slug', 'view_system_logs')->exists()) {
            Permission::create([
                'name' => 'View System Logs',
                'slug' => 'view_system_logs',
                'description' => 'Access to view system logs',
            ]);
        }
    }

    public function down()
    {
        Permission::where('slug', 'view_system_logs')->delete();
    }
};
