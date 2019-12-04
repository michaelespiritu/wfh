<template>
    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{nameStore}}</span>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            userName: ''
        }
    },
    created () {
        this.$store.commit('SET_NAME', this.user.name)
        this.$store.commit('SET_IDENTIFIER', this.user.identifier)
        this.$store.commit('SET_ID', this.user.id)
        this.$store.commit('SET_HAS_CARD', this.user.has_card)
        this.$store.commit('SET_TITLE', this.user.profile ? this.user.profile.title : null)
        this.$store.commit('SET_SKILLS', this.user.skills_bank)

        var that = this
        this.user.meta.map(function (val) {
            if ( val.name == 'company_name' ) {
                return that.$store.commit('SET_COMPANY_NAME', val.value)
            }
            if ( val.name == 'company_hq' ) {
                return that.$store.commit('SET_COMPANY_HQ', val.value)
            }
            if ( val.name == 'company_url' ) {
                return that.$store.commit('SET_COMPANY_URL', val.value)
            }
            if ( val.name == 'company_description' ) {
                return that.$store.commit('SET_COMPANY_DESCRIPTION', val.value)
            }
            if ( val.name == 'cover_letter' ) {
                return that.$store.commit('SET_COVERLETTER', val.value)
            }
        })
    },
    computed: {
        nameStore () {
            return this.$store.state.Profile.Name
        }
    }
}
</script>