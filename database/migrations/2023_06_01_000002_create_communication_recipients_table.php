<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communication_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('communication_id');
            $table->string('recipient_type')->nullable(); // user, manual
            $table->unsignedBigInteger('recipient_id')->nullable(); // For user type
            $table->string('email')->nullable(); // Manually entered email
            $table->string('phone')->nullable(); // Manually entered phone
            $table->string('name')->nullable(); // Manually entered name
            $table->string('status')->default('pending'); // pending, sent, delivered, failed
            $table->text('status_message')->nullable();
            $table->timestamps();
            
            $table->foreign('communication_id')->references('id')->on('communications')->onDelete('cascade');
            // No foreign key for recipient_id as we're adding emails manually
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communication_recipients');
    }
};