<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMedicalRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Changing existing text columns to json type
            $table->json('allergies')->nullable()->change();
            $table->json('immunizations')->nullable()->change();

            // Adding new json columns
            $table->json('surgeries')->nullable();
            $table->json('family_history')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('lifestyle')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->json('conditions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->text('allergies')->nullable()->change();
            $table->text('immunizations')->nullable()->change();
            
            $table->dropColumn(['surgeries', 'family_history', 'blood_group', 'lifestyle', 'emergency_contact', 'conditions']);
        });
    }
}
