<template>
    <div class="row">
        <waiting></waiting>
        <shortlist></shortlist>
        <reject></reject>
    </div>
</template>

<script>
import Waiting from './Waiting'
import Shortlist from './Shortlist'
import Reject from './Reject'

export default {
    props: ['reject', 'shortlist', 'waiting'],
    components: {
        Waiting,
        Reject,
        Shortlist,
    },
    created () {
        this.$store.commit('SET_APPLCIANT_WAITING', this.waiting)
        this.$store.commit('SET_APPLCIANT_REJECT', this.reject)
        this.$store.commit('SET_APPLCIANT_SHORTLIST', this.shortlist)
    },
    computed: {
        // applicantsData () {
        //     return this.$store.state.Applicant.Data
        // }
    }
}
</script>