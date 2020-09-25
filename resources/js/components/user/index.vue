<template>
    <div id="main-form" :class="{loading : loading}">
        <i id="loader" v-if="loading" class="fa fa-spinner fa-pulse fa-3x fa-fw" ></i>
            <div id="" :class="{loading : loading}">
                <div class="col-md-12">
                    <h5 id="user-report-header">DIG Excavator</h5>
                    <form>
                <div class="report-section">
                    <h4 class="report-section-title">Select Reports(s)
                        <span class="ml-3">
                            <span  class="btn btn-sm btn-primary" @click="selectReports()">Select All</span>
                            <span  class="btn btn-sm btn-primary" @click="deselectReports()">None</span>
                        </span>
                    </h4>
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
                     <h4 class="report-section-title">Search</h4>
                     <p>You may request multiple values in each field by separating the key values with a comma.</p>
                     <div class="form-check mb-2 fw key-container"  v-for="(x, index) in form.keys" :class="{parent : x.child.length > 0 }"> 
                        <label class="form-check-label inline key-label">{{ x.label }}</label>
                            <textarea v-for="(c, childIndex) in x.child" rows="1" type="text" required class="key-input" v-model="c.value"></textarea>

                    </div>
                    <h4 class="report-section-title">
                        Address
                        <span class="tx-12">(partial and incomplete addresses are allowed but multiple addresses per request are not currently supported)</span>
                    </h4>

                    <div class="form-check mb-2 fw key-container"  v-for="(x, index) in form.addresses" :class="{parent : x.child.length > 0 }"> 
                        <label class="form-check-label inline float-left key-label">{{ x.label }}</label>
                        <textarea  v-for="(c, childIndex) in x.child" rows="1" type="text" required class="key-input" v-model="c.value"></textarea>
                    </div>


                </div>
                <div class="report-section">
                    <h4 class="report-section-title">Select Brand(s)
                        <span class="ml-3">
                            <span  class="btn btn-sm btn-primary" @click="selectBrands()">Select All</span>
                            <span  class="btn btn-sm btn-primary" @click="deselectBrands()">None</span>
                        </span>
                    </h4>
                    <div class="form-check mb-2 choice-inline"  v-for="(x, index) in form.brands"> 
                        <input type="checkbox" class="form-check-input" v-model="x.value" @change="updateReport(index)">
                        <label class="form-check-label">{{ x.label }}</label>
                    </div>
                </div>
                 <div class="report-section">
                    <h4 class="report-section-title">Other Options</h4>
                    <label>{{ form.pii.label }}</label>
                     <div class="form-check mb-2 choice">
                        <div class="form-group">
                                 <label class="form-check-label">File Name (Optional)</label>
                                <input type="text" class="form-control" v-model="form.pii.PIIFileName">
                            </div>
                        <input type="checkbox" class="form-check-input" v-model="form.pii.include.value" @change="updatePII()">
                        <label class="form-check-label">{{ form.pii.include.label }}</label>
                        <div v-if="form.pii.include.value">
                            <div class="form-group">
                                <label class="form-check-label">Password<sup>*</sup></label>
                                <input type="password"  autocomplete="password" class="form-control" v-model="form.pii.PIIPassword">
                            </div>
                        </div>
                    </div>
                     <button :disabled="lockSubmit" @click="send()" type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
                <hr />
            </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'index-admin',
        props: ['admin', 'user', 'users','connections', 'jobs'],
        data() {
            return {
                lockSubmit: false,
                loading: false,
                job: {
                    name: null,
                }   ,
                form: {
                    name: '',
                    email: this.user.email,
                     reports: [
                        {
                            value: true,
                            label: 'Lead and Waterfall Data....Returns all records received for the requested lead with the DIG waterfall data.',
                            header: 'IncludeLeadData',
                            child: []
                        },
                        {
                            value: true,
                            label: 'Future Events......................Returns all scheduled campaigns (solicitations) for the requested lead.',
                            header: 'IncludeFutureEvents',
                            child: []
                        },
                         {
                            value: true,
                            label: 'Solicitation History..........Returns the campaign (solicitation) history for the requested lead.',
                            header: 'IncludeSolicitationHistory',
                            child: [
                                {
                                    value: true,
                                    header: 'IncludeSKUInfo',
                                    label: 'Include SKU Information',
                                }
                            ]
                        },
                        {
                            value: true,
                            label: 'Sales and Notifications......Returns all sales and notifications records for requested lead.',
                            header: 'IncludeSalesInfo',
                            child: [],
                        },
                    ],
                    keys : [
                         {
                            value: false,
                            label: 'SNLeadID(s)',
                            header: 'SNLeadID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SNLeadProductID(s)',
                            header: 'SNLeadProductID',
                            child: [{
                                value: null
                            }]
                        },
                         {
                            value: false,
                            label: 'SolicitationID(s)',
                            header: 'SolicitationID',
                            child: [{
                                value: null
                            }]
                        },
                         {
                            value: false,
                            label: 'Client Contract Number(s)',
                            header: 'ContractNumber',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SENSUS_OWNED_PRODUCT_ID(s)',
                            header: 'SENSUS_OWNED_PRODUCT_ID',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'SENSUS_PERSON_ID(s)',
                            header: 'SENSUS_PERSON_ID',
                            child: [{
                                value: null
                            }]
                        },
                         {
                            value: false,
                            label: 'Email Address(es)',
                            header: 'Email',
                            child: [{
                                value: null
                            }]
                        },
                    ],
                    addresses : [ 
                        {
                            value: false,
                            label: 'Street (ex: 123 Anystreet, Suite 100)',
                            header: 'Address',
                            child: [{
                                value: null
                            }]
                        },
                        {
                            value: false,
                            label: 'City/State/Zip (Ex: New York, NY 10001)',
                            header: 'City_State_ZIP',
                            child: [{
                                value: null
                            }]
                        }
                    ],
                    brands: [
                        {
                            value: true,
                            label: 'Whirlpool',
                            header: 'IncludeWhirlpoolBrand'
                        },
                        {
                            value: true,
                            label: 'Maytag',
                            header: 'IncludeMaytagBrand'
                        },
                        {
                            value: true,
                            label: 'Amana',
                            header: 'IncludeAmanaBrand'
                        },
                        {
                            value: true,
                            label: 'Jenn-Air',
                            header: 'IncludeJennAirBrand'
                        },
                        {
                            value: true,
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
             updateReport(index) {
                let report = this.form.reports[index]
                    report.value != report.value
            },
            selectReports() {
                let x
                let reports = this.form.reports
                for(x in reports) {
                    reports[x].value = true
                    if(reports[x].header === "IncludeSolicitationHistory") {
                        reports[x].child[0].value = true
                    }
                }
            },
            deselectReports() {
                let x
                let reports = this.form.reports
                for(x in reports) {
                    reports[x].value = false
                    if(reports[x].header === "IncludeSolicitationHistory") {
                        reports[x].child[0].value = false
                    }
                }
            },
            selectBrands() {
                let x
                let brands = this.form.brands
                for(x in brands) { brands[x].value = true }
            },
            deselectBrands() {
                let x
                let brands = this.form.brands
                for(x in brands) { brands[x].value = false }
            },
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
                            let rmQuotes = this.form.keys[b].child[0].value.replace(/['"]+/g, '')
                            this.form.keys[b].child[0].value = rmQuotes
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
                               alert("Your report request has been submitted. You will receive your results via email within 15 minutes.")
                                window.location.reload()
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
    width: 100%;
}
.small {
    max-width: 600px;
    margin:  150px auto;
}
</style>