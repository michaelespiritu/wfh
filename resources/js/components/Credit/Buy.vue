<template>
    <div >

            <ul class="list-inline tools-navigation mb-4 text-center">
                <li class="list-inline-item px-2 py-1 cursor-pointer" @click="step = 1" :class="{'active': step == 1}">Start</li>
                <li class="list-inline-item px-2 py-1 cursor-pointer" @click="step = 2" :class="{'active': step == 2}">Details</li>
                <li class="list-inline-item px-2 py-1 cursor-pointer" @click="step = 3" :class="{'active': step == 3}">Summary</li>
            </ul>

            <transition name="tools-stepper">
                <div class="container" v-if="step == 1">
                    <p class="h3 text-center mb-4">What is Job Credit?</p>

                    <p class="h4 text-center mb-4">Job Credit acts as a token to create Job Post. Each Job Post corresponds to a 1 Job Credit.</p>

                    <p class="text-center h4 mb-4">You can buy Job Credits as many as you want. It will not expire.</p>

                    <div class="text-center">
                        <p class="btn btn-primary w-25 btn-sm rounded" @click="step = 2">Next</p>
                    </div>
                </div>
            </transition>

            <transition name="tools-stepper">
                <div class="container" v-if="step == 2">
                    <p class="h3">Credit</p>
                    <input 
                        type="number" 
                        v-model="credit" 
                        v-validate="'required|integer'" 
                        class="form-control" 
                        id="credit" 
                        name="credit" 
                        placeholder="How many Credits do you want to buy?">
                    <p v-if="errors.first('credit')"><span class="help-block text-danger" >{{errors.first('credit')}}</span></p>

                    <p class="btn btn-primary btn-block btn-sm rounded my-3" @click="step = 3">Next</p>
                </div>
            </transition>


            <transition name="tools-stepper">
                <div v-if="step == 3">
                    <card @proceed="buy"></card>
                </div>
            </transition>
        

  </div>
</template>

<script>
import Card from '../Stripe/Card'
import SwalAlerts from '../Misc/SwalAlerts'

export default {
    mixins: [SwalAlerts],
    components: {
        Card
    },
    data() {
        return {
            step: 3,
            credit: 1
        }
    },
    methods: {
        buy (value, rememberCard, editCard) {
            axios.post(`/credit/buy-credit`, {
                editCard: editCard,
                credit: this.credit,
                token: value.token
            }).then(response => {
                this.successAlert(
                    response.data.success, 
                    'Congratulations',
                    {
                        onClose: () => {
                            location.href = '/jobs/create'    
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

<style lang="scss">

/** CONTAINER TRANSITION **/
.tools-stepper-leave-active,
.tools-stepper-enter-active {
  transition: .5s;
}
.tools-stepper-enter {
  transform: translate(100%, 0);
}
.tools-stepper-leave-to {
  display: none;
}
  
  
  
/** NAVIGATION **/

@keyframes slide {
  from {width: 0;}
  to {width: 100%;}
}

.tools-navigation {

    width: 100%;
    text-align: center;
    border-bottom: 1px solid #eee;
    padding-bottom: .8em;

    li {
        display: inline;
    }

    .active {
        position: relative;
    }
    .active:before {
        content: '';
        display: block;
        border-bottom: 3px solid #e2cc1f;
        width: 100%;
        position: absolute;
        left: 0;
        bottom: 0;
        animation: slide .5s ease;
    }
    

}

</style>