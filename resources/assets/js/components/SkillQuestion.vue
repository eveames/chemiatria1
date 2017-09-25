<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <sigfig-question v-if="currentQuestion[5] === 'sigfig'"></sigfig-question>
          <ionic-formula-question v-if="currentQuestion[5] === 'ionicFormula'"></ionic-formula-question>
          <lewis-structure-question v-if="currentQuestion[5] === 'LewisStructure'"></lewis-structure-question>
      </div>
  </div>
</div>
</template>


<style>
</style>
<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  //props: ['questionTypeID'],
  computed: {
    ...mapGetters({
      currentQuestion: 'getCurrent',
    }),
  },
  created () {
  },
}
</script>
