<template>
        <a class="btn btn-danger btn-sm btn-block" role="button" @click="removeJob">
            <i class="fas fa-trash text-white"></i>
        </a>
</template>

<script>
import SwalAlerts from '../Misc/SwalAlerts'

export default {
    props: ['job'],
    mixins: [SwalAlerts],
    methods: {
        removeJob () {
            this.$swal({
                type: 'question',
                title: `Are you sure you want to remove ${this.job.title}`,
                html: `This action can't be undo. All other informatinon associated to this Job post will be deleted too such as Applicants.`,
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete it!'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`${this.job.path}`)
                    .then(response => {
                        this.successAlert(
                            response.data.success, 
                            'Congratulations!', 
                            {
                                onClose: () => {
                                    location.href = '/jobs'
                                }
                            }
                        )
                    })
                }
            })
        }
    }
}
</script>