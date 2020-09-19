<template>
        <div id="main-form" :class="{loading : loading}">
             <i id="loader" v-if="loading" class="fa fa-spinner fa-pulse fa-3x fa-fw" ></i>
    <div id="" :class="{loading : loading}">
            <div class="col-md-12">
                <h5 id="user-report-header">Report Selection
                    <button :disabled="lockSubmit" @click="send()" type="submit" class="btn btn-sm btn-primary float-right">Submit</button>
                </h5>
                <!-- <hr /> -->
                <form>
                <div class="user-report-section">
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
                <div class="user-report-section">
                     <h4 class="report-section-title">Enter Key(s)</h4>
                     <div class="form-check mb-2 choice-inline"  v-for="(x, index) in form.keys" :class="{parent : x.child.length > 0 }"> 
                        <input type="checkbox" class="form-check-input" v-model="x.value" @change="updateReport(index)">
                        <label class="form-check-label">{{ x.label }}</label>
                        <div class="child" :class="{ active : x.value }" v-if="x.value" v-for="(c, childIndex) in x.child">
                            <input type="text" required class="form-check-input" v-model="c.value">
                            <label class="form-check-label">{{ c.label }}</label>
                        </div>
                    </div>
                </div>
                <div class="user-report-section">
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
                 <div class="user-report-section">
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
                                <input type="password"  autocomplete="password" class="form-control" v-model="form.pii.PIIPassword">
                            </div>
                        </div>
                    </div>
                     <button :disabled="lockSubmit" @click="send()" type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
                <hr />
                <!-- <button @click="send()" type="submit" class="btn btn-sm btn-primary float-right">Submit</button> -->
            </form>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
        name: "efrom",
        props: ['user'],
        data() {
            return {
                lockSubmit: false,
                loading: false,
                job: {
                    name: null,
                },
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
            window.scrollTo(0,0);
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
                 setTimeout(function(){  window.scrollTo(0,document.body.scrollHeight);  }, 500);
            },
            send() {
                let vm = this
                let c = confirm("Would you like to submit this report? Click ok to continue.")
                if(c) {
                    this.lockSubmit = true
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
                    for(b in this.form.keys) {
                        let fld = this.form.keys[b].child[0].value
                        if(fld != null && fld.length > 0) {
                            console.log(fld)
                            let rmCommas = fld.replace(/\s+/g, '');
                            this.form.keys[b].child[0].value = rmCommas
                            console.log(rmCommas)
                        }
                    }
                    if(a == true) {
                        let x = {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        window.axios.post('/job',this.form , { headers : x })
                          .then(({ data }) => { 
                            if(data) { 
                                let cp = confirm("Report Submitted. Click ok to start a new report.")
                                if(cp) {
                                    window.location.href = "/login"
                                }
                                this.$Progress.finish()
                                this.loading = false 
                                this.lockSubmit = false
                            }
                          })
                          .catch(function (e) { 
                            console.log(e) 
                            alert("There was a problem submitting the report. Please check your internet connection and tray again.")
                            vm.loading = false
                            vm.$Progress.finish()
                            vm.lockSubmit = false
                        })
                    }
                    else {
                        alert("Please select at least one brand.")
                        this.loading = false
                        this.$Progress.finish()
                        this.lockSubmit = false
                    }
                }
                else {}
            }
        }
    }
</script>
<style lang="scss"></style>