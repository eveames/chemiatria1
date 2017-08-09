<template>
  <div>
    <button @click="showForm" class="btn btn-default"
      type="button" v-show="!show">Report Bug</button>
      <div v-show="show" class="panel panel-default">
          <div class="panel-heading">Report Bug</div>
          <div class="panel-body">
            <div>I'm sorry it's not working! Please describe what's gone wrong in detail so I can fix it.</div>
            <div class="input-group">
              <textarea autofocus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control">
              </textarea>
              <span class="input-group-btn">
                <button @click="submitEntry" class="btn btn-default"
                    type="button">Submit bug!</button>
                <button @click="cancel" class="btn btn-default"
                    type="button">Cancel</button>
              </span>
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
        let action = {type: 'bug report', detail: this.entry,
          state_id: this.stateID, time: Date.now()}
        axios.post('../api/student/actions', action)
        .then((results) => {
          this.$store.dispatch('setMessage', 'Thank you for your bug report!');
          this.show = !this.show;
          this.entry = ''
        })
        .catch(function (error) {
          console.log(error);
        });
      },
      cancel: function(event) {
        let action = {type: 'bug report', detail: 'cancelled',
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
