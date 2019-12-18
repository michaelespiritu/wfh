<template>
    <div class="row">
        <div class="col-4" v-for="(board, index) in $store.state.Applicant.Boards" :key="index">
            <p class="h3 text-center">{{ board.name }}</p>
            <hr>
            <draggable
                :list="board.applicants"
                class="dragArea"
                group="applicants"
                @change="applicantUpdate($event, board)"
                >
                <div 
                    v-for="(applicant, index) in board.applicants"
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
                                        <span :class="`badge badge-${applicant.status.name}`">{{ applicant.status.name }}</span>
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
    </div>
</template>

<script>
import draggable from 'vuedraggable'
import SwalAlerts from '../../Misc/SwalAlerts'
export default {
    mixins: [SwalAlerts],
    props: ['boards'],
    components: {
        draggable,
    },
    created () {
        this.$store.commit('SET_JOB_BOARD', this.boards)
    },
    computed: {
        boarding: {
            get() {
                return this.$store.state.Applicant.Boards
            },
            set(value) {
                console.log(value)
                this.$store.commit('SET_JOB_BOARD', value)
            }
        }
    },
    methods: {
        applicantUpdate: function (evt, board) {
            if (evt.hasOwnProperty('added')) {
                this.updateOrder(
                    evt.added.element.identifier,
                    board.identifier,
                    `${evt.added.element.user.name} has been moved to ${board.name}`
                )
            }
        },
        updateOrder (target, board, message) { 
            axios.post(`/application/${target}/update-status`, {
                status: board
            })
            .then(response => {
                this.$store.commit('SET_JOB_BOARD', response.data.applicants)
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
