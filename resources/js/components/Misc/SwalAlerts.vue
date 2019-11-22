<script>
export default {
    methods: {
        swalParam (type,  message, title, options) {
            var defaultParam = {
                    type: type,
                    title: title,
                    html: message,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 1500,
            }

            return Object.assign(defaultParam, options)
        },
        successAlert (message, title = null, options = null) {
            var param = this.swalParam('success', message, title, options)

            this.$swal(param)
        },
        errorAlert (message, title = null, options = null) {
            var param = this.swalParam('error', message, title, options)

            this.$swal(param)
        },
        
    }
}
</script>