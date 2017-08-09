<template>
  <div>
    <button @click="showForm" class="btn btn-default"
      type="button" v-show="!show">I'm frustrated</button>
      <div v-show="show" class="panel panel-default">
          <div class="panel-heading">Frustration</div>
          <div class="panel-body">
            <div>I'm sorry you're frustrated! Please tell me why so I can improve the app.</div>
            <div class="">
              <textarea autofocus v-model="entry" @keyup.enter="submitEntry" type="text" class="form-control">
              </textarea>

                <button @click="submitEntry" class="btn btn-default btn-block"
                    type="button">Submit experience</button>
                <button @click="cancel" class="btn btn-default btn-block"
                    type="button">Never mind, I just wanted to express myself</button>

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
        let action = {type: 'frustrated', detail: this.entry,
          state_id: this.stateID, time: Date.now()}
        axios.post('../api/student/actions', action)
        .then((results) => {
          this.$store.dispatch('setMessage', 'Thanks for sharing your experience!');
          this.show = !this.show;
          this.entry = '';
        })
        .catch(function (error) {
          console.log(error);
        });
      },
      cancel: function(event) {
        let action = {type: 'frustrated', detail: 'null',
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
