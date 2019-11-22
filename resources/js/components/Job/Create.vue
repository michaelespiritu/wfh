<template>
    <div>
        <div class="form-group row">
            <label for="category" class="col-sm-12 col-form-label">Category</label>
            <div class="col-sm-12">
                <select class="form-control" v-validate="'required'" id="category" name="category" v-model="category">
                    <option value="">Select your category</option>
                    <option v-for="(cat, index) in categories" :key="index" :value="cat.id">{{cat.name}}</option>
                </select>
                <p v-if="errors.first('category')"><span class="help-block text-danger" >{{errors.first('category')}}</span></p>
            </div>
        </div>

        <div class="form-group row my-4">
            <label for="title" class="col-sm-12 col-form-label">Title</label>
            <div class="col-sm-12">
            <input type="text" v-model="title" v-validate="'required|min:5'" class="form-control" id="title" name="title" placeholder="Title">
            <p v-if="errors.first('title')"><span class="help-block text-danger" >{{errors.first('title')}}</span></p>
            </div>

        </div>

        <div class="form-group row my-4">
            <label for="skills" class="col-sm-12 col-form-label">Skills</label>
            <div class="col-sm-12">
            <button type="button" class="btn btn-outline-primary" @click="addField(skills, null, null)" v-if="skills.length === 0">Add Skill</button>
            <div class="input-group mb-2" v-for="(skill, index) in skills" :key="index">
                <div class="input-group-prepend">
                <div class="input-group-text" @click="addField(skills, `skills-${index}`, `skills-${index + 1}`)"><i class="fa fa-plus"></i></div>
                </div>
                <input 
                    v-model="skills[index]" 
                    type="text" 
                    v-validate="'required'" 
                    class="form-control" 
                    :id="`skills-${index}`" 
                    name="skills" 
                    placeholder="Skills"
                    @keyup.enter="addField(skills, `skills-${index}`, `skills-${index + 1}`)"
                    >
                <div class="input-group-prepend">
                <div class="input-group-text" @click="deleteField(skills, index)"><i class="fa fa-minus"></i></div>
                </div>
            </div>
            <p v-if="errors.first('skills')"><span class="help-block text-danger" >{{errors.first('skills')}}</span></p>
            </div>
        </div>

        <div class="form-group row my-4">
            <div class="col-sm-12 col-md-6">
                <label for="regionRestriction" class="col-form-label">Region Restriction</label>
                <input type="text" v-model="regionRestriction"  class="form-control" id="regionRestriction" name="regionRestriction" placeholder="Region Restriction">
                <small id="regionRestrictionHelp" class="form-text text-muted">
                Example: EU only, PH only, PST only.
                </small>
            </div>
            <div class="col-sm-12 col-md-6">
                <label for="employmentType" class="col-form-label">Employment Type</label>
                <select class="form-control" v-validate="'required'" name="employmentType" v-model="employmentType">
                    <option value="">Select Employment Type</option>
                    <option v-for="(emp, index) in employmentTypes" :key="index" :value="emp.text">{{emp.text}}</option>
                </select>
                <p v-if="errors.first('employmentType')"><span class="help-block text-danger" >{{errors.first('employmentType')}}</span></p>
            </div>

        </div>

        <div class="form-group row my-4">
            <div class="col-sm-12 col-md-6">
                <label for="budgetType" class="col-form-label">Budget Type</label>

                <select class="form-control" v-validate="'required'" id="budget" name="budgetType" v-model="budgetType">
                    <option value="">Select your Budget Type</option>
                    <option v-for="(bud, index) in budgets" :key="index" :value="bud.text">{{bud.text}}</option>
                </select>
                <p v-if="errors.first('budgetType')"><span class="help-block text-danger" >{{errors.first('budgetType')}}</span></p>


            </div>

            <div class="col-sm-12 col-md-6" v-if="budgetType == 'Per Hour' || budgetType == 'Per Day' || budgetType == 'Fixed'">
                <label for="budgetAmount" class="col-form-label">Budget Amount</label>
                <input type="number" v-model="budgetAmount" v-validate="'required|integer'" class="form-control" id="budgetAmount" name="budgetAmount" placeholder="Budget Amount">
                <p v-if="errors.first('budgetAmount')"><span class="help-block text-danger" >{{errors.first('budgetAmount')}}</span></p>
            </div>

        </div>

        <div class="form-group row my-4">
            <div class="col-sm-12 ">
                <label class="col-form-label">Job Description</label>
                <wyswyg v-model="description" name="description" v-validate="'required'"></wyswyg>
                <p v-if="errors.first('description')"><span class="help-block text-danger" >{{errors.first('description')}}</span></p>
            </div>
        </div>

        <div class="form-group row my-4">
            <div class="col-sm-12">
                <label for="skills" class="pb-0 col-form-label">Email to notified</label>
                <p>
                    <small id="regionRestrictionHelp" class="form-text text-muted">
                    Email Addres to be notified when someone applies. You do not need to put the Email Address associate to this account.
                    </small>
                </p>
            </div>
            <div class="col-sm-12">
            <button type="button" class="btn btn-outline-primary" @click="addField(emails, null, null)" v-if="emails.length === 0">Add Email</button>
            <div class="input-group mb-2" v-for="(email, index) in emails" :key="index">
                <div class="input-group-prepend">
                <div class="input-group-text" @click="addField(emails, `emails-${index}`, `emails-${index + 1}`)"><i class="fa fa-plus"></i></div>
                </div>
                <input 
                    v-model="emails[index]" 
                    type="text" v-validate="'required'" 
                    class="form-control" 
                    :id="`emails-${index}`" 
                    name="emails" 
                    placeholder="Email"
                    @keyup.enter="addField(emails, `emails-${index}`, `emails-${index + 1}`)">
                <div class="input-group-prepend">
                <div class="input-group-text" @click="deleteField(emails, index)"><i class="fa fa-minus"></i></div>
                </div>
            </div>
            <p v-if="errors.first('emails')"><span class="help-block text-danger" >{{errors.first('emails')}}</span></p>
            </div>
        </div>
    
        <div>
            <button v-if="!loading" type="submit" class="btn btn-lg btn-primary btn-block" @click="validateBeforeSubmit">Submit</button>

            <div class="progress" v-if="loading">
                <div class="indeterminate"></div>
            </div>
        </div>

    </div>
