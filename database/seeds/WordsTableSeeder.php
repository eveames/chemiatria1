<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vocabList = [
    ['word'=> 'matter', 'prompts'=> ['the stuff everything is made of', 
    'stuff', 'anything that has mass and occupies space', 'the physical material of everything']],
    ['word'=> 'property', 'prompts'=> ['a distinguishing characteristic', 
    'something that helps us tell one material from another', 
    'a particular quality or attribute of a material']],
    ['word'=> 'element', 'prompts'=> ['the fundamental types of matter', 
    'the simplest form of substance', 'a material that has only one type of atom']],
    ['word'=> 'atom', 'prompts'=> ['the building block of everything (if you ask a chemist)',
    'tiniest chunk of an element', 'particles molecules are made of']],
    ['word'=> 'molecule', 'prompts'=> ['a small group of atoms that is strongly attached to each other',
    'the smallest bit of a compound']],
    ['word'=> 'state of matter', 
    'prompts'=> ['whether something is a solid, liquid or gas']],
    ['word'=> 'solid', 'prompts'=> ['something hard', 
    'a material in a state where the atoms or molecules are held in fixed positions next to each other',
    'a material which does not flow and cannot be compressed']],
    ['word'=> 'liquid', 'prompts'=> ['something flowy (and heavy)', 
    'a material in a state in which the atoms or molecules are strongly held together but can move around',
    'a material in a state which can flow but cannot be compressed']],
    ['word'=> 'gas', 'prompts'=> ['something airy', 
    'a material in a state in which the atoms or molecules are far apart and bouncing around rapidly',
    'a material in a state which can flow and expands to fill available space']],
    ['word'=> 'composition', 'prompts'=> ['what kind of atoms a material is made of, and in what proportion',
    'percentage of each element in a material usually by mass', 'ratio of elements in a material, pure or impure']],
    ['word'=> 'pure substance', 'prompts'=> ['has only one type of atoms or molecules',
    'a material with constant properties and composition in all samples']],
    ['word'=> 'compound', 'prompts'=> ['a pure substance that is not a pure element',
    'a substance with a distinct ratio of different elements']],
    ['word'=> 'mixture', 'prompts'=> 
    ['a combination of substances that usually has properties similar or in between compared to the properties of the pure substances',
     'a material whose composition changes from sample to sample', 'a combo of materials that is not a compound']],
     ['word'=> 'solution', 'prompts'=> 
    ['a smooth, even mixture',
     'a mixture with constant composition', 'a homogeneous mixture']],
     ['word'=> 'homogeneous', 'prompts'=> 
    ['describes a smooth mixture',
     'describes a mixture with constant composition', 'describes a solution or mixture without lumps or bubbles']],
     ['word'=> 'heterogeneous', 'prompts'=> 
    ['describes an uneven, lumpy or bubbly mixture',
     'describes a mixture that is not a solution', 'describes a mixture with distinct regions of different composition']],
     ['word'=> 'intensive', 'prompts'=> 
    ['describes a property that does not depend on the size of the sample',
     'describes a property that stays the same when the amount changes']],
     ['word'=> 'extensive', 'prompts'=> 
    ['describes a property that depends on the size of the sample',
     'describes a property that increases when the amount of sample increases']],
    ['word'=> 'law', 'prompts'=> ['a reliable mathematical description of reality',
    'a mathematical summary of many observations and experiments']],
    ['word'=> 'hypothesis', 'prompts'=> ['a prediction or proposal about what happens or why',
    'an educated guess about an experiment or its explanation']],
    ['word'=> 'theory', 'prompts'=> ['a well-supported explanation for scientific observations',
    'an accepted interpretation of scientific results']],
    ['word'=> 'density', 'prompts'=> ['how heavy a substance is relative to its volume',
    'the ratio of mass to volume']],
    ['word'=> 'precision', 'prompts'=> ['how close together the results of a repeated experiment are',
    'the number of significant figures known for a quantity']],
    ['word'=> 'accuracy', 'prompts'=> ['how close a result is to the true value',
    'how correct a value is']],
    ['word'=> 'bias', 'prompts'=> ['a consistent experimental error',
    'an experimental error that causes repeated results to be off in the same direction']],
    ['word'=> 'atomic number', 'prompts'=> ['the number of protons in an atom',
    'the property by which the periodic table is organized']],
    ['word'=> 'empirical formula', 'prompts'=> ['a symbol representing the ratio of elements in a compound',
    'a way to show the relative numbers of each type of atom in a compound']],
    ['word'=> 'proton', 'prompts'=> ['the positively-charged particle',
    'a subatomic particle with positive charge']],
    ['word'=> 'neutron', 'prompts'=> ['a nuclear particle without charge',
    'a subatomic particle that has mass but not charge']],
    ['word'=> 'electron', 'prompts'=> ['the negatively-charged particle',
    'a subatomic particle with negative charge and very little mass']],
    ['word'=> 'nucleus', 'prompts'=> ['the tiny dense lump at the center of an atom',
    'the part of an atom that holds the positive charge and most of the mass']],
    ['word'=> 'shell', 'prompts'=> ['a group of electrons at similar energies and distances from the nucleus',
    'the principal grouping of electrons into energy levels']],
    ['word'=> 'mass number', 'prompts'=> ['the number of protons and neutrons in an atom',
    'the number that specifies which isotope an atom is']],
    ['word'=> 'isotope', 'prompts'=> ['atoms of the same element with different masses',
    'atoms with the same number of protons and different numbers of neutrons']],
    ['word'=> 'valence shell', 'prompts'=> ['the outermost electron shell that is not empty',
    'the electron shell that is responsible for bonding']],
    ['word'=> 'group', 'prompts'=> ['a column in the periodic table',
    'a groups of elements with similar properties and electron arrangements']],
    ['word'=> 'period', 'prompts'=> ['a row in the periodic table',
    'a group of elements that have the same valence electron shell']],
    ['word'=> 'molecular formula', 'prompts'=> ['a symbol representing the number of atoms of each type in a molecule',
    'a way to show how many atoms of each element are in a molecule']],
    ['word'=> 'alkali metal', 'prompts'=> ['the first group in the periodic table',
    'a group of soft, light, very reactive metals that form ions with a +1 charge']],
    ['word'=> 'alkaline earth metal', 'prompts'=> ['the second group in the periodic table',
    'a group of soft, light, reactive metals that form ions with a +2 charge']],
    ['word'=> 'halogen', 'prompts'=> ['the second-to-last group in the periodic table',
    'a group of reactive non-metals that tend to form ions with a -1 charge', 'a group of elements named for their ability to form salts']],
    ['word'=> 'noble gas', 'prompts'=> ['the last group in the periodic table',
    'a group of almost unreactive gaseous elements']],
    ['word'=> 'metal', 'prompts'=> ['a type of element that is usually a conductive, non-brittle solid',
    'the elements in the bottom left of the periodic table']],
    ['word'=> 'nonmetal', 'prompts'=> ['elements that are generally non-conductive, not shiny, and brittle if solid',
    'elements in the upper right of the periodic table']],
    ['word'=> 'metalloid', 'prompts'=> ['an element with properties between a metal and a nonmetal',
    'the elements on the border between metals and nonmetals']],
    ['word'=> 'representative element', 'prompts'=> ['elements in the tall, outside columns of the periodic table',
    'elements with relatively predictable charges and behavior']],
    ['word'=> 'transition metal', 'prompts'=> ['elements from the short middle section of the periodic table',
    'metallic elements with relatively unpredictable charges and properties']],
    ['word'=> 'mole', 'prompts'=> ['a unit representing a very large counted number of items, such as atoms or molecules',
    'Avogadro\'s number of anything']],
    ['word'=> 'particle', 'prompts'=> ['a general term for a small lump of something that acts as a unit',
    'a general word for things like atoms, protons, ions, etc']],
    ['word'=> 'ion', 'prompts'=> ['an atom or group of atoms that have a charge',
    'an atom or group of atoms with an unequal number of protons and electrons', 'an atom or group of atoms that has lost or gained electrons']],
    ['word'=> 'cation', 'prompts'=> ['an ion with positive charge',
    'an ion with more protons than electrons']],
    ['word'=> 'anion', 'prompts'=> ['an ion with negative charge',
    'an ion with less protons than electrons']],
    ['word'=> 'bonding pair', 'prompts'=> ['a pair of electrons shared between two atoms',
    'a pair of electrons that form a covalent bond']],
    ['word'=> 'lone pair', 'prompts'=> ['a pair of electrons that are not shared between atoms',
    'a pair of electrons that belong to a single atom']],
    ['word'=> 'covalent bond', 'prompts'=> ['a bond between two atoms formed by sharing an electron pair',
    'the thing that usually holds nonmetals together in molecules']],
    ['word'=> 'ionic bond', 'prompts'=> ['a chemical bond resulting from attraction between oppositely-charged ions',
    'the type of interaction typical when metals combine with nonmetals']],
    ['word'=> 'electronegativity', 'prompts'=> ['the ability of an atom in a molecule to attract electrons to itself',
    'how hard an atom tends to pull on bonding electrons']],
    ['word'=> 'polar', 'prompts'=> ['describes a molecule or bond in which charge is separated',
    'describes anything with + charge at one end and - charge at the other end']],
    ['word'=> 'chemical equation', 'prompts'=> ['represents a chemical reaction',
    'shows the starting and ending points for materials involved in a chemical change']],
    ['word'=> 'reactant', 'prompts'=> ['a substance that changes into something else during a reaction',
    'a material that is consumed during a chemical process']],
    ['word'=> 'product', 'prompts'=> ['a substance produced by a reaction',
    'a material that appears during a chemical process']],
    ['word'=> 'coefficient', 'prompts'=> ['a number showing the quantity of formula units involved in a reaction',
    'the part of a balanced equation that shows how many of each substance are involved']],
    ['word'=> 'combination reaction', 'prompts'=> ['a process in which several reactants form a single product',
    'a general term that applies to anhydride reactions and formation of compounds from elements']],
    ['word'=> 'decomposition reaction', 'prompts'=> ['a process in which one reactant forms several products',
    'a very general term which applies to reactions typical when solids are heated']],
    ['word'=> 'combustion reaction', 'prompts'=> ['a process in which a reactant combines with elemental oxygen',
    'the technical term for burning']],
    ['word'=> 'Avogadro\'s number', 'prompts'=> ['the number of items in a mole',
    'the number of amu in 1 g']],
    ['word'=> 'energy', 'prompts'=> ['the ability to do work',
    'the most general term for a quantity expressed in joules or calories']],
    ['word'=> 'heat', 'prompts'=> ['energy that moves from a hot object to a cold object',
    'thermal energy transferred between objects']],
    ['word'=> 'kinetic energy', 'prompts'=> ['energy from motion of objects or particles',
    'energy that depends on how fast things move']],
    ['word'=> 'potential energy', 'prompts'=> ['energy that comes from relative positions of objects or particles',
    'energy related to forces between objects or particles']],
    ['word'=> 'specific heat', 'prompts'=> ['the heat needed to increase the 1 g of a substance by 1 degree',
    'the heat capacity of a substance per unit mass']],
    ['word'=> 'thermal energy', 'prompts'=> ['energy related to random movements of particles',
    'the extensive quantity that determines temperature']],
    ['word'=> 'aqueous', 'prompts'=> ['water-based',
    'describes a solution whose solvent is water']],
    ['word'=> 'dissociation', 'prompts'=> ['separation of a substance into ions when it dissolves',
    'a process in which particles separate from each other during dissolution']],
    ['word'=> 'electrolyte', 'prompts'=> ['a substance that forms ions when it dissolves',
    'a substance whose solutions conduct electricity']],
    ['word'=> 'solute', 'prompts'=> ['the component of a solution that is dissolved',
    'the less-abundant component of a solution']],
    ['word'=> 'solvation', 'prompts'=> ['the interactions that stabilize a solution', 'the process in which solute particles are surrounded by solvent particles',
    'the interactions between solute and solvent']],
    ['word'=> 'solvent', 'prompts'=> ['the component of a solution in which something dissolves',
    'the more abundant component of a solution']],
    ['word'=> 'suspension', 'prompts'=> ['a mixture which contains small solid particles in liquid',
    'a cloudy liquid mixture that has small bits of solid']],
    ['word'=> 'condensation', 'prompts'=> ['the process in which a gas turns into a liquid',
    'the transition from vapor to liquid']],
    ['word'=> 'deposition', 'prompts'=> ['the process in which a gas turns into a solid',
    'the transition from vapor to solid']],
    ['word'=> 'sublimation', 'prompts'=> ['the process in which a solid becomes a gas',
    'the direct transition from solid to vapor']],
    ['word'=> 'pressure', 'prompts'=> ['the force applied to a surface divided by the area of the surface',
    'force applied per unit surface area']],
    ['word'=> 'dipole-dipole force', 'prompts'=> ['the attraction between oppositely-charged ends of polar molecules',
    'the interaction that holds polar molecules near each other']],
    ['word'=> 'dispersion force', 'prompts'=> ['the force that acts to attract all chemical entities to other chemical entities',
    'the attraction between temporary dipoles caused by random movement of electrons', 'the attraction between all molecules that gets stronger with more electrons']],
    ['word'=> 'hydrogen bond', 'prompts'=> ['the particularly-strong dipole-dipole force between N, O or F and H bound to N, O or F',
    'a strong dipole-dipole interaction between very small atoms making very polar bonds']],
    ['word'=> 'work', 'prompts'=> ['movement of matter against a resistance',
    'energy applied to organized, useful motion']],
    ['word'=> 'equilibrium', 'prompts'=> ['a state of balance without net change',
    'a situation in which total amounts of products and reactants are constant']],
    ['word'=> 'precipitation', 'prompts'=> ['the rapid formation of solid from dissolved particles',
    'the process of solute "crashing out of solution" as a solid']],
    ['word'=> 'solubility', 'prompts'=> ['ability to dissolve',
    'what quantity of a solute can dissolve in a solvent']],
    ['word'=> 'acid', 'prompts'=> ['a sour-tasting chemical',
    'a chemical that produces hydrogen ions when dissolved in water']],
    ['word'=> 'base', 'prompts'=> ['a slippery, bitter-tasting chemical that reacts with acids',
    'a chemical that produces hydroxide ions when dissolved in water']],
    ['word'=> 'neutralization', 'prompts'=> ['the complete reaction between an acid and a base',
    'a process in which acidic and basic reactants produce neutral products, usually water and a salt']],
    ['word'=> 'salt', 'prompts'=> ['an ionic compound',
    'an ionic compound formed by reaction between and acid and a base']],
    ['word'=> 'oxidation', 'prompts'=> ['the loss of electrons',
    'an increase in oxidation often caused by reaction with oxygen']],
    ['word'=> 'reduction', 'prompts'=> ['gain of electrons',
    'a decrease in oxidation state often accompanied by a decrease in mass of solid']],
    ['word'=> 'concentration', 'prompts'=> ['the relative amount of one component in a mixture',
    'the amount of solute per mass or volume or solution or solvent']],
    ['word'=> 'molarity', 'prompts'=> ['moles of solute per liter of solution',
    'a common unit of concentration relating moles of solute to volume of solution']],
    ['word'=> 'dilution', 'prompts'=> ['the process of reducing concentration by adding solvent',
    'a process in which the amount of solute stays constant and the amount of solvent increases']],
    ['word'=> 'diffusion', 'prompts'=> ['a process in which particles tend to spread out',
    'random motions of particles that tend to produce an even distribution of each type of particle']],
    ['word'=> 'insoluble', 'prompts'=> ['describes a substance with a very low solubility',
    'describes a substance of which very little can dissolve in a given solvent']],
    ['word'=> 'saturated', 'prompts'=> ['describes a solution with the maximum possible concentration of a given solute',
    'usually refers to solution in equilibrium with solid solvent']],
    ['word'=> 'hydrophilic', 'prompts'=> ['water-loving',
    'describes a polar substance with high affinity for water and low affinity for oil']],
    ['word'=> 'hydrophobic', 'prompts'=> ['water-fearing',
    'describes a relatively non-polar substance with low affinity for water and high affinity for oil']],
    ['word'=> 'reaction', 'prompts'=> ['a process of chemical change',
    'a transition from one set of chemicals to another']]
    

    ];

    for ($i = 0 ; $i < count($vocabList) ; ++$i) {
      		DB::table('words')->insert([
            'word' => $vocabList[$i]['word'],
            'prompts' => json_encode($vocabList[$i]['prompts']) 
        ]);
      	}
    
    }
}
