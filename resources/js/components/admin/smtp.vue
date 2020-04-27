<template>
    <div id="admin" class="p-3 mt-2">

            <div id="testConnection" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="">Test SMTP Connection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form autocomplete="off" @submit.prevent="testConnection" method="post">
                      <div class="form-group">
                        <label>Test Recipiant Email</label>
                        <input required v-model="test.email" type="email" class="form-control" placeholder="name" aria-label="name">
                      </div>
                       <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

<!-- 
  ============================================================================================================================================  
-->

             <div class="row mt-2">
               <div class="col-md-12">
                    <h4>SMTP Connection
                       <button class="btn btn-sm btn-success float-right mr-1" data-toggle="modal" data-target="#testConnection">Test Connection</button>
                    </h4>
                    <hr />
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Host</th>
                        <th scope="col">Port</th>
                        <th scope="col">Username</th>
                        <th scope="col">Encryption</th>
                        <th scope="col">From Address</th>
                        <th scope="col">From Name</th>
                        <th scope="col">Report Target Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">{{ smtp_host }}</th>
                        <th scope="row">{{ smtp_port }}</th>
                        <th scope="row">{{ smtp_username }}</th>
                        <th scope="row">{{ smtp_encryption }}</th>
                        <th scope="row">{{ smtp_from_address }}</th>
                        <th scope="row">{{ smtp_from_name }}</th>
                        <th scope="row">{{ smtp_report_target }}</th>
                      </tr>
                    </tbody>
                  </table>
                  <span>
                    <em>Update your environment vairables to change SMTP settings.</em>
                  </span>
                </div>
              </div>
        </div>
</template>

<script>
    import { ToggleButton } from 'vue-js-toggle-button'
    export default {
        name: 'index-admin',
        props: [
          'admin',
          'users',
          'connections',
          'jobs',
          'smtp_host',
          'smtp_port',
          'smtp_username',
          'smtp_encryption',
          'smtp_from_address',
          'smtp_from_name',
          'smtp_report_target'
        ],
        watch: { 
          connections: function(newVal, oldVal) { 
            if(newVal) {
              this.connections = newVal
            }
          }
        },
        data() {
            return { 
                test: { 
                  email: null
                },
                connection: this.connections[0]
            }
        },
        components: {
          'ToggleButton': ToggleButton
        },
        methods: {
          testConnection(evt) { 
            evt.preventDefault()
            this.$Progress.start()
            let x = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            window.axios.post('/test/connection', this.test , { headers : x })
              .then(({ data }) => { 
                if(data) { 
                  let close = document.getElementById("testConnection");
                  close.click()
                  this.$Progress.finish()
                  alert("Test email sent to "+this.test.email)
                }else {
                  this.$Progress.fail()
                  alert('Error sending test email.');
                }
              })
              .catch(function (e) { alert(e) })
          },
          editConnection(evt) {
            evt.preventDefault()
            this.$Progress.start()
            let x = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            window.axios.post('/update/connection', this.connection , { headers : x })
              .then(({ data }) => { 
                if(data) { 
                  this.connection = data
                  this.connections[0] = data
                  let close = document.getElementById("closeConnection");
                  close.click()
                  this.$Progress.finish()
                }else {
                  this.$Progress.fail()
                  alert('Error creating connection');
                }
              })
              .catch(function (e) { alert(e) })
          }
        }
    }
</script>
<style lang="scss"></style>