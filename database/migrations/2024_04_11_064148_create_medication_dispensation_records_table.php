<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicationDispensationRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('medication_dispensation_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->string('medication');
            $table->string('dosage');
            $table->date('date_dispensed');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medication_dispensation_records');
    }
}
