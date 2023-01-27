<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Folder;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('title');
            $table->string('extension');
            $table->integer('size')->unsigned();
            $table->timestamp('expires_at')->default(null)->nullable();
            $table->timestamps();
            $table->foreignIdFor(Folder::class)->nullable();
            $table->foreignIdFor(User::class);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
