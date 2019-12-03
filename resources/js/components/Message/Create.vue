<template>
    <div v-if="receiver">
            <wyswyg 
                class="text-justify"
                v-model="message" 
                data-vv-as="Message" 
                name="message" 
                v-validate="'required'"
                :value="message">
                </wyswyg>
            <p v-if="errors.first('message')"><span class="help-block text-danger" >{{errors.first('message')}}</span></p>

        <button
            v-if="!loading"
            class="btn btn-sm btn-primary rounded-0 my-2 btn-block"
            @click="validateBeforeSubmit"
        >
            Send
        </button>

        <div class="progress my-2" v-else>
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</template>

<script>
import wyswyg from '../Misc/Wyswyg'
import SwalAlerts from '../Misc/SwalAlerts'
export default {
    props: ['receiver', 'modal'],
    mixins: [SwalAlerts],
    components: {
        wyswyg
    },
    data() {
        return {
            message: null,
            loading: false
        }
    },
    methods: {
        validateBeforeSubmit () {
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
            this.loading = true

            axios.post('/message', {
                message: this.message,
                receiver_id: this.receiver
            }).then( response => {
                this.successAlert(
                    response.data.success,
                    'Success',
                    {
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: () => {
                            $(`#${this.modal}`).modal('hide')
                            this.message = null
                            this.$validator.reset()
                            Object.keys(document.getElementsByTagName('trix-editor')).forEach(function(key) {
                                document.getElementsByTagName('trix-editor')[key]['value'] = null
                            })

                            this.loading = false

                        }
                    }
                )
            }).catch( error => {
                this.errorAlert()
                this.loading = false
            })

        }
    }
}
</script>