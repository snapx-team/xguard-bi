<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBIEmployeesTable extends Migration
{

    public function up()
    {
        Schema::create('bi_employees', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['employee', 'admin']);
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bi_employees');
    }
}
