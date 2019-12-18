<template>
    <div>
        <select 
            @change="updateStatus"
            v-model="$store.state.Applicant.Temp.status.id" 
            class="custom-select custom-select-sm">
            <option 
                v-for="(board, index) in boards"
                :key="index"
                :value="board.id">{{ board.name}}</option>
        </select>
        
    </div>
</template>

<script>
export default {
    props: ['id', 'boards'],
    methods: {
        updateStatus () {
            axios.post(`/application/${this.$store.state.Applicant.Temp.identifier}/update-status`, {
                status: this.$store.state.Applicant.Temp.status.id,
                type: this.$store.state.Applicant.Type
            }).then(response => {
                console.log(response.data.applicants)
                this.$store.commit('RESET_APPLICANT_DATA')
                this.$store.commit('SET_APPLICANT_DATA', response.data.applicants)

                $(`#${this.id}`).modal('hide')
                this.$swal({
                    type: 'success',
                    title: response.data.success,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    onClose: () => {
                    }
                })
            }).catch(err => {
                console.log(err)
                this.$swal({
                    type: 'error',
                    title: 'Ooppss!',
                    html: `Something went wrong. <br> ${ err.response.data.hasOwnProperty('message') ? '<span class="text-danger">Tip</span>: ' + err.response.data.message : ''}`,
                    onClose: () => {
                         $(`#${this.id}`).modal('hide')
                        // this.$store.commit('SET_LOADING', false)
                    }
                })
            })
        }
    }
}
</script>

