<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, change the column to varchar to allow any value
        DB::statement("ALTER TABLE users MODIFY COLUMN employment_status VARCHAR(255) NULL");
        
        // Then update existing data to match new enum values
        DB::statement("UPDATE users SET employment_status = 'PNS' WHERE employment_status = 'Aktif'");
        DB::statement("UPDATE users SET employment_status = 'Non-Aktif' WHERE employment_status = 'Non-Aktif'");
        DB::statement("UPDATE users SET employment_status = 'Cuti' WHERE employment_status = 'Cuti'");
        
        // Finally, change back to enum with new values
        DB::statement("ALTER TABLE users MODIFY COLUMN employment_status ENUM('PNS', 'CPNS', 'Guru Honorer', 'Guru Kontrak', 'Guru Bantu', 'Non-Aktif', 'Cuti') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum
        DB::statement("ALTER TABLE users MODIFY COLUMN employment_status ENUM('Aktif','Non-Aktif','Cuti') NULL");
    }
};