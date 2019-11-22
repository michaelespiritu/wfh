<template>
    <div>
        <draggable 
                v-model="$store.state.Applicant.Data" 
                class="dragArea"
                group="applicants"
                @change="applicantUpdate"
            >
            
            <div 
                v-for="(applicant, index) in $store.state.Applicant.Data"
                :key="index"
                class="col-sm-12 col-md-6" 
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


                        <div itemprop="description" class="text-left mb-3" v-html="applicant.cover_excerpt"></div>

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

export default {
    props: ['applicants', 'type'],
    components: {
        draggable,
    },
    created () {
        this.$store.commit('SET_APPLICANT_DATA', this.applicants)
    },
    computed: {
        applicantsData () {
            return this.$store.state.Applicant.Data
        }
    },
    methods: {
        applicantUpdate (evt) {
            console.log(evt)
            // if (evt.hasOwnProperty('added')) {
            //     evt.added.element.status = 'todo'
            //     this.$store.commit('SET_TEMP_DATA', evt.added.element)
            // }
            
            // if (this.$store.state.ToDo.SetOrder) {
            //     this.updateOrder(this.$store.state.ToDo.ToDos)
            // }
        }
    }
}
</script>