</template>


<script>
import Wysywg from '../Misc/Wyswyg'
import SwalAlerts from '../Misc/SwalAlerts'

const customMessages = {
    custom: {
        'category_id': {
            required: 'Please select Job Category'
        },
        'title': {
            required: 'Title is required',
            min: 'Title must be atleast 5 characters'
        },
        'employmentType': {
            required: 'Please select Employment Type'
        },
        'budgetAmount': {
            required: 'Please put Budget Amount',
            integer: 'There are some Invalid Character. Numbers only.'
        },
        'budgetType': {
            required: 'Please select Budget Type'
        },
        'description': {
            required: 'Job Description/Overview is required'
        }
    }
}

export default {
    props: ['credit'],
    mixins: [SwalAlerts],
    components: {
        'wyswyg': Wysywg
    },
    data() {
        return {
            loading: false,
            title: '',
            category: '',
            categories: [],
            skills: [],
            emails: [],
            regionRestriction: '',
            employmentType: '',
            employmentTypes: [
                { text: 'Full Time' },
                { text: 'Part Time' },
                { text: 'On-Call' },
            ],
            budgetAmount: 0,
             value: [0, 100],
            budgetType: '',
            budgets: [
                { text: 'Per Hour' },
                { text: 'Per Day' },
                { text: 'Fixed' },
                { text: 'TBD' },
                { text: 'DOE' },
                { text: 'Negotiable' },
            ],
            description: ''
        }
    },
    created() {
        this.$validator.localize('en', customMessages);
        axios.get('/api/category')
        .then(response => {
            this.categories = response.data
        }).catch(err => {
            console.log(err)
        })
    },
    methods: {
        addField (value, prev, next){
            value.push('')
            setTimeout(function () {
                prev && document.getElementById(`${prev}`).blur()
                prev && document.getElementById(`${next}`).focus()
            }, 100)
        },
        deleteField (value, index) {
            value.splice(index,1)
        },
        validateBeforeSubmit () {
            this.$validator.validateAll().then((result) => {

                if(!result){
                    this.$swal({
                        type: 'warning',
                        title: 'Oooppps!',
                        html: 'Some required fields are missing',
                        onClose: () => {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            })
                        }
                    })
                    return;
                }

                this.submitDetails()

            }).catch((e) => {
                console.log(e)
            });
        },
        submitDetails () {
            axios.post(`/jobs`, {
                category_id: this.category,
                title: this.title,
                region_restriction: this.regionRestriction,
                notify_email: this.emails,
                type: this.employmentType,
                skills: this.skills,
                budget: {
                    amount: this.budgetAmount,
                    type: this.budgetType
                },
                description: this.description
            }).then(response => {
                this.successAlert(response.data.success, 'Congratulations!', {onClose: () => {
                        location.href = `/jobs/${response.data.job.identifier}`
                    }})
            }).catch(err => {
                this.errorAlert(
                        `Something went wrong. Please Try again. <br> ${ err.response.data.hasOwnProperty('error') ? '<span class="text-danger">Tip</span>: ' + err.response.data.error : ''}`,
                        `Oopps!`
                    )
            })
        }
    }
}
</script>