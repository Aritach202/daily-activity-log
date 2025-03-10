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
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Development', 'Test', 'Document']);     // ประเภทงาน
            $table->string('name');                                        // ชื่องานที่ดำเนินการ
            $table->dateTime('start_time');                               // วันและเวลาที่เริ่มดำเนินการ
            $table->dateTime('end_time')->nullable();                     // วันและเวลาที่เสร็จสิ้น
            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');  // สถานะ
            $table->timestamps();                                         // created_at, updated_at (วันเวลาที่บันทึก/ปรับปรุง)
        });
    }


};
