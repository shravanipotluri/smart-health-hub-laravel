<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompliancesTable extends Migration
{
    public function up()
    {
        Schema::create('compliances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('status', ['Compliant', 'Pending Review', 'Non-Compliant']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compliances');
    }
}
