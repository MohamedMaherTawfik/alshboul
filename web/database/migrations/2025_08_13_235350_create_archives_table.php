<?php

use App\Models\archivesMainMenues;
use App\Models\archivesSubMenues;
use App\Models\Client;
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
        Schema::create('archives', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Client::class, 'client_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'user_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(archivesMainMenues::class, 'main_menu_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(archivesSubMenues::class, 'sub_menu_id')->constrained()->onDelete('cascade');
            $table->string('file');
            $table->text('another_names')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('active')->default(1);
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
