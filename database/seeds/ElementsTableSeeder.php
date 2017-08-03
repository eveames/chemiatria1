<?php

use Illuminate\Database\Seeder;

class ElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $table->increments('id'); //atomic number
        $table->string('name', 20)->unique(); //eg iron
        $table->string('symbol', 3)->unique(); // eg Fe
        $table->string('families',10); //list of number codes
        $table->float('mass'); //atomic mass
        $table->string('charges',15);  //list of comma-sep charges
        $table->unsignedInteger('formula'); //number of atoms in elemental formula
        $table->unsignedInteger('bp'); //boiling point in K
        $table->unsignedInteger('mp'); //melting point in K
        //family group codes: 1: alkali, 2: alkaline earth, 3: boron group, 4: carbon group
        // 5: pnictogens (nitrogen group), 6: chalcogens (oxygen group), 7: halogens, 8: noble gases
        // 9: transition metals, 10: rare earths, 11: coinage metals, 12: post-transition metals, 13: non-metals, 14: metalloids

        $eList =
        [['name' => 'hydrogen', 'symbol' => 'H', 'families' => '13', 'mass' => '1.0079', 'charges' => '1,-1', 'formula' => '2', 'bp' => '20.28', 'mp' => '14.01'],
        ['name' => 'helium', 'symbol' => 'He', 'families' => '8,13', 'mass' => '4.0026', 'charges' => '0', 'formula' => '1', 'bp' => '4.22', 'mp' => '0'],
        ['name' => 'lithium', 'symbol' => 'Li', 'families' => '1', 'mass' => '6.941', 'charges' => '1', 'formula' => '1', 'bp' => '1615', 'mp' => '453.69'],
        ['name' => 'beryllium', 'symbol' => 'Be', 'families' => '2', 'mass' => '9.0122', 'charges' => '2', 'formula' => '1', 'bp' => '2743', 'mp' => '1560'],
        ['name' => 'boron', 'symbol' => 'B', 'families' => '3,14', 'mass' => '10.811', 'charges' => '3', 'formula' => '1', 'bp' => '4273', 'mp' => '2348'],
        ['name' => 'carbon', 'symbol' => 'C', 'families' => '4,13', 'mass' => '12.011', 'charges' => '0', 'formula' => '1', 'bp' => '4300', 'mp' => '3823'],
        ['name' => 'nitrogen', 'symbol' => 'N', 'families' => '5,13', 'mass' => '14.007', 'charges' => '-3', 'formula' => '2', 'bp' => '77.36', 'mp' => '63.05'],
        ['name' => 'oxygen', 'symbol' => 'O', 'families' => '6,13', 'mass' => '15.999', 'charges' => '-2', 'formula' => '2', 'bp' => '90.2', 'mp' => '54.8'],
        ['name' => 'fluorine', 'symbol' => 'F', 'families' => '7,13', 'mass' => '18.998', 'charges' => '-1', 'formula' => '2', 'bp' => '85.03', 'mp' => '53.5'],
        ['name' => 'neon', 'symbol' => 'Ne', 'families' => '8,13', 'mass' => '20.180', 'charges' => '0', 'formula' => '1', 'bp' => '27.07', 'mp' => '24.56'],
        ['name' => 'sodium', 'symbol' => 'Na', 'families' => '1', 'mass' => '22.990', 'charges' => '1', 'formula' => '1', 'bp' => '1156', 'mp' => '370.87'],
        ['name' => 'magnesium', 'symbol' => 'Mg', 'families' => '2', 'mass' => '24.305', 'charges' => '2', 'formula' => '1', 'bp' => '1363', 'mp' => '923'],
        ['name' => 'aluminum', 'symbol' => 'Al', 'families' => '3', 'mass' => '26.982', 'charges' => '3', 'formula' => '1', 'bp' => '2792', 'mp' => '933.47'],
        ['name' => 'silicon', 'symbol' => 'Si', 'families' => '4,14', 'mass' => '28.086', 'charges' => '4', 'formula' => '1', 'bp' => '3173', 'mp' => '1687'],
        ['name' => 'phosphorus', 'symbol' => 'P', 'families' => '5,13', 'mass' => '30.974', 'charges' => '-3', 'formula' => '4', 'bp' => '553.6', 'mp' => '317.3'],
        ['name' => 'sulfur', 'symbol' => 'S', 'families' => '6,13', 'mass' => '32.065', 'charges' => '-2', 'formula' => '8', 'bp' => '717.87', 'mp' => '388.36'],
        ['name' => 'chlorine', 'symbol' => 'Cl', 'families' => '7,13', 'mass' => '35.453', 'charges' => '-1', 'formula' => '2', 'bp' => '239.11', 'mp' => '171.6'],
        ['name' => 'argon', 'symbol' => 'Ar', 'families' => '8,13', 'mass' => '39.948', 'charges' => '0', 'formula' => '1', 'bp' => '87.3', 'mp' => '83.8'],

        ];

        for ($i = 0 ; $i < count($eList) ; ++$i) {
          DB::table('topic_word')->insert([
            'word_id' => $eList[$i]['word_id'],
            'topic_id' => $eList[$i]['topic_id'],
        ]);
        }

    }
}
