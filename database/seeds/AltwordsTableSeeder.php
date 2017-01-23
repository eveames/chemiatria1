<?php

use Illuminate\Database\Seeder;

class AltwordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $altList = [['word_id' => '1', 'alt' => 'stuff', 'correct' => 'close', 'message' => 'Close, but give the technical term!'],
        ['word_id' => '2', 'alt' => 'characteristic', 'correct' => 'close', 'message' => 'Close, but give the word usually used in the context of chemistry!'],
        ['word_id' => '2', 'alt' => 'trait', 'correct' => 'close', 'message' => 'Close, but give the word usually used in the context of chemistry!'],
        ['word_id' => '2', 'alt' => 'properties', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '3', 'alt' => 'elements', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '4', 'alt' => 'atoms', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '5', 'alt' => 'molecules', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '6', 'alt' => 'phase', 'correct' => 'correct', 'message' => 'Alternately, you could say "state of matter" or "physical state."'],
        ['word_id' => '6', 'alt' => 'phase of matter', 'correct' => 'correct', 'message' => 'Alternately, you could say "state of matter" or "physical state."'],
        ['word_id' => '6', 'alt' => 'physical state', 'correct' => 'correct', 'message' => 'Alternately, you could say "state of matter" or "phase."'],
        ['word_id' => '7', 'alt' => 'solids', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '8', 'alt' => 'liquids', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '8', 'alt' => 'fluid', 'correct' => 'close', 'message' => 'Not quite: fluid includes gases and any phase that flows.'],
        ['word_id' => '9', 'alt' => 'gases', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '9', 'alt' => 'vapor', 'correct' => 'correct', 'message' => 'Or gas.'],
        ['word_id' => '9', 'alt' => 'vapors', 'correct' => 'correct', 'message' => 'Or gas.'],
        ['word_id' => '9', 'alt' => 'vapour', 'correct' => 'correct', 'message' => 'Or gas.'],
        ['word_id' => '9', 'alt' => 'vapours', 'correct' => 'correct', 'message' => 'Or gas.'],
        ['word_id' => '10', 'alt' => 'formula', 'correct' => 'close', 'message' => 'Close, but give the word when it\'s reported as percentages.'],
        ['word_id' => '10', 'alt' => 'empirical formula', 'correct' => 'close', 'message' => 'Close, but give the word when it\'s reported as percentages.'],
        ['word_id' => '11', 'alt' => 'pure substances', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '11', 'alt' => 'chemical substance', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '11', 'alt' => 'chemical substances', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '11', 'alt' => 'substance', 'correct' => 'close', 'message' => 'Close, but be more specific and make it a phrase.'],
        ['word_id' => '11', 'alt' => 'substances', 'correct' => 'close', 'message' => 'Close, but be more specific and make it a phrase.'],
        ['word_id' => '12', 'alt' => 'compounds', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '13', 'alt' => 'mixtures', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '13', 'alt' => 'mix', 'correct' => 'close', 'message' => 'Close, but use the full technical term.'],
        ['word_id' => '13', 'alt' => 'mixes', 'correct' => 'close', 'message' => 'Close, but use the full technical term.'],
        ['word_id' => '14', 'alt' => 'solutions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '19', 'alt' => 'law', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '19', 'alt' => 'laws', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '19', 'alt' => 'scientific laws', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '20', 'alt' => 'hypotheses', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '21', 'alt' => 'theories', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '21', 'alt' => 'scientific theory', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '22', 'alt' => 'specific gravity', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '27', 'alt' => 'formula', 'correct' => 'close', 'message' => 'Give a specific type of formula. '],
        ['word_id' => '28', 'alt' => 'protons', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '29', 'alt' => 'neutrons', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '30', 'alt' => 'electrons', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '31', 'alt' => 'nuclei', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '32', 'alt' => 'electron shell', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '32', 'alt' => 'energy level', 'correct' => 'correct', 'message' => 'Ok, but I meant shell. '],
        ['word_id' => '34', 'alt' => 'isotopes', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '35', 'alt' => 'valence energy level', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '35', 'alt' => 'valence electron shell', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '36', 'alt' => 'family', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '36', 'alt' => 'groups', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '36', 'alt' => 'families', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '37', 'alt' => 'periods', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '38', 'alt' => 'formula', 'correct' => 'close', 'message' => 'Give a specific type of formula. '],
        ['word_id' => '39', 'alt' => 'alkali metals', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '39', 'alt' => 'alkalis', 'correct' => 'close', 'message' => 'People usually use two words. '],
        ['word_id' => '40', 'alt' => 'alkaline earth metals', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '40', 'alt' => 'alkaline earths', 'correct' => 'close', 'message' => 'People usually use three words. '],
        ['word_id' => '41', 'alt' => 'halogens', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '42', 'alt' => 'noble gases', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '42', 'alt' => 'inert gases', 'correct' => 'close', 'message' => 'They are not always perfectly inert, so another word is better. '],
        ['word_id' => '42', 'alt' => 'inert gas', 'correct' => 'close', 'message' => 'They are not always perfectly inert, so another word is better. '],
        ['word_id' => '43', 'alt' => 'metals', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '44', 'alt' => 'nonmetals', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '44', 'alt' => 'non-metal', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '44', 'alt' => 'non-metals', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '45', 'alt' => 'metallois', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '46', 'alt' => 'representative elements', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '46', 'alt' => 'main group element', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '46', 'alt' => 'main group elements', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '47', 'alt' => 'transition element', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '47', 'alt' => 'transition elements', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '47', 'alt' => 'transition metals', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '48', 'alt' => 'moles', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '49', 'alt' => 'particles', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '50', 'alt' => 'ions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '51', 'alt' => 'cations', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '52', 'alt' => 'anions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '53', 'alt' => 'bonding pairs', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '53', 'alt' => 'bonding electron pairs', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '53', 'alt' => 'bonding electron pair', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '54', 'alt' => 'non-bonding pair', 'correct' => 'correct', 'message' => 'Or lone pair. '],
        ['word_id' => '54', 'alt' => 'non-bonding electron pair', 'correct' => 'correct', 'message' => 'Or lone pair. '],
        ['word_id' => '54', 'alt' => 'non-bonding pairs', 'correct' => 'correct', 'message' => 'Or lone pair. '],
        ['word_id' => '54', 'alt' => 'non-bonding electron pairs', 'correct' => 'correct', 'message' => 'Or lone pair. '],
        ['word_id' => '54', 'alt' => 'lone pairs', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '55', 'alt' => 'convalent bonds', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '55', 'alt' => 'convalent bonding', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '56', 'alt' => 'ionic bonds', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '56', 'alt' => 'ionic bonding', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '59', 'alt' => 'chemical equations', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '59', 'alt' => 'equation', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '59', 'alt' => 'equations', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '60', 'alt' => 'reactants', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '60', 'alt' => 'reagents', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '60', 'alt' => 'reagent', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '61', 'alt' => 'products', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '62', 'alt' => 'coefficients', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '63', 'alt' => 'combination', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '63', 'alt' => 'combination reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '64', 'alt' => 'decomposition', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '64', 'alt' => 'decomposition reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '65', 'alt' => 'combustion', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '65', 'alt' => 'combustion reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '65', 'alt' => 'burning', 'correct' => 'close', 'message' => 'Close, but give the technical term. '],
        ['word_id' => '71', 'alt' => 'heat capacity', 'correct' => 'close', 'message' => 'Close, but there is a different term for heat capacity per unit mass. '],
        ['word_id' => '75', 'alt' => 'electrolytes', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '76', 'alt' => 'solutes', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '78', 'alt' => 'solvents', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '79', 'alt' => 'suspensions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '84', 'alt' => 'dipole-dipole attraction', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '84', 'alt' => 'dipole-dipole attractions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '84', 'alt' => 'dipole-dipole forces', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '85', 'alt' => 'London force', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '85', 'alt' => 'London dispersion force', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '85', 'alt' => 'London forces', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '85', 'alt' => 'London dispersion forces', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '85', 'alt' => 'dispersion forces', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '86', 'alt' => 'hydrogen bonds', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '86', 'alt' => 'hydrogen bonding', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '88', 'alt' => 'equilibria', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '88', 'alt' => 'chemical equilibrium', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '88', 'alt' => 'dynamic equilibria', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '88', 'alt' => 'dynamic equilibrium', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '89', 'alt' => 'precipitation reaction', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '89', 'alt' => 'precipitation reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '90', 'alt' => 'solubilities', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '91', 'alt' => 'acids', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '92', 'alt' => 'bases', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '93', 'alt' => 'neutralization reaction', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '93', 'alt' => 'neutralization reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '94', 'alt' => 'salts', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '99', 'alt' => 'dilutions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '105', 'alt' => 'reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '105', 'alt' => 'chemical reactions', 'correct' => 'correct', 'message' => ''],
        ['word_id' => '105', 'alt' => 'chemical reaction', 'correct' => 'correct', 'message' => ''],

        ];

        for ($i = 0 ; $i < count($altList) ; ++$i) {
      		DB::table('altwords')->insert([
            'word_id' => $altList[$i]['word_id'],
            'alt' => $altList[$i]['alt'],
            'correct' => $altList[$i]['correct'],
            'message' => $altList[$i]['message']
        ]);
      	}
    }
}