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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->string('plan_price_id')->nullable();
            $table->double('plan_amount')->nullable();
            $table->string('plan_duration')->nullable();
            $table->string('plan_duration_count')->nullable();
            $table->string('subscription_type')->nullable();
            $table->string('subscription_status')->nullable();
            $table->datetime('plan_duration_end')->nullable();
            $table->datetime('plan_duration_start')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
