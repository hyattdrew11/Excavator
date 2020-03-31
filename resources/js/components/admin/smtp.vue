<template>
    <div id="admin" class="p-3 mt-2">

<!-- 
  ============================================================================================================================================  
-->
            <div id="modal" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add SMTP Connection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form autocomplete="off" @submit.prevent="addConnection" method="post">
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
                            <input required v-model="connection.from_address" type="text" class="form-control" placeholder="username" aria-label="username">
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                          <label>From Name</label>
                            <input required v-model="connection.from_name" type="text" class="form-control" placeholder="username" aria-label="username">
                          </div>
                        </div>

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

            <div id="testConnection" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Test SMTP Connection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form autocomplete="off" @submit.prevent="addConnection" method="post">
                      <div class="form-group">
                        <label>Test Recipiant Email</label>
                        <input required v-model="test.email" type="text" class="form-control" placeholder="name" aria-label="name">
                      </div>
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
                    <h4>SMTP Connections
                       <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal">Add Connection</button>
                       <button class="btn btn-sm btn-success float-right mr-1" data-toggle="modal" data-target="#testConnection">Test Connection</button>
                    </h4>
                    <hr />
                </div>
                <div class="col-md-6 text-right">
                     <div class="form-group">
                     <!--  <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon">Send Test</span>
                      </div>
                      <input required type="text" class="form-control" placeholder="email address" aria-label="email address" aria-describedby="basic-addon"> -->
                    </div>
                </div>
                 <div class="col-md-6">
                   <!--  <button   class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addUser">Add Connection</button> -->
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Host</th>
                        <th scope="col">Port</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Encryption</th>
                        <th scope="col">Active</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(x, index) in connections">
                      <th scope="row">{{ x.name }}</th>
                      <th scope="row">{{ x.host }}</th>
                      <th scope="row">{{ x.port }}</th>
                      <th scope="row">{{ x.username }}</th>
                      <th scope="row">{{ x.password }}</th>
                      <th scope="row">{{ x.encryption }}</th>
                      <th scope="row"> 
                        <ToggleButton 
                        :value="x.active"
                        @change="activateSMTP(x)" 
                        :font-size="12"
                        class="mt-1 wt-500"
                      />
                      </th>
                       <th scope="row"> 
                        <button class="btn btn-sm btn-block btn-danger" @click="removeSMTP()">Delete</button>
                       </th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
</template>

<script>
    import { ToggleButton } from 'vue-js-toggle-button'
    export default {
        name: 'index-admin',
        props: ['admin','users','connections', 'jobs'],
        data() {
            return { 
                test: { 
                  email: null,
                  message: null,
                },
                connection: {
                    name: null,
                    host: null,
                    port: null,
                    username: null,
                    password: null,
                    from_address: null,
                    from_name: null,
                    active: 0,
                }
            }
        },
        components: {
          'ToggleButton': ToggleButton
        },
        methods: {
          activateSMTP(connection) {
            console.log(connection)
            if(connection.active == 0) {
              connection.active++
            }
            else {
              connection.active = 0
            }
            let x = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            window.axios.post('/activate/connection', connection , { headers : x })
              .then(({ data }) => { 
                setTimeout(() => { 
                  // window.location.reload() 
                }, 500)
              })
              .catch(function (e) { })
          },
          removeSMTP() {
            confirm('Delete SMTP connection.')
          },
          testConnection(evt) { 
            console.log(evt, this.connection)
          },
          addConnection(evt) {
            console.log(evt, this.connection)
            evt.preventDefault()
            let x = { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            window.axios.post('/add/connection', this.connection , { headers : x })
              .then(({ data }) => { 
                if(data) { 
                  this.connections.push(data)
                  // document.getElementById("modal").hide();
                  
                  // $('#modal')modal('hide')


                  // this.$refs.addConnection.hide()
                  this.connection = {
                    name: null,
                    host: null,
                    port: null,
                    username: null,
                    password: null,
                    active: 0,
                  }
                }
              })
              .catch(function (e) { console.log(e) })
          }
        }
    }
</script>
<style lang="scss"></style>