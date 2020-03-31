<template>
    <div id="admin" class="p-3 mt-4">
      <b-container>
        <b-row class="">
          <b-col md='4'>
            <span>Report Count</span>
          </b-col>
          <b-col md='4'>
            <span>SMTP Connection</span>
          </b-col>
           <b-col md='4'>
            <span>User Count</span>
          </b-col>
        </b-row>
      </b-container>

   <!--  <div class="small">
      <line-chart :chart-data="datacollection"></line-chart>
      <button @click="fillData()">Randomize</button>
    </div>

        <div id="addUser" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="name" aria-label="name">
                </div>
                <div class="input-group mb-3">
                  <input type="text" class="form-control" placeholder="email" aria-label="email">
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" placeholder="password" aria-label="password">
                </div>
                <div class="input-group mb-3">
                  <input type="password" class="form-control" placeholder="password confirm" aria-label="password confirm">
                </div>
                <div class="input-group mb-3">
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected>Select Role...</option>
                    <option value="1">Admin</option>
                    <option value="2">User</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div> -->



          <!--   <div class="row">
                <div class="col-md-12">
                    <h4>Users
                        <button   class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addUser">Add User</button>
                    </h4>
                    <hr />
                </div>
                <div class="col-md-6 text-right">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon">Search</span>
                      </div>
                      <input type="text" class="form-control" placeholder="search users" aria-label="search users" aria-describedby="basic-addon">
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addUser">Add User</button>
                </div>
                <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Role</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(x, index) in users">
                          <th scope="row">{{ x.id }}</th>
                          <td>{{ x.name }}</td>
                          <td>{{ x.email }}</td>
                          <td>{{ x.slug }}</td>
                        </tr>
                      </tbody>
                    </table>
                </div>
            </div> -->

             <!-- div class="row mt-2">
               <div class="col-md-12">
                    <h4>SMTP Connections
                       <button   class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addUser">Add Connection</button>
                    </h4>
                    <hr />
                </div>
                <div class="col-md-6 text-right">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon">Send Test</span>
                      </div>
                      <input type="text" class="form-control" placeholder="email address" aria-label="email address" aria-describedby="basic-addon">
                    </div>
                </div>
                 <div class="col-md-6">
                    <button   class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#addUser">Add Connection</button>
                </div>
                <div class="col-md-12">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Host</th>
                        <th scope="col">Port</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Encryption</th>
                        <th scope="col">Active</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(x, index) in connections">
                      <th scope="row">{{ x.id }}</th>
                      <th scope="row">{{ x.name }}</th>
                      <th scope="row">{{ x.host }}</th>
                      <th scope="row">{{ x.port }}</th>
                      <th scope="row">{{ x.username }}</th>
                      <th scope="row">{{ x.password }}</th>
                      <th scope="row">{{ x.encryption }}</th>
                      <th scope="row">{{ x.active }}</th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            <div class="row mt-2">
              <div class="col-md-12">
                <h4>Reports / Jobs</h4>
                <hr />
              </div>
              <div class="col-md-12">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr  v-for="(x, index) in jobs">
                      <th scope="row">{{ x.id }}</th>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div> -->
        </div>
</template>

<script>
    // import LineChart from './LineChart.js'
    export default {
        name: 'index-admin',
        props: ['admin','users','connections', 'jobs'],
        data() {
            return { 
                addUser: false,
                user: {
                    name: null,
                    email: null,
                    password: null,
                    confirm: null,
                    role: null
                },
                connection: {
                    name: null,
                    host: null,
                    port: null,
                    username: null,
                    password: null,
                    active: 0,
                },
                datacollection: null
            }
        },
        components: {},
        methods: {
          fillData () {
            this.datacollection = {
              labels: [this.getRandomInt(), this.getRandomInt()],
              datasets: [
                {
                  label: 'Data One',
                  backgroundColor: '#f87979',
                  data: [this.getRandomInt(), this.getRandomInt()]
                }, {
                  label: 'Data One',
                  backgroundColor: '#f87979',
                  data: [this.getRandomInt(), this.getRandomInt()]
                }
              ]
            }
          },
          getRandomInt () {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5
          }
        }
    }
</script>
<style lang="scss">

    #admin {
        display: inline-block;
        float: left;
        width: 85%;
        padding: 35px 5px 5px 5px;
        height: 100vh;
        overflow-y: scroll;
    }
   #adduser {
        min-height: 300px;
        // border: 1px solid #f7f7f7;
        // position: absolute;
        // top: -35px;
        // height: 95vh;
        // z-index: 200;
        // background-color: #fff;
        width: 100%;
    }
    .small {
      max-width: 600px;
      margin:  150px auto;
    }
</style>