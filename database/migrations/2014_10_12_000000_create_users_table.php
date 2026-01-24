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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Basic info
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();

            // Identity & contact
            $table->string('religion', 50)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('national_id', 50)->nullable();
            $table->string('phone', 20)->nullable();

            // Auth
            $table->string('email')->unique();
            $table->string('password');

            // Address
            $table->text('present_address')->nullable();
            $table->text('parmanent_address')->nullable();

            // Parents & guardian
            $table->string('father_name')->nullable();
            $table->string('father_contact', 20)->nullable();

            $table->string('mother_name')->nullable();
            $table->string('mother_contact', 20)->nullable();

            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact', 20)->nullable();

            // Status & joining
            $table->string('role')->default('admin'); // Admin, Branch Manager, Operator, Accounts
            $table->string('status')->default('active');
            $table->date('joining_date')->nullable();
            $table->text('remark')->nullable();

            // Photo
            $table->string('photo')->nullable();

            // OTP & security
            $table->string('otp', 10)->nullable();
            $table->timestamp('otp_expires_at')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->ipAddress('last_login_ip')->nullable();

            $table->boolean('is_profile_completed')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
