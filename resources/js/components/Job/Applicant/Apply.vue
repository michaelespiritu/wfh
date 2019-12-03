<template>
    <div>
        
        <p class="text-center mt-3 ">
            <button 
                    type="button" 
                    class="btn w-25 btn-lg rounded-0 btn-primary" 
                    data-toggle="modal" 
                    data-target="#applyModal"
                    data-keyboard="false"
                    data-backdrop="static"
                >
                    Apply
            </button>
        </p>

        <!-- Modal -->
        <div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="applyModalLabel">Apply to {{ job.title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="h3">By applying to this post, you agree to send your Profile information to this company.</p>
                    <p class="small text-muted">Put other relevant information such as contact details.</p>
                    <wyswyg 
                        class="text-justify"
                        v-model="$store.state.Profile.Applicant.CoverLetter" 
                        data-vv-as="Cover Letter" 
                        name="coverLetter" 
                        v-validate="'required'"
                        :value="$store.state.Profile.Applicant.CoverLetter">
                        </wyswyg>
                    <p v-if="errors.first('coverLetter')"><span class="help-block text-danger" >{{errors.first('coverLetter')}}</span></p>
                </div>

                <div class="progress mx-3 my-3" v-if="$store.state.Process.Loading">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="modal-footer" v-else>
                    <div>
                        <button type="button" class="btn rounded-0 btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn rounded-0 btn-primary" @click="validateBeforeSubmit">Apply</button>
                    </div>
                </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import wyswyg from '../../Misc/Wyswyg'
import SwalAlerts from '../../Misc/SwalAlerts'

export default {
    mixins: [SwalAlerts],
    props: ['job'],
    components: {
        wyswyg
    }, 
    computed: {
        complete () {
            return this.$store.state.Process.Complete
        }
    },
    watch: {
        complete (value) {
            if (value) {
                $('#applyModal').modal('hide')
            }
        }
    },
    methods: {
        validateBeforeSubmit () {
            this.$store.commit('SET_LOADING', true)
            this.$validator.validateAll().then((result) => {
                if(!result){

                    this.errorAlert('Some required fields are missing.')

                    return
                }

                this.submitDetails()
            }).catch((e) => {
                console.log(e)
            });
        },
        submitDetails () {
            axios.post( `${this.job.apply_path}`, {
                cover_letter: this.$store.state.Profile.Applicant.CoverLetter
            })
            .then(response => {
                this.successAlert(
                    response.data.success,
                    'Success',
                    {
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: () => {
                            $('#applyModal').modal('hide')
                            this.$store.commit('SET_LOADING', false)
                        }
                    }
                )
            }).catch(err => {
                console.log(err)
                this.errorAlert(
                    `Something went wrong. <br> ${ err.response.data.hasOwnProperty('message') ? '<span class="text-danger">Tip</span>: ' + err.response.data.message : ''}`,
                    'Ooppss!',
                    {
                        onClose: () => {
                            $('#applyModal').modal('hide')
                            this.$store.commit('SET_LOADING', false)
                        }
                    }
                )
            })
        }
    }
}
</script>