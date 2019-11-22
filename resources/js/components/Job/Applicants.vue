<template>
    <div class="row">
        <div 
            class="text-center col-12"
            v-if="$store.state.Applicant.Data.length == 0">
            <div class="card">
                <div class="card-body">
                    <p class="h3 mb-0">No Data Found.</p>
                </div>
            </div>
        </div>

        <div 
            v-else
            v-for="(applicant, index) in $store.state.Applicant.Data"
            :key="index"
            class="col-sm-12 col-md-6" 
            >
            <div 
                @click="$store.commit('SET_APPLICANT_TEMP', applicant)"
                data-toggle="modal" 
                :data-target="`#applicantModal-${ applicant.identifier }`">
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

        <div 
            v-if="$store.state.Applicant.Temp"
            class="modal fade" 
            :id="`applicantModal-${ $store.state.Applicant.Temp.identifier }`" 
            tabindex="-1" 
            role="dialog" 
            :aria-labelledby="`applicantModal-${ $store.state.Applicant.Temp.identifier }-Label`" 
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header align-items-center">
                        <div>
                            <h5 
                                class="modal-title mb-0" 
                                :id="`applicantModal-${ $store.state.Applicant.Temp.identifier }-Label`">
                                {{ $store.state.Applicant.Temp.user.name }}
                            </h5>
                            <p class="mb-0"><small>{{ $store.state.Applicant.Temp.user.title }}</small></p>
                            <div class="text-center text-lg-left" v-html="$store.state.Applicant.Temp.user.skills">
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <p class="mb-0">
                                <small>
                                    <span itemprop="datePosted">
                                        Date Applied: {{ $store.state.Applicant.Temp.date_applied }}
                                    </span>
                                </small>
                            </p>

                            <applicant-status 
                                :id="`applicantModal-${ $store.state.Applicant.Temp.identifier }`"
                                ></applicant-status>
                        </div>
                    </div>

                    <div class="modal-body">
                        

                        <div itemprop="description" class="text-left mb-3" v-html="$store.state.Applicant.Temp.cover_letter"></div>

                        
                    </div>

                </div>

            </div>
        </div>

        
    </div>
</template>

<script>
export default {
    props: ['applicants', 'type'],
    created () {
        this.$store.commit('SET_APPLICANT_TYPE', this.type)
        this.$store.commit('SET_APPLICANT_DATA', this.applicants)
    },
    computed: {
        applicantsData () {
            return this.$store.state.Applicant.Data
        }
    }
}
</script>