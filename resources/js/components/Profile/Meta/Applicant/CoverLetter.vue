<template>
    <div>
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-sm-flex justify-content-between align-content-between">
                    <h1 class="h3 mb-0 text-gray-800">Cover Letter</h1>
                    
                    <button @click="validateBeforeSubmit" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm">Save Changes</button>
                </div>
            </div>
            <div class="card-body">
                <wyswyg 
                    v-model="$store.state.Profile.Applicant.CoverLetter" 
                    data-vv-as="Cover Letter" 
                    name="coverLetter" 
                    v-validate="'required'"
                    :value="$store.state.Profile.Applicant.CoverLetter">
                    </wyswyg>
                <p v-if="errors.first('coverLetter')"><span class="help-block text-danger" >{{errors.first('coverLetter')}}</span></p>
            </div>
        </div>
    </div>
</template>

<script>
import Wyswyg from '../../../Misc/Wyswyg'
import SwalAlerts from '../../../Misc/SwalAlerts'
export default {
    mixins: [SwalAlerts],
    components: {
        Wyswyg,
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

                this.create()
            }).catch((e) => {
                console.log(e)
            });
        },
        create () {
            axios.post(`/dashboard/meta-data/${this.$store.state.Profile.Identifier}`, {
                name: 'cover_letter',
                value: this.$store.state.Profile.Applicant.CoverLetter
            })
            .then(response => {

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
                
            }).catch(err => {
                this.errorAlert(
                    `Something went wrong. <br> ${ err.response.data.hasOwnProperty('message') ? '<span class="text-danger">Tip</span>: ' + err.response.data.message : ''}`, 
                )
            })
        }
    }
}
</script>