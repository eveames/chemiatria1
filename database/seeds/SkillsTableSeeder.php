<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $skillsList = [['SigFigs: no decimal place','','sigfig'], ['SigFigs: decimal places', '', 'sigfig'],
      ['SigFigs: decimal only', '', 'sigfig'], ['SigFigs: ends in decimal point', '', 'sigfig']];

        for ($i = 0 ; $i < count($skillsList) ; ++$i) {
      		DB::table('skills')->insert([
            'skill' => $skillsList[$i][0],
            'description' => $skillsList[$i][1],
            'subtype' => $skillsList[$i][2]
        ]);
      	}
    }
}
