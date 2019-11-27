<template>
    <div>
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-sm-flex justify-content-between align-content-between">
                    <h1 class="h3 mb-0 text-gray-800">Tell us about your Company</h1>
                    
                    <button @click="validateBeforeSubmit" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm">Save Changes</button>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label for="companyName" class="col-sm-12 col-form-label">Company Name</label>
                    <div class="col-sm-12">
                        <input 
                            type="text" 
                            v-model="$store.state.Profile.Company.Name" 
                            data-vv-as="Company Name"
                            v-validate="'required|min:2'" 
                            class="form-control" 
                            id="companyName" 
                            name="companyName" 
                            placeholder="Type your Company Name here">
                        <p class="mb-0" v-if="errors.first('companyName')"><span class="help-block text-danger" >{{errors.first('companyName')}}</span></p>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="companyHq" class="col-sm-12 col-form-label">Company HQ</label>
                    <div class="col-sm-12">
                        <input 
                            type="text" 
                            v-model="$store.state.Profile.Company.HQ" 
                            data-vv-as="Company HQ"
                            v-validate="'required|min:2'" 
                            class="form-control" 
                            id="companyHq" 
                            name="companyHq" 
                            placeholder="Type your Company Name here">
                        <p class="mb-0" v-if="errors.first('companyHq')"><span class="help-block text-danger" >{{errors.first('companyHq')}}</span></p>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="companyUrl" class="col-sm-12 col-form-label">Company URL</label>
                    <div class="col-sm-12">
                        <input 
                            type="text" 
                            v-model="$store.state.Profile.Company.URL" 
                            class="form-control" 
                            id="companyUrl" 
                            name="companyUrl" 
                            placeholder="Type your Company URL here">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="companyUrl" class="col-sm-12 col-form-label">Company Description</label>
                    <div class="col-sm-12">
                        <wyswyg 
                            v-model="$store.state.Profile.Company.Description" 
                            data-vv-as="Company Description" 
                            name="companyDescription" 
                            v-validate="'required'"
                            :value="$store.state.Profile.Company.Description">
                            </wyswyg>
                        <p v-if="errors.first('companyDescription')"><span class="help-block text-danger" >{{errors.first('companyDescription')}}</span></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Wyswyg from '../../../Misc/Wyswyg'
import SwalAlerts from '../../../Misc/SwalAlerts'

export default {
    props: ['user'],
    mixins: [SwalAlerts],
    components: {
        Wyswyg
    },
    methods: {
        validateBeforeSubmit () {
            this.loading = true

            this.$validator.validateAll().then((result) => {
                if(!result){
                    this.errorAlert(
                        'Some required fields are missing', 
                        'Oopps',
                        {
                            onClose: () => {
                                this.loading = false
                            }
                        }
                    )
                    
                    return
                }

                var end = false

                var payload = [
                        {
                            name: 'company_name',
                            value: this.$store.state.Profile.Company.Name,
                        },
                        {
                            name: 'company_hq',
                            value: this.$store.state.Profile.Company.HQ
                        },
                        {
                            name: 'company_url',
                            value: this.$store.state.Profile.Company.URL
                        },
                        {
                            name: 'company_description',
                            value: this.$store.state.Profile.Company.Description
                        },
                ]

                payload.forEach((val, key, array) => {
                    if(!array[key + 1]) end = true
                    this.create(val, end)
                })

            }).catch((e) => {
                console.log(e)
            });
        },
        create (payload, end) {
            axios.post(`/dashboard/meta-data/${this.$store.state.Profile.Identifier}`, payload)
            .then(response => {
                
                if (end) {
                    this.successAlert(
                        response.data.success, 
                        null,
                        {
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            onClose: () => {
                                this.loading = false
                            }
                        }
                    )
                }
                
            }).catch(err => {
                this.errorAlert(
                    `Something went wrong. <br> ${ err.response.data.hasOwnProperty('message') ? '<span class="text-danger">Tip</span>: ' + err.response.data.message : ''}`, 
                )
            })
        },
    }
}
</script>