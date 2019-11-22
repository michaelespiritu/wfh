<script>
export default {
    methods: {
        validateBeforeSubmit (url, payload) {
            this.$store.commit('SET_LOADING', true)
            this.$store.commit('SET_COMPLETE', false)
            this.$validator.validateAll().then((result) => {
                if(!result){
                    this.$swal({
                        type: 'warning',
                        title: 'Oooppps!',
                        html: 'Some required fields are missing',
                    })

                    return
                }

                if (Array.isArray(payload)) {
                    var end = false

                    payload.forEach((val, key, array) => {
                        if(!array[key + 1]) end = true
                        this.submitDetails(url, val, end)
                    })
                } else {
                    this.submitDetails(url, payload, true)
                }
            }).catch((e) => {
                console.log(e)
            });
        },
        submitDetails (url, payload, end) {
            axios.post(url, payload)
            .then(response => {
                return response
                if (end) {
                    this.$swal({
                        type: 'success',
                        title: response.data.success,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: () => {
                            this.$store.commit('SET_COMPLETE', true)
                            this.$store.commit('SET_LOADING', false)
                        }
                    })
                }
                
            }).catch(err => {
                console.log(err)
                this.$swal({
                    type: 'error',
                    title: 'Ooppss!',
                    html: `Something went wrong. <br> ${ err.response.data.hasOwnProperty('message') ? '<span class="text-danger">Tip</span>: ' + err.response.data.message : ''}`,
                    onClose: () => {
                        this.$store.commit('SET_LOADING', false)
                        this.$store.commit('SET_COMPLETE', true)
                    }
                })
            })
        }
    }
    
}
</script>