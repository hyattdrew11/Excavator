<template>
    <div id="admin" class="mt-2">
    <div id="">
            <div class="col-md-12">
                <h5>Report Selection
                     <button @click="send()" type="submit" class="btn btn-sm btn-primary float-right">Submit</button>
                </h5>
                <hr />
                <form>
                <div class="report-section">
                    <h4 class="report-section-title">Select Reports(s)</h4>
                    <div class="form-check mb-2 choice"  v-for="(x, index) in form.reports" :class="{parent : x.child.length > 0 }"> 
                        <input type="checkbox" class="form-check-input" v-model="x.value" @change="updateReport(index)">
                        <label class="form-check-label">{{ x.label }}</label>
                        <div class="child" :class="{ active : x.value }" v-if="x.value" v-for="(c, childIndex) in x.child">
                            <input type="checkbox" class="form-check-input" v-model="c.value" @change="updateChild(index, childIndex)">
                            <label class="form-check-label">{{ c.label }}</label>
                        </div>
                    </div>
                </div>
                <div class="report-section">
                     <h4 class="report-section-title">Enter Key(s)</h4>
                     <div class="form-check mb-2 choice-inline"  v-for="(x, index) in form.keys" :class="{parent : x.child.length > 0 }"> 
                        <input type="checkbox" class="form-check-input" v-model="x.value" @change="updateReport(index)">
                        <label class="form-check-label">{{ x.label }}</label>
                        <div class="child" :class="{ active : x.value }" v-if="x.value" v-for="(c, childIndex) in x.child">
                            <input type="number" required class="form-check-input" v-model="c.value">
                            <label class="form-check-label">{{ c.label }}</label>
                        </div>
                    </div>
                </div>
                <div class="report-section">
                    <h4 class="report-section-title">Select Brand(s)</h4>
                    <p>
                        <span  class="btn btn-sm btn-primary" @click="selectBrands()">All</span>
                        <span  class="btn btn-sm btn-primary" @click="deselectBrands()">None</span>
                    </p>
                    <div class="form-check mb-2 choice-inline"  v-for="(x, index) in form.brands"> 
                        <input type="checkbox" class="form-check-input" v-model="x.value" @change="updateReport(index)">
                        <label class="form-check-label">{{ x.label }}</label>
                    </div>
                </div>
                 <div class="report-section">
                    <h4 class="report-section-title">PII Section</h4>
                    <label>{{ form.pii.label }}</label>
                     <div class="form-check mb-2 choice">
                        <input type="checkbox" class="form-check-input" v-model="form.pii.include.value" @change="updatePII()">
                        <label class="form-check-label">{{ form.pii.include.label }}</label>
                        <div v-if="form.pii.include.value">
                            <div class="form-group">
                                 <label class="form-check-label">File Name</label>
                                <input type="text" class="form-control" v-model="form.pii.PIIFileName">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label">Password</label>
                                <input type="password" class="form-control" v-model="form.pii.PIIPassword">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</template>

<script>
    // import LineChart from './LineChart.js'
    export default {
        name: 'index-admin',
        props: ['admin', 'user', 'users','connections', 'jobs'],
        data() {
            return {
                loading: false,
                job: {
                    name: null,
                }   ,
                form: {
                    name: '',
                    email: this.user.email,
                     reports: [
                        {
                            value: false,
                            label: 'Lead and Waterfall Data....Returns all records received for the requested lead with the DIG waterfall data.',
                            header: 'IncludeLeadData',
                            child: []
                        },
                        {
                            value: false,
                            label: 'Future Events......................Returns all scheduled campaigns (solicitations) for the requested lead.',
                            header: 'IncludeFutureEvents',
                            child: []
                        },
                         {
                            value: false,
                            label: 'Solicitation History..........Returns the campaign (solicitation) history for the requested lead.',
                            header: 'IncludeSolicitationHistory',
                            child: [
                                {
                                    value: false,
                                    header: 'IncludeSKUInfo',
                                    label: 'Include SKU Information',
                                }
                            ]
                        },
                        {
                            value: false,
                            label: 'Sales and Notifications......Returns all sales and notifications records for requested lead.',
                            header: 'IncludeSalesInfo',
                            child: [],
                        },
                    ],
                    keys : [
                         {
                            value: false,
                            label: 'SNLeadID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SNLeadProductID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SENSUS_OWNED_PRODUCT_ID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SENSUS_PERSON_ID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SolicitationID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'Contract Number',
                            child: [{
                                value: null
                            }]
                        },
                    ],
                    brands: [
                        {
                            value: false,
                            label: 'Whirlpool',
                            header: 'IncludeWhirlpoolBrand'
                        },
                        {
                            value: false,
                            label: 'Maytag',
                            header: 'IncludeMaytagBrand'
                        },
                        {
                            value: false,
                            label: 'Amana',
                            header: 'IncludeAmanaBrand'
                        },
                        {
                            value: false,
                            label: 'Jenn-Air',
                            header: 'IncludeJennAirBrand'
                        },
                        {
                            value: false,
                            label: 'KitchenAid',
                            header: 'IncludeKitchenAidBrand'
                        },
                    ],
                    pii : {
                        label : 'Check the box below to include Personal Identifying Information in the report.',
                        include: {
                            value: false,
                            label: 'Include PII',
                            header: 'IncludePII'
                        },
                        PIIFileName: null,
                        PIIPassword: null,
                    }
                }
            }
        },
        mounted() {
             console.log(this.form.email)
        },
        methods: {
            selectBrands() {
                let x
                let brands = this.form.brands
                for(x in brands) {
                    brands[x].value = true
                }
            },
            deselectBrands() {
                let x
                let brands = this.form.brands
                for(x in brands) {
                    brands[x].value = false
                }
            },
            updateReport(index) {
                let report = this.form.reports[index]
                    report.value != report.value
            },
            updateChild(reportIndex, childIndex) {},
            updatePII() {
                 let pii = this.form.pii
                 pii.include.value != pii.include.value
            },
            send() {
                this.$Progress.start()
                this.loading = true
                let a
                let b 
                let brands = this.form.brands

                for(b in brands) {
                    if(brands[b].value == true) {
                        a = true
                    }
                }
                if(a == true) {
                    let x = {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                    window.axios.post('/job',this.form , { headers : x })
                      .then(({ data }) => { 
                        if(data) { 
                            alert("Report Submitted") 
                            this.$Progress.finish()
                            this.loading = false
                            window.location.reload()
                        }
                      })
                      .catch(function (e) { console.log(e) })
                }
                else {
                    alert("Please select at least one brand.")
                }
            }
        }
    }
</script>
<style lang="scss">

    #admin {
        display: inline-block;
        float: left;
        width: 85%;
        padding: 35px 5px 125px 5px;
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