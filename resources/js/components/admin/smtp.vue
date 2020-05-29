<template>
    <div id="admin" class="p-3 mt-2">


      <div id="modal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SMTP Connection</h5>
                    <button id="closeConnection" type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form autocomplete="off" @submit.prevent="editConnection" method="post">
                      <div class="row">

                        <!-- <div class="col-md-6">
                          <div class="form-group">
                            <label>Connection Name</label>
                            <input required v-model="connection.name" type="text" class="form-control" placeholder="name" aria-label="name">
                          </div>
                        </div> -->

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Host</label>
                            <input required v-model="connection.host" type="text" class="form-control" placeholder="host" aria-label="host">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Port</label>
                            <input required v-model="connection.port" type="text" class="form-control" placeholder="port" aria-label="port">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Username</label>
                            <input required v-model="connection.username" type="text" class="form-control" placeholder="username" aria-label="username">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                           <label>Password</label>
                            <input required v-model="connection.password" type="password" class="form-control" placeholder="password" aria-label="password">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label>From Email Address</label>
                            <input required v-model="connection.from_address" type="email" class="form-control" placeholder="username" aria-label="username">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label>From Name</label>
                            <input required v-model="connection.from_name" type="text" class="form-control" placeholder="username" aria-label="username">
                          </div>
                        </div>

                         <div class="col-md-6">
                          <div class="form-group">
                          <label>Report Target Email</label>
                            <input required v-model="connection.target_email" type="text" class="form-control" placeholder="username" aria-label="username">
                          </div>
                        </div>

                      </div>

                      <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>


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
                      <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal">Edit Connection</button>
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
                        <th scope="col">Password</th>
                        <th scope="col">Encryption</th>
                        <th scope="col">From Address</th>
                        <th scope="col">From Name</th>
                        <th scope="col">Report Target Email</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(x, index) in connections" :key="x.id">
                      <!-- <th scope="row">{{ x.name }}</th> -->
                      <th scope="row">{{ x.host }}</th>
                      <th scope="row">{{ x.port }}</th>
                      <th scope="row">{{ x.username }}</th>
                      <th scope="row">••••••</th>
                      <th scope="row">{{ x.encryption }}</th>
                      <th scope="row">{{ x.from_address }}</th>
                      <th scope="row">{{ x.from_name }}</th>
                      <th scope="row">{{ x.target_email }}</th>
                      </tr>
                    </tbody>
                  </table>
                  <span>
                    <!-- <em>Update your environment vairables to change SMTP settings.</em> -->
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