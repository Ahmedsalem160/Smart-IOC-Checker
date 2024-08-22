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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('malwarefamilies_id'); // Foreign key to the malware_families table
            $table->string('type'); // e.g., 'ipv4', 'url', 'file_hashes'
            $table->string('value'); // The actual IOC value (IP address, URL, hash, etc.)
            $table->string('source')->nullable(); // Source of the IOC, e.g., 'AlienVault'
            $table->timestamp('created')->nullable(); // The date the IOC was created or detected
            // Foreign key constraint
            $table->foreign('malwarefamilies_id')->references('id')->on('malware_families')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
