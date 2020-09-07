<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_group', function (Blueprint $table) {
            $table->foreignId('contact_id');
            $table->foreignId('group_id');
            $table->timestamps();

            $table->primary(['contact_id', 'group_id']);
            $table->foreign('contact_id')
                    ->references('id')
                    ->on('contacts')
                    ->onDelete('cascade');
            $table->foreign('group_id')
                    ->references('id')
                    ->on('groups')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_group');
    }
}
