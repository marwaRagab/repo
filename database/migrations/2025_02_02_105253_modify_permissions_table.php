<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyPermissionsTable extends Migration
{

    public function up()
    {
        if (!Schema::hasColumn('permissions', 'parent_id')) {
            DB::statement("ALTER TABLE permissions ADD COLUMN parent_id BIGINT UNSIGNED NULL");
            DB::statement("ALTER TABLE permissions ADD CONSTRAINT permissions_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES permissions(id) ON DELETE CASCADE");
        }
    }
}