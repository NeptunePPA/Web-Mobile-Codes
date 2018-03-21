    <?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectidItemfiledetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_files_details', function (Blueprint $table) {
            $table->integer('projectId')->unsigned()->nullable();
            $table->foreign('projectId')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_files_details', function (Blueprint $table) {
            $table->dropColumn('projectId');
        });
    }
}
