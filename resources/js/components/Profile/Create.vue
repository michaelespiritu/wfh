<template>
    <div>
        <div class="card mb-4 py-3 border-left-danger" v-if="!$store.state.Profile">
            <div class="card-body">
                <h4 class="mb-0 h5 text-center text-danger">Please Create your Profile first.</h4>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h1 class="h3 mb-4 text-gray-800">{{ $store.state.Profile.Name ? $store.state.Profile.Name : user.email }}</h1>

                <div class="form-group row my-4">
                    <label for="name" class="col-sm-12 col-form-label">Name</label>
                    <div class="col-sm-12">
                    <input type="text" v-model="$store.state.Profile.Name" v-validate="'required|min:2'" class="form-control" id="name" name="name" placeholder="Type your Name here">
                    <p v-if="errors.first('name')"><span class="help-block text-danger" >{{errors.first('name')}}</span></p>
                    </div>
                </div>
                <div class="form-group row my-4">
                    <label for="title" class="col-sm-12 col-form-label">Title</label>
                    <div class="col-sm-12">
                    <input type="text" v-model="$store.state.Profile.Title" v-validate="'required|min:2'" class="form-control" id="title" name="title" placeholder="Type your Job/Role Title here">
                    <p v-if="errors.first('title')"><span class="help-block text-danger" >{{errors.first('title')}}</span></p>
                    </div>
                </div>
                <div>
                    <button v-if="!loading" type="submit" class="btn btn-lg btn-primary btn-block" @click="create">Submit</button>

                    <div class="progress" v-if="loading">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const customMessages = {
    custom: {
        'name': {
            required: 'Name is required',
            min: 'Name must be atleast 5 characters'
        },
        'title': {
            required: 'Title is required',
            min: 'Title must be atleast 5 characters'
        }
    }
}

import Validate from '../Misc/Validate'

export default {
    props: ['user'],
    mixins: [Validate],
    data() {
        return {
            loading: false,
            hasProfile: false
        }
    },
    created() {
        this.$validator.localize('en', customMessages);
    },
    methods: {
        create () {
            this.validateBeforeSubmit(
                `/dashboard/profile`,
                {
                    name: this.$store.state.Profile.Name,
                    title: this.$store.state.Profile.Title,
                }

            )
        }
    }
}
</script>