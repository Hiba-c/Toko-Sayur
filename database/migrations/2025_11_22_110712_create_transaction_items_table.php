<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up(): void
{
Schema::table('transaction_items', function (Blueprint $table) {
if (!Schema::hasColumn('transaction_items','diskon')) {
$table->decimal('diskon', 12, 2)->default(0)->after('price');
}
});
}


public function down(): void
{
Schema::table('transaction_items', function (Blueprint $table) {
if (Schema::hasColumn('transaction_items','diskon')) {
$table->dropColumn('diskon');
}
});
}
};