<?php

use App\Models\archivesMainMenues;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('archives_sub_menues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'added_by')->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(archivesMainMenues::class, 'main_menu_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives_sub_menues');
    }
};
