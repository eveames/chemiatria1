<?php

use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $topicsList = ['Scientific Basics','Chemical Basics', 'Lab Basics',
        	'Reactions', 'Atomic Structure','Stoichiometry', 'Solution Basics',
        	'Periodic Table', 'Nomenclature', 'Thermochemistry', 'Electronic Structure',
        	'Quantum Mechanics', 'Periodic Properties', 'Lewis Bonding Theory', 'Geometry',
        	'Valence Bond Theory', 'Molecular Orbital Theory', 'Gases', 'Intermolecular Forces',
        	'Phases', 'Solids', 'Colligative Properties', 'Advanced Solutions', 'Kinetics',
        	'Equilibrium', 'Acids and Bases', 'Environmental Chemistry', 'Thermodynamics',
        	'Electrochemistry', 'Nuclear Chemistry', 'Descriptive Chemistry',
        	'Coordination Chemistry', 'Organic Chemistry', 'Biochemistry', 'Significant Figures',
          'Basic Element Info'];

        for ($i = 0 ; $i < count($topicsList) ; ++$i) {
      		DB::table('topics')->insert([
            'topic' => $topicsList[$i],
        ]);
      	}
    }
}
