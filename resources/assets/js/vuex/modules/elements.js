import * as types from '../mutation_types'
const state = {
  elementsList: [{name: 'hydrogen', symbol: 'H', family: 'non-metal', location: '1', charge: 1, valence: 1, findex: 8},
      {name: 'helium', symbol: 'He', family: 'noble gas', location: '2', charge: 0, valence: 2, findex: 4},
      {name: 'lithium', symbol: 'Li', family: 'alkali metal', location: '3', charge: 1, valence: 1, findex: 2},
      {name: 'beryllium', symbol: 'Be', family: 'alkaline earth metal', location: '4', charge: 2, valence: 2, findex: 3},
      {name: 'boron', symbol: 'B', family: 'Boron group', location: '5', charge: 3, valence: 3, findex: 8},
      {name: 'carbon', symbol: 'C', family: 'Carbon group', location: '6', charge: 0, valence: 4, findex: 8},
      {name: 'nitrogen', symbol: 'N', family: 'Nitrogen group (pnictogen)', location: '7', charge: -3, valence: 5, findex: 8},
      {name: 'oxygen', symbol: 'O', family: 'chalcogen', location: '8', charge: -2, valence: 6, findex: 1},
      {name: 'fluorine', symbol: 'F', family: 'halogen', location: '9', charge: -1, valence: 7, findex: 0},
      {name: 'bromine', symbol: 'Br', family: 'halogen', location: 'Hal', charge: -1, valence: 7, findex: 0},
      {name: 'iodine', symbol: 'I', family: 'halogen', location: 'Hal', charge: -1, valence: 7, findex: 0},
      {name: 'sodium', symbol: 'Na', family: 'alkali metal', location: '11', charge: 1, valence: 1, findex: 2},
      {name: 'magnesium', symbol: 'Mg', family: 'alkaline earth metal', location: '12', charge: 2, valence: 2, findex: 3},
      {name: 'aluminum', symbol: 'Al', family: 'Boron group', location: '13', charge: 3, valence: 3, findex: 9},
      {name: 'silicon', symbol: 'Si', family: 'Carbon group', location: '14', charge: 4, valence: 4, findex: 8},
      {name: 'phosphorus', symbol: 'P', family: 'Nitrogen group (pnictogen)', location: '15', charge: -3, valence: 5, findex: 8},
      {name: 'sulfur', symbol: 'S', family: 'chalcogen', location: '16', charge: -2, valence: 6, findex: 1},
      {name: 'chlorine', symbol: 'Cl', family: 'halogen', location: '17', charge: -1, valence: 7, findex: 0},
      {name: 'argon', symbol: 'Ar', family: 'noble gas', location: 'NG', charge: 0, valence: 8, findex: 4},
      {name: 'potassium', symbol: 'K', family: 'alkali metal', location: '19', charge: 1, valence: 1, findex: 2},
      {name: 'calcium', symbol: 'Ca', family: 'alkaline earth metal', location: '20', charge: 2, valence: 2, findex: 3},
      {name: 'titanium', symbol: 'Ti', family: 'transition metal', location: 'ETM', charge: 4, findex: 7},
      {name: 'iron', symbol: 'Fe', family: 'transition metal', location: 'MTM', charge: [3, 2], findex: 7},
      {name: 'copper', symbol: 'Cu', family: 'coinage metal', location: 'CM', charge: [2, 1], findex: 6},
      {name: 'mercury', symbol: 'Hg', family: '(post-)transition metal', location: 'PTM', charge: [2, 1], findex: 57},
      {name: 'silver', symbol: 'Ag', family: 'coinage metal', location: 'CM', charge: [2, 1], findex: 6},
      {name: 'gold', symbol: 'Au', family: 'coinage metal', location: 'CM', charge: [3, 1], findex: 6},
      {name: 'tin', symbol: 'Sn', family: 'post-transition metal', location: 'PTM', charge: [2, 4], valence: 4, findex: 5},
      {name: 'lead', symbol: 'Pb', family: 'post-transition metal', location: 'PTM', charge: [2, 4], valence: 4, findex: 5},
      {name: 'zinc', symbol: 'Zn', family: '(post-)transition metal', location: 'PTM', charge: [2], findex: 57}
    ],
    elementsCharges: [
    [{alt: 1, correct: 'correct', message: 'H is usually +1', op: 'equals'},
    {alt: -1, correct: 'close', message: 'Possible, but in special circumstances. ', op: 'equals'},
    {alt: 1, correct: 'knownWrong', message: 'H only has one electron to lose, so it can\'t have a charge above +1. ', op: 'greater'},
    {alt: -1, correct: 'knownWrong', message: 'It would be almost impossible to add more than 1 electron to H. ', op: 'less'}],
    [{alt: 0, correct: 'correct', message: 'Noble gases pretty much never have charge. ', op: 'equals'},
    {alt: 0, correct: 'knownWrong', message: 'Noble gases pretty much never have charge. ', op: 'notEqual'}],
    [{alt: 1, correct: 'correct', message: 'Alkali metals always have +1 charge. ', op: 'equals'},
    {alt: 1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 2, correct: 'correct', message: 'Alkaline earth metals always have +2 charge. ', op: 'equals'},
    {alt: 2, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 3, correct: 'correct', message: 'Boron often has a +3 charge. ', op: 'equals'},
    {alt: 0, correct: 'close', message: 'Like carbon, boron forms many compounds in which it shares electrons, but it does form ionic compounds also. ', op: 'equals'}],
    [{alt: 0, correct: 'correct', message: 'Carbon usually shares electrons, rather than forming ions. ', op: 'equals'},
    {alt: 0, correct: 'knownWrong', message: 'Carbon usually shares electrons, and rarely forms ions. ', op: 'notEqual'}],
    [{alt: -3, correct: 'correct', message: 'When nitrogen forms an ion, it\'s usually -3 charge. ', op: 'equals'},
    {alt: -3, correct: 'close', message: 'In some situations, N can have many different charges, but this isn\'t the usual charge. ', op: 'notEqual'}],
    [{alt: -2, correct: 'correct', message: 'O almost always has a -2 charge. ', op: 'equals'},
    {alt: -2, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: -1, correct: 'correct', message: 'F always has a -1 charge. ', op: 'equals'},
    {alt: -1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: -1, correct: 'correct', message: 'Halogens almost always have a -1 charge. ', op: 'equals'},
    {alt: -1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: -1, correct: 'correct', message: 'Halogens almost always have a -1 charge. ', op: 'equals'},
    {alt: -1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 1, correct: 'correct', message: 'Alkali metals always have +1 charge. ', op: 'equals'},
    {alt: 1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 2, correct: 'correct', message: 'Alkaline earth metals always have +2 charge. ', op: 'equals'},
    {alt: 2, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 3, correct: 'correct', message: 'Aluminum always has +3 charge. ', op: 'equals'},
    {alt: 3, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 4, correct: 'correct', message: 'Si often has a 4+ charge when it occurs in rocks. ', op: 'equals'},
    {alt: 0, correct: 'close', message: 'Si doesn\'t share electrons as much as C. ', op: 'equals'}],
    [{alt: -3, correct: 'correct', message: 'When P forms an ion, it\'s usually -3 charge. ', op: 'equals'},
    {alt: -3, correct: 'close', message: 'P can have many different charges, but this is not the usual one. ', op: 'notEqual'}],
    [{alt: -2, correct: 'correct', message: 'S usually has a -2 charge. ', op: 'equals'},
    {alt: -2, correct: 'knownWrong', message: 'S can have many different charges, but this is not the usual one. ', op: 'notEqual'}],
    [{alt: -1, correct: 'correct', message: 'Cl almost always has a -1 charge. ', op: 'equals'},
    {alt: -1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 0, correct: 'correct', message: 'Noble gases pretty much never have charge. ', op: 'equals'},
    {alt: 0, correct: 'knownWrong', message: 'Noble gases pretty much never have charge. ', op: 'notEqual'}],
    [{alt: 1, correct: 'correct', message: 'Alkali metals always have +1 charge. ', op: 'equals'},
    {alt: 1, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 2, correct: 'correct', message: 'Alkaline earth metals always have +2 charge. ', op: 'equals'},
    {alt: 2, correct: 'knownWrong', message: '', op: 'notEqual'}],
    [{alt: 4, correct: 'correct', message: 'Ti usually has a 4+ charge. ', op: 'equals'},
    {alt: 0, correct: 'close', message: 'Transition elements often have multiple charges, but Ti is usually +4. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 3, correct: 'correct', message: 'Fe usually has a 3+ or 2+ charge. ', op: 'equals'},
    {alt: 2, correct: 'correct', message: 'Fe usually has a 3+ or 2+ charge. ', op: 'equals'},
    {alt: 0, correct: 'close', message: 'Fe can have a range of charges, but is +2 or +3 normally. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 2, correct: 'correct', message: 'Cu usually has a 1+ or 2+ charge. ', op: 'equals'},
    {alt: 1, correct: 'correct', message: 'Cu usually has a 1+ or 2+ charge. ', op: 'equals'},
    {alt: 2, correct: 'close', message: 'Cu rarely has a charge above 2+. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 2, correct: 'correct', message: 'Hg usually has a 1+ or 2+ charge. ', op: 'equals'},
    {alt: 1, correct: 'correct', message: 'Hg usually has a 1+ or 2+ charge. ', op: 'equals'},
    {alt: 2, correct: 'close', message: 'Hg does\'t have a charge above 2+. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 1, correct: 'correct', message: 'Ag usually has a 1+ charge. ', op: 'equals'},
    {alt: 2, correct: 'correct', message: 'Ag occasionally has a 2+ charge. ', op: 'equals'},
    {alt: 2, correct: 'close', message: 'Ag rarely has a charge above 2+. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 1, correct: 'correct', message: 'Au usually has a 1+ or +3 charge. ', op: 'equals'},
    {alt: 3, correct: 'correct', message: 'Au usually has a 1+ or 3+ charge. ', op: 'equals'},
    {alt: 3, correct: 'close', message: 'Au rarely has a charge above 3+. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 4, correct: 'correct', message: 'Sn usually has a 2+ or 4+ charge. ', op: 'equals'},
    {alt: 2, correct: 'correct', message: 'Sn usually has a 2+ or 4+ charge. ', op: 'equals'},
    {alt: 0, correct: 'knownWrong', message: 'Metals may have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 4, correct: 'correct', message: 'Pb usually has a 2+ or 4+ charge. ', op: 'equals'},
    {alt: 2, correct: 'correct', message: 'Pb usually has a 2+ or 4+ charge. ', op: 'equals'},
    {alt: 0, correct: 'knownWrong', message: 'Metals may have multiple charges, but always positive. ', op: 'less'}],
    [{alt: 2, correct: 'correct', message: 'Zn always has a 2+ charge. ', op: 'equals'},
    {alt: 2, correct: 'close', message: 'Zn does\'t have a charge above 2+. ', op: 'greater'},
    {alt: 0, correct: 'knownWrong', message: 'Transition elements often have multiple charges, but always positive. ', op: 'less'}]],
    //element data for drawing Lewis structures
    //1: valence e-
    //2: normal min e- (octet count)
    //3: normal max e- (octet count)
    //4: normal valence (num bonds)
    //5: max valence when oxidized (num bonds)
    //6: min valence (num bonds)
    lewisElements: {
      H: ['H', 1, 2, 2, 1,1,1],
      He: ['He', 2, 2,2,0,0,0],
      Li: ['Li',1,2,8,1,4,1],
      Be: ['Be',2,4,8,2,4,2],
      B: ['B',3,6,8,3,4,3],
      C: ['C', 4, 8, 8, 4,4,3],
      N: ['N', 5,7,8,3,4,1],
      O: ['O', 6, 8, 8,2,3,1],
      F: ['F', 7, 8,8,1,1,1],
      Ne: ['Ne',8,8,8,0,0,0],
      Si: ['Si',4,8,8,4,4,3],
      P: ['P',5,8,12,3,5,2],
      S: ['S', 6, 8, 12,2,6,1],
      Cl: ['Cl',7,8,16,1,7,1],
      Ge: ['Ge',4,8,8,4,4,3],
      As: ['As',5,8,12,3,6,2],
      Se: ['Se',6,8,12,2,6,1],
      Br: ['Br', 7,8,16,1,7,1],
      Sb: ['Sb',5,8,12,3,5,2],
      Te: ['Te',6,8,12,2,6,1],
      I: ['I',7,8,16,1,7,1],
      Xe: ['Xe',8,8,16,0,8,0]
    },

    bboxesForLewisText: {},

    LewisHomoDiatomics: ['H2', 'N2', 'O2', 'F2', 'Cl2', 'Br2', 'I2', 'S2', 'P2', 'Se2'],
    LewisHeteroDiatomics: ['HF', 'HCl', 'HBr', 'HI', 'ClF', 'BrF', 'IF', 'BrCl', 'ICl', 'IBr', 'CO', 'NO', 'SO', 'NP', 'HO', 'ClO'],
    LewisSimpleCentralMulti: ['BH3', 'CH4', 'NH3', 'OH2', 'SiH4', 'PH3', 'SH2', 'AsH3', 'SeH2', 'BF3', 'CF4', 'SiF4', 'GeF4', 'PF3',
    'PF5', 'AsF3','AsF5', 'SbF3', 'SbF5', 'SF2', 'SF4', 'SF6', 'SeF2', 'SeF4', 'SeF6', 'TeF2', 'TeF4', 'TeF6', 'ClF3', 'BrF3',
    'BrF5', 'IF3', 'IF5', 'BeCl2', 'BCl3', 'CCl4', 'SiCl4', 'NCl3', 'PCl3', 'PCl5', 'AsCl3', 'AsCl5','SbCl3', 'SbCl5', 'SCl2',
    'SCl4', 'SeCl2', 'SeCl4', 'TeCl2', 'TeCl4', 'BrCl3', 'ICl3', 'CBr4', 'CI4','CO2', 'CS2', 'SiO2', 'NO2', 'SO2', 'SO3', 'SeO2', 'SeO3',
    'TeO2', 'TeO3', 'XeO2', 'XeO4', 'XeF2', 'XeF4', 'XeF6', 'O3'],
    LewisTriatomicCentral: ['COCl2', 'COF2', 'COH2', 'CHF3', 'CH2F2', 'CH3F', 'CHCl3', 'CH2Cl2', 'CH3Cl', 'CHBr3', 'CH2Br2',
    'CH3Br', 'CHI3', 'CH2I2', 'CH3I', 'CSO', 'POCl3', 'POF3', 'XeOF2', 'XeOF4', 'CHN'],
    covalentCompounds: [['CO', 'carbon monoxide'],['BF3', 'boron trifluoride'], ['CF4', 'carbon tetrafluoride'], ['SiF4','silicon tetrafluoride'],
     ['PF3','phosphorus trifluoride'], ['PF5', 'phosphorus pentafluoride'], ['AsF3', 'arsenic trifluoride'],
     ['AsF5', 'arsenic pentafluoride'], ['SF2', 'sulfur difluoride'], ['SF4', 'sulfur tetrafluoride'],
     ['SF6', 'sulfur hexafluoride'], ['SeF2', 'selenium difluoride'], ['SeF4', 'selenium tetrafluoride'],
     ['SeF6', 'selenium hexafluoride'], ['TeF2', 'tellurium difluoride'], ['TeF4', 'tellurium tetrafluoride'],
     ['TeF6', 'tellurium hexafluoride'], ['ClF3', 'chlorine trifluoride'], ['BrF3', 'bromine trifluoride'],
     ['BrF5', 'bromine pentafluoride'], ['IF3', 'iodine trifluoride'], ['IF5', 'iodine pentafluoride'],
     ['BCl3', 'boron trichloride'], ['CCl4', 'carbon tetrachloride'], ['SiCl4', 'silicon tetrachloride'],
     ['NCl3', 'nitrogen trichloride'], ['PCl3', 'phosphorus trichloride'], ['PCl5', 'phosphorus pentachloride'],
     ['AsCl3', 'arsenic trichloride'], ['AsCl5', 'arsenic pentachloride'],['SCl2', 'sulfur dichloride'],
     ['SCl4', 'sulfur tetrachloride'], ['SeCl2', 'selenium dichloride'], ['SeCl4', 'selenium tetrachloride'],
     ['TeCl2', 'tellurium dichloride'], ['TeCl4','tellurium tetrachloride'], ['BrCl3', 'bromine trichloride'],
     ['ICl3', 'iodine trichloride'], ['CBr4', 'carbon tetrabromide'], ['CI4', 'carbon tetriodide'],['CO2', 'carbon dioxide'],
     ['CS2', 'carbon disulfide'], ['SiO2', 'silicon dioxide'], ['NO2', 'nitrogen dioxide'], ['SO2', 'sulfur dioxide'],
     ['SO3', 'sulfur trioxide'], ['SeO2', 'selenium dioxide'], ['SeO3', 'selenium trioxide'],['TeO2', 'tellurium dioxide'],
     ['TeO3', 'tellurium trioxide'], ['XeO2', 'xenon dioxide'], ['XeO3', 'xenon trioxide'], ['XeO4', 'xenon tetroxide'],
     ['XeF2', 'xenon difluoride'], ['XeF4', 'xenon tetrafluoride'], ['XeF6', 'xenon hexafluoride'], ['N2O4', 'dinitrogen tetroxide'],
     ['N2O5', 'dinitrogen pentoxide'], ['P2O5', 'diphosphorus pentoxide'], ['B2F4', 'diboron tetrafluoride'],
     ['B2Cl4', 'diboron tetrachloride'], ['B2Br4', 'diboron tetrabromide'], ['B3F5', 'triboron pentafluoride'],
     ['B4Cl4', 'tetraboron tetrachloride'], ['B2O3', 'diboron trioxide'], ['N2F4', 'dinitrogen tetrafluoride'],
     ['N2F2', 'dinitrogen difluoride'],['N3F', 'trinitrogen fluoride'], ['NO3', 'nitrogen trioxide'],
     ['N2O3', 'dinitrogen trioxide'], ['N2O2', 'dinitrogen dioxide'], ['P2F4', 'diphosphorus tetrafluoride'],
     ['P2Cl4', 'diphosphorus tetrachloride'], ['P2I4', 'diphosphorus tetraiodide'], ['P2S3', 'diphosphorus trisulfide'],
     ['P4O6', 'tetraphosphorus hexoxide'], ['P4S2', 'tetraphosphorus disulfide'], ['P4S3', 'tetraphosphorus trisulfide'],
     ['P4S4', 'tetraphosphorus tetrasulfide'], ['P4S5', 'tetraphosphorus pentasulfide'], ['S2F2', 'disulfur difluoride'],
     ['S2F4', 'disulfur tetrafluoride'], ['S2Cl2', 'disulfur dichloride'], ['S6O2', 'hexasulfur dioxide'],
     ['S4N4', 'tetrasulfur tetranitride'], ['S2N2', 'disulfur dinitride'], ['S4N2', 'tetrasulfur dinitride'],
     ['S5Cl2', 'pentasulfur dichloride'], ['S5N6', 'pentasulfur hexanitride'], ['I2O5', 'diodine pentoxide'],
     ['Cl2O', 'dichlorine monoxide'], ['ClO2', 'chlorine dioxide'], ['Cl2O4', 'dichlorine tetroxide'],
     ['Cl2O6', 'dichlorine hexoxide'], ['ClO3', 'chlorine trioxide'], ['BrO2', 'bromine dioxide'], ['HF', 'hydrogen fluoride'],
      ['HCl', 'hydrogen chloride'], ['HBr', 'hydrogen bromide'], ['HI', 'hydrogen iodide'], ['H2S', 'hydrogen sulfide']]

}

// getters
const getters = {
  getElementByIndex: (state, getters) => (index) => {
    console.log('in getElementByIndex', index)
    return state.elementsList[index];
  },
  getElementChargesByIndex: (state, getters) => (index) => {
    console.log('in getElementChargesByIndex', index)
    return state.elementsCharges[index];
  },
  getElements: (state) => state.elementsList,
  getLSE: (state) => state.lewisElements,
  getLewisHomoDiatomics: (state) => state.LewisHomoDiatomics,
  getLewisHeteroDiatomics: (state) => state.LewisHeteroDiatomics,
  getLewisSimpleCentral: (state) => state.LewisSimpleCentralMulti,
  getLewisTriatomicCentral: (state) => state.LewisTriatomicCentral,
  getCovalentCompounds: (state) => state.covalentCompounds,
  getBBoxes: (state) => state.bboxesForLewisText,
}

const actions = {
  setupBBoxes ({commit}, bboxes) {
    commit(types.SET_BBOXES, bboxes);
  }
}

const mutations = {
  [types.SET_BBOXES] (state, bboxes) {
    //console.log('in INITIALIZE_STATES')
    state.bboxesForLewisText = bboxes;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
