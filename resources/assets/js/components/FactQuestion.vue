<template>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <polyatomic-ion-question v-if="fact.group_name === 'polyatomic ions' ||
            fact.group_name === 'acids' "></polyatomic-ion-question>
          <element-symbol-question v-if="fact.group_name === 'elementSymbol'"></element-symbol-question>
          <element-charge-question v-if="fact.group_name === 'elementCharge'"></element-charge-question>
          <element-group-question v-if="fact.group_name === 'elementGroup'"></element-group-question>
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
    fact: function () {
      return this.$store.getters.getFactById(this.currentQuestion[1]);
    },
  },
  created () {
  },
}
</script>
