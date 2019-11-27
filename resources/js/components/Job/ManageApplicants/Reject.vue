<template>
    <div class="col-4">
        <p class="h3 text-center">Rejected</p>
        <hr>
        <draggable 
                v-model="reject" 
                class="dragArea"
                group="applicants"
                @change="applicantUpdate"
            >
            
            <div 
                v-for="(applicant, index) in reject"
                :key="index"
                class="col-sm-12" 
                >
                <div 
                    data-toggle="modal" >
                    <div 
                        class="card px-3 py-3 mb-3 cursor-pointer"
                        >
                        <div class="d-lg-flex align-items-center justify-content-between mb-2">
                            <div class="text-center text-lg-left">
                                <p itemprop="title" class="h4 mb-0">
                                    {{ applicant.user.name }}
                                </p>
                                <p class="mb-0"><small>{{ applicant.user.title }}</small></p>
                            </div>
                            <div class="text-center text-lg-right">
                                
                                <p>
                                    <span :class="`badge badge-${applicant.status}`">{{ applicant.status }}</span>
                                </p>
                            </div>
                        </div>

                        <p class="mb-0">
                            <small>
                                <span itemprop="datePosted">
                                    Date Applied: {{ applicant.date_applied }}
                                </span>
                            </small>
                        </p>

                    </div>
                </div>

            </div>

        </draggable>    
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import SwalAlerts from '../../Misc/SwalAlerts'
export default {
    mixins: [SwalAlerts],
    props: ['applicants', 'type'],
    components: {
        draggable,
    },
    computed: {
        reject: {
            get() {
                return this.$store.state.Applicant.Reject
            },
            set(value) {
                this.$store.commit('SET_APPLCIANT_REJECT', value)
                this.$store.commit('SET_APPLICANT_TEMP', value)
            }
        }
    },
    methods: {
        applicantUpdate (evt) {
            if (evt.hasOwnProperty('added')) {
                this.updateOrder(
                    evt.added.element.identifier,
                    `${evt.added.element.user.name} has been moved to Reject`
                )
            }
        },
        updateOrder (target, message) { 
            axios.post(`/application/${target}/update-status`, {
                status: 'Reject', 
                type: 'Reject'
            })
            .then(response => {
                this.$store.commit('SET_APPLCIANT_REJECT', response.data.applicants)

                this.successAlert(
                    message, 
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