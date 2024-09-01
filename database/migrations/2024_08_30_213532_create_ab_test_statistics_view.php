<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            "CREATE OR REPLACE VIEW ab_test_statistics_view AS
            SELECT
                JSON_UNQUOTE(JSON_EXTRACT(e.data, '$.test_name')) AS test_name,
                JSON_UNQUOTE(JSON_EXTRACT(e.data, '$.variant_name')) AS variant_name,
                COUNT(e.data) as count
            FROM events e
            WHERE
                JSON_CONTAINS_PATH(e.data, 'one', '$.test_name')
            GROUP BY e.data"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS ab_test_statistics_view');
    }
};
