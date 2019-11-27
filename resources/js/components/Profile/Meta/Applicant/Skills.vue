<template>
    <div>
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-sm-flex justify-content-between align-content-between">
                    <h1 class="h3 mb-0 text-gray-800">Skills Bank</h1>
                    
                    <button @click="validateBeforeSubmit" class="w-full d-sm-inline-block btn btn-sm btn-primary shadow-sm">Save Changes</button>
                </div>
            </div>
            <div class="card-body">
               <div class="form-group row">
                    <label for="skills" class="col-sm-12 col-form-label">Skills</label>
                    <div class="col-sm-12">
                    <button type="button" class="btn btn-outline-primary" @click="addSkill(null, null)" >Add Skill</button>
                    <div v-if="$store.state.Profile.Applicant.Skills.length != 0">
                        <div 
                            class="row"
                            v-for="(skill, index) in $store.state.Profile.Applicant.Skills" :key="index"
                            >
                            <div class="col-sm-10">
                                <label class="col-form-label">Skills Name</label>
                                <div class="input-group mb-2" >
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" @click="addSkill(`skills-${index}`, `skills-${index + 1}`)"><i class="fa fa-plus"></i></div>
                                    </div>

                                    <input 
                                        type="text" 
                                        v-validate="'required'" 
                                        data-vv-as="Skill Name" 
                                        class="form-control" 
                                        :id="`skills-${index}`" 
                                        :name="`skill_name_${index}`" 
                                        v-model="skill.name"
                                        placeholder="Skills"
                                        @keyup.enter="addSkill(`skills-${index}`, `skills-${index + 1}`)">

                                    <div class="input-group-prepend">
                                        <div class="input-group-text" @click="deleteSkill(index)"><i class="fa fa-minus"></i></div>
                                    </div>
                                </div>

                                <p v-if="errors.first(`skill_name_${index}`)"><span class="help-block text-danger" >{{errors.first(`skill_name_${index}`)}}</span></p>

                            </div>
                            <div class="col-sm-2">
                                <label class="col-form-label">Skills Proficiency</label>

                                <select 
                                    v-validate="'required'" 
                                    data-vv-as="Skill Level"
                                    :name="`skill_level_${index}`" 
                                    v-model="skill.level"
                                    class="custom-select custom-select" >
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">5</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>

                                <p v-if="errors.first(`skill_level_${index}`)"><span class="help-block text-danger" >{{errors.first(`skill_level_${index}`)}}</span></p>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SwalAlerts from '../../../Misc/SwalAlerts'

export default {
    mixins: [SwalAlerts],
    methods: {
        addSkill (prev, next){
            this.$store.commit('PUSH_SKILL', {
                    name: '',
                    level: 1
            })
            setTimeout(function () {
                prev && document.getElementById(`${prev}`).blur()
                prev && document.getElementById(`${next}`).focus()
            }, 100)
        },
        deleteSkill (index) {
            this.$store.commit('REMOVE_SKILL')
        },
        validateBeforeSubmit () {
            this.loading = true

            this.$validator.validateAll().then((result) => {
                if(!result){
                    this.errorAlert(
                        'Some required fields are missing', 
                        'Oopps',
                        {
                            onClose: () => {
                                this.loading = false
                            }
                        }
                    )
                    
                    return
                }

                this.create()
            }).catch((e) => {
                console.log(e)
            });
        },
        create () {
            axios.post(`/dashboard/skills`, {
                skills: this.$store.state.Profile.Applicant.Skills
            })
            .then(response => {

                this.successAlert(
                    response.data.success, 
                    null,
                    {
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        onClose: () => {
                            this.loading = false
                        }
                    }
                )
                
            }).catch(err => {
                this.errorAlert(
                    `Something went wrong. <br> ${ err.response.data.hasOwnProperty('message') ? '<span class="text-danger">Tip</span>: ' + err.response.data.message : ''}`, 
                )
            })
        }
    }
}
</script>