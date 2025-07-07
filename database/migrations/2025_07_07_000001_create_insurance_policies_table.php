<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('policy_type_id')->constrained('policy_types')->onDelete('cascade');
            $table->string('policy_number')->unique();
            $table->string('status');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('premium_amount', 12, 2);
            $table->decimal('coverage_amount', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_policies');
    }
};
