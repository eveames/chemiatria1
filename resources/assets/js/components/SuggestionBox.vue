<template>
  <div>
    <button @click="showForm" class="btn btn-default"
      type="button" v-show="!show">Make a suggestion</button>
      <div v-show="show" class="panel panel-default">
          <div class="panel-heading">Suggestion</div>
          <div class="panel-body">
            <div>Cool! Please describe below:</div>
            <div class="input-group">
              <textarea autofocus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control">
              </textarea>
              <div class="input-group-btn">
                <button @click="submitEntry" class="btn btn-default btn-block"
                    type="button">Submit suggestion</button>
                <button @click="cancel" class="btn btn-default btn-block"
                    type="button">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </div>
  </template>

  <script>
  import {mapGetters, mapActions} from 'vuex'
  export default {
    data: function() {
        return {
          entry: '',
          show: false,
        }
    },
    computed: {
      ...mapGetters({
        stateID: 'getCurrentStateID'
      })
    },
    methods: {
      showForm: function(event) {
        this.show = !this.show;
      },
      submitEntry: function(event) {
        let action = {type: 'suggestion', detail: this.entry,
          state_id: this.stateID, time: Date.now()}
        axios.post('../api/student/actions', action)
        .then((results) => {
          this.$store.dispatch('setMessage', 'Thanks for sharing your suggestion!');
          this.show = !this.show;
          this.entry = '';
        })
        .catch(function (error) {
          console.log(error);
        });
      },
      cancel: function(event) {
        let action = {type: 'suggestion', detail: 'null',
          state_id: this.stateID, time: Date.now()}
        axios.post('../api/student/actions', action)
        .catch(function (error) {
          console.log(error);
        });
        this.show = !this.show;
      }
    }
  }
  </script>
