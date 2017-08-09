<?php

use Illuminate\Database\Seeder;

class FactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $factsList = [['polyatomic ions','nitrate','name', 'NO3-1', 'formula'],
          ['acids', 'nitric acid', 'name', 'HNO3', 'formula'],
          ['elements', 'sodium', 'name', 'Na', 'symbol'],
          ['numerical constant', 'water', 'density', '1', 'g/mL'],
          ['conversion factor', '1', 'mL', '1', 'cm^3']];

        for ($i = 0 ; $i < count($factsList) ; ++$i) {
          DB::table('facts')->insert([
            'group_name' => $factsList[$i][0],
            'key' => $factsList[$i][3],
            'key_name' => $factsList[$i][4],
            'prop' => $factsList[$i][1],
            'prop_name' => $factsList[$i][2]
        ]);
        }
    }
}
