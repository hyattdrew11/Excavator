<template>
  <div id="admin" class="p-3 mt-2">
    <div class="row mt-2">
      <div class="col-md-12">
        <h4>Reports</h4>
        <hr />
      </div>
      <div class="col-md-12">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">User Email</th>
              <th scope="col">Form</th>
            </tr>
          </thead>
          <tbody>
            <tr  v-for="(x, index) in jobs">
              <th scope="row">{{ x.id }}</th>
              <th scope="row">{{ x.email }}</th>
              <th scope="row">
                <button class="btn btn-sm btn-primary" @click="showResults(x.form)">View Results</button>
              </th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div id="previewForm" :class="{'d-none': !previewForm}">
      <h4>
        Report 
        <i class="fa fa-times pointer float-right" @click="hideResults()"></i>
      </h4>
      <hr />
      <pre class="tx-10">{{ currentForm }}</pre>
    </div>
  </div>
</template>

<script>
    export default {
        name: 'index-admin',
        props: ['admin','users','connections', 'jobs'],
        data() {
            return { 
              currentForm: null,
              previewForm: false,
            }
        },
        mounted() {},
        components: {},
        methods: {
          showResults(form) {
            this.currentForm = JSON.parse(form)
            this.previewForm  = true
          },
          hideResults() {
            this.currentForm = null
            this.previewForm = false
          }
        }
    }
</script>
<style lang="scss">
  #previewForm {
    position: fixed;
    padding: 25px 15px 150px 15px;
    top: 58px;
    height: 100%;
    width: calc(100% - 215px);
    background-color: #FFF;
    overflow: scroll;
    left: 215px;
}
</style>