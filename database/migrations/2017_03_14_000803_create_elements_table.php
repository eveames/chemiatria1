<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     //family group codes: 1: alkali, 2: alkaline earth, 3: boron group, 4: carbon group
     // 5: pnictogens (nitrogen group), 6: chalcogens (oxygen group), 7: halogens, 8: noble gases
     // 9: transition metals, 10: rare earths, 11: coinage metals, 12: post-transition metals
    public function up()
    {
        Schema::create('elements', function (Blueprint $table) {
            $table->increments('id'); //atomic number
            $table->string('name', 20)->unique(); //eg iron
            $table->string('symbol', 3)->unique(); // eg Fe
            $table->string('families',10); //list of number codes
            $table->float('mass'); //atomic mass
            $table->string('charges',15);  //list of comma-sep charges
            $table->unsignedInteger('formula'); //number of atoms in elemental formula
            $table->unsignedInteger('bp'); //boiling point in K
            $table->unsignedInteger('mp'); //melting point in K
            //later, might add ionization energies, radius, isotopes, etc
            //might also want codes for who should know what about this element
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elements');
    }
}
