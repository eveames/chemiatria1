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
        $factsList = [
          ['acids', 'nitric acid', 'name', 'HNO3', 'formula'],
          ['acids', 'sulfuric acid', 'name', 'H2SO4', 'formula'],
          ['acids', 'hydrochloric acid', 'name', 'HCl', 'formula'],
          ['acids', 'hydrobromic acid', 'name', 'HBr', 'formula'],
          ['acids', 'hydroiodic acid', 'name', 'HI', 'formula'],
          ['acids', 'hydrofluoric acid', 'name', 'HF', 'formula'],
          ['acids', 'chloric acid', 'name', 'HClO3', 'formula'],
          ['acids', 'perchloric acid', 'name', 'HClO4', 'formula'],
          ['acids', 'acetic acid', 'name', 'HC2H3O2', 'formula'],
          ['commonCompound', 'ammonia', 'name', 'NH3', 'formula'],
          ['commonCompound', 'water', 'name', 'H2O', 'formula'],
          ['commonCompound', 'methane', 'name', 'CH4', 'formula'],
          ['commonCompound', 'ozone', 'name', 'O3', 'formula'],
          ['commonCompound', 'nitric oxide', 'name', 'NO', 'formula'],
          ['commonCompound', 'nitrous oxide', 'name', 'N2O', 'formula'],
          ['numerical constant', 'water', 'density', '1', 'g/mL'],
          ['conversion factor', '1', 'mL', '1', 'cm^3']];

        $ionsList = [['polyatomic ions','nitrate','name', 'NO3-1', 'formula'],
        ['polyatomic ions','nitrite','name', 'NO2-1', 'formula'],
        ['polyatomic ions','ammonium','name', 'NH4+1', 'formula'],
        ['polyatomic ions','sulfate','name', 'SO4-2', 'formula'],
        ['polyatomic ions','sulfite','name', 'SO3-2', 'formula'],
        ['polyatomic ions','phosphate','name', 'PO4-3', 'formula'],
        ['polyatomic ions','cyanide','name', 'CN-1', 'formula'],
        ['polyatomic ions','hydroxide','name', 'OH-1', 'formula'],
        ['polyatomic ions','peroxide','name', 'O2-2', 'formula'],
        ['polyatomic ions','acetate','name', 'C2H3O2-1', 'formula'],
        ['polyatomic ions','perchlorate','name', 'ClO4-1', 'formula'],
        ['polyatomic ions','chlorate','name', 'ClO3-1', 'formula'],
        ['polyatomic ions','chlorite','name', 'ClO2-1', 'formula'],
        ['polyatomic ions','hypochlorite','name', 'ClO-1', 'formula'],
        ['polyatomic ions','perbromate','name', 'BrO4-1', 'formula'],
        ['polyatomic ions','bromate','name', 'BrO3-1', 'formula'],
        ['polyatomic ions','bromite','name', 'BrO2-1', 'formula'],
        ['polyatomic ions','hypobromite','name', 'BrO-1', 'formula'],
        ['polyatomic ions','periodate','name', 'IO4-1', 'formula'],
        ['polyatomic ions','iodate','name', 'IO3-1', 'formula'],
        ['polyatomic ions','iodite','name', 'IO2-1', 'formula'],
        ['polyatomic ions','hypoiodite','name', 'IO-1', 'formula'],
        ['polyatomic ions','carbonate','name', 'CO3-2', 'formula'],
        ['polyatomic ions','bicarbonate','name', 'HCO3-1', 'formula'],
        ['polyatomic ions','bisulfate','name', 'HSO4-1', 'formula'],
        ['polyatomic ions','azide','name', 'N3-1', 'formula']];

        $elementsList = [['elementSymbol', 'hydrogen', 'name', 'H', '1'],
        ['elementSymbol', 'helium', 'name', 'He', '2'],
        ['elementSymbol', 'lithium', 'name', 'Li', '3'],
        ['elementSymbol', 'beryllium', 'name', 'Be', '4'],
        ['elementSymbol', 'boron', 'name', 'B', '5'],
        ['elementSymbol', 'carbon', 'name', 'C', '6'],
        ['elementSymbol', 'nitrogen', 'name', 'N', '7'],
        ['elementSymbol', 'oxygen', 'name', 'O', '8'],
        ['elementSymbol', 'fluorine', 'name', 'F', '9'],
        ['elementSymbol', 'bromine', 'name', 'Br', '10'],
        ['elementSymbol', 'iodine', 'name', 'I', '11'],
        ['elementSymbol', 'sodium', 'name', 'Na', '12'],
        ['elementSymbol', 'magnesium', 'name', 'Mg', '13'],
        ['elementSymbol', 'aluminum', 'name', 'Al', '14'],
        ['elementSymbol', 'silicon', 'name', 'Si', '15'],
        ['elementSymbol', 'phosphorus', 'name', 'P', '16'],
        ['elementSymbol', 'sulfur', 'name', 'S', '17'],
        ['elementSymbol', 'chlorine', 'name', 'Cl', '18'],
        ['elementSymbol', 'argon', 'name', 'Ar', '19'],
        ['elementSymbol', 'potassium', 'name', 'K', '20'],
        ['elementSymbol', 'calcium', 'name', 'Ca', '21'],
        ['elementSymbol', 'titanium', 'name', 'Ti', '22'],
        ['elementSymbol', 'iron', 'name', 'Fe', '23'],
        ['elementSymbol', 'copper', 'name', 'Cu', '24'],
        ['elementSymbol', 'mercury', 'name', 'Hg', '25'],
        ['elementSymbol', 'silver', 'name', 'Ag', '26'],
        ['elementSymbol', 'gold', 'name', 'Au', '27'],
        ['elementSymbol', 'tin', 'name', 'Sn', '28'],
        ['elementSymbol', 'lead', 'name', 'Pb', '29'],
        ['elementSymbol', 'zinc', 'name', 'Zn', '30'],
        ['elementGroup', 'hydrogen', 'name', 'H', '1'],
        ['elementGroup', 'helium', 'name', 'He', '2'],
        ['elementGroup', 'lithium', 'name', 'Li', '3'],
        ['elementGroup', 'beryllium', 'name', 'Be', '4'],
        ['elementGroup', 'boron', 'name', 'B', '5'],
        ['elementGroup', 'carbon', 'name', 'C', '6'],
        ['elementGroup', 'nitrogen', 'name', 'N', '7'],
        ['elementGroup', 'oxygen', 'name', 'O', '8'],
        ['elementGroup', 'fluorine', 'name', 'F', '9'],
        ['elementGroup', 'bromine', 'name', 'Br', '10'],
        ['elementGroup', 'iodine', 'name', 'I', '11'],
        ['elementGroup', 'sodium', 'name', 'Na', '12'],
        ['elementGroup', 'magnesium', 'name', 'Mg', '13'],
        ['elementGroup', 'aluminum', 'name', 'Al', '14'],
        ['elementGroup', 'silicon', 'name', 'Si', '15'],
        ['elementGroup', 'phosphorus', 'name', 'P', '16'],
        ['elementGroup', 'sulfur', 'name', 'S', '17'],
        ['elementGroup', 'chlorine', 'name', 'Cl', '18'],
        ['elementGroup', 'argon', 'name', 'Ar', '19'],
        ['elementGroup', 'potassium', 'name', 'K', '20'],
        ['elementGroup', 'calcium', 'name', 'Ca', '21'],
        ['elementGroup', 'titanium', 'name', 'Ti', '22'],
        ['elementGroup', 'iron', 'name', 'Fe', '23'],
        ['elementGroup', 'copper', 'name', 'Cu', '24'],
        ['elementGroup', 'mercury', 'name', 'Hg', '25'],
        ['elementGroup', 'silver', 'name', 'Ag', '26'],
        ['elementGroup', 'gold', 'name', 'Au', '27'],
        ['elementGroup', 'tin', 'name', 'Sn', '28'],
        ['elementGroup', 'lead', 'name', 'Pb', '29'],
        ['elementGroup', 'zinc', 'name', 'Zn', '30'],
        ['elementCharge', 'hydrogen', 'name', 'H', '1'],
        ['elementCharge', 'helium', 'name', 'He', '2'],
        ['elementCharge', 'lithium', 'name', 'Li', '3'],
        ['elementCharge', 'beryllium', 'name', 'Be', '4'],
        ['elementCharge', 'boron', 'name', 'B', '5'],
        ['elementCharge', 'carbon', 'name', 'C', '6'],
        ['elementCharge', 'nitrogen', 'name', 'N', '7'],
        ['elementCharge', 'oxygen', 'name', 'O', '8'],
        ['elementCharge', 'fluorine', 'name', 'F', '9'],
        ['elementCharge', 'bromine', 'name', 'Br', '10'],
        ['elementCharge', 'iodine', 'name', 'I', '11'],
        ['elementCharge', 'sodium', 'name', 'Na', '12'],
        ['elementCharge', 'magnesium', 'name', 'Mg', '13'],
        ['elementCharge', 'aluminum', 'name', 'Al', '14'],
        ['elementCharge', 'silicon', 'name', 'Si', '15'],
        ['elementCharge', 'phosphorus', 'name', 'P', '16'],
        ['elementCharge', 'sulfur', 'name', 'S', '17'],
        ['elementCharge', 'chlorine', 'name', 'Cl', '18'],
        ['elementCharge', 'argon', 'name', 'Ar', '19'],
        ['elementCharge', 'potassium', 'name', 'K', '20'],
        ['elementCharge', 'calcium', 'name', 'Ca', '21'],
        ['elementCharge', 'titanium', 'name', 'Ti', '22'],
        ['elementCharge', 'iron', 'name', 'Fe', '23'],
        ['elementCharge', 'copper', 'name', 'Cu', '24'],
        ['elementCharge', 'mercury', 'name', 'Hg', '25'],
        ['elementCharge', 'silver', 'name', 'Ag', '26'],
        ['elementCharge', 'gold', 'name', 'Au', '27'],
        ['elementCharge', 'tin', 'name', 'Sn', '28'],
        ['elementCharge', 'lead', 'name', 'Pb', '29'],
        ['elementCharge', 'zinc', 'name', 'Zn', '30']
      ];

        for ($i = 0 ; $i < count($factsList) ; ++$i) {
          DB::table('facts')->insert([
            'group_name' => $factsList[$i][0],
            'key' => $factsList[$i][3],
            'key_name' => $factsList[$i][4],
            'prop' => $factsList[$i][1],
            'prop_name' => $factsList[$i][2]
        ]);
        }
        for ($i = 0 ; $i < count($ionsList) ; ++$i) {
          DB::table('facts')->insert([
            'group_name' => $ionsList[$i][0],
            'key' => $ionsList[$i][3],
            'key_name' => $ionsList[$i][4],
            'prop' => $ionsList[$i][1],
            'prop_name' => $ionsList[$i][2]
        ]);
        }
        for ($i = 0 ; $i < count($elementsList) ; ++$i) {
          DB::table('facts')->insert([
            'group_name' => $elementsList[$i][0],
            'key' => $elementsList[$i][3],
            'key_name' => $elementsList[$i][4],
            'prop' => $elementsList[$i][1],
            'prop_name' => $elementsList[$i][2]
        ]);
        }
    }
}
