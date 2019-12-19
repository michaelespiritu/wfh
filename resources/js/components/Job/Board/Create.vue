<template>
    <span>
        <p class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-0" data-toggle="modal" data-target="#exampleModal">Create Job Board</p>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Board</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-12 col-form-label">Name</label>
                        <div class="col-sm-12">
                        <input 
                            type="text" 
                            v-model="name" 
                            v-validate="'required|min:2'" 
                            data-vv-as="Name"  
                            class="form-control" 
                            id="name" 
                            name="name" 
                            placeholder="Board Name">
                        <p v-if="errors.first('Name')"><span class="help-block text-danger" >{{errors.first('name')}}</span></p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-secondary" 
                        data-dismiss="modal"
                        @click="name = ''"
                        >
                            Cancel
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        @click="createBoard"
                        >
                        Create Board
                    </button>
                </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
import SwalAlerts from '../../Misc/SwalAlerts'
export default {
    props: ['job'],
    mixins: [SwalAlerts],
    data() {
        return {
            name
        }
    },
    methods: {
        createBoard () {
            axios.post(`${this.job.path}/create/job-board`, {
                name: this.name
            }).then(response => {
                this.successAlert(
                    response.data.success, 
                    'Congratulations',
                    {
                        onClose: () => {
                            location.href = this.job.path
                        }
                    }
                )
            }).catch(error => {
                console.log(error.response.data.message)
                this.errorAlert(
                    error.response.data.message, 
                )
            })
        }
    }
}
</script>