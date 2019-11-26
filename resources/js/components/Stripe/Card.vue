<template>
  <div>
    
    <div v-if="!$store.state.Profile.HasCard">
      <p class="h3">Please give us your payment details:</p>

      <card class='stripe-card'
        :class='{ complete }'
        stripe='pk_test_BQ7UO1EwyyVJCSUFCjdsSMzT00xLN0wFrE'
        :options='stripeOptions'
        @change='complete = $event.complete'
      />
    
    
      <div>

            <button 
              class='my-4 btn btn-primary btn-block' 
              @click='pay' 
              v-if="!loading"
              :disabled='!complete'>
                Pay with credit card
            </button>

            <div class="progress my-4" v-if="loading">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>

      </div>

      <div v-else>

          <div>

              <button 
                class='my-4 btn btn-primary btn-block' 
                @click="$emit('proceed', null, rememberCard, editCard)"
                v-if="!loading">
                  Pay with credit card
              </button>

              <p class="text-center">
                <small>If you wish to edit your Credit Card information. 
                  <br>
                  <span 
                    @click="$store.commit('SET_HAS_CARD', false)"
                    class="cursor-pointer">Click here.</span>
                </small>
              </p>

              <div class="progress my-4" v-if="loading">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>

      </div>
  </div>
</template>
 
<script>
import { Card, createToken, createPaymentMethod } from 'vue-stripe-elements-plus'
 
export default {
  data () {
    return {
      rememberCard: false,
      editCard: false,
      complete: false,
      loading: false,
      stripeOptions: {
          style:{
              base: {
                  color: '#32325d',
                  lineHeight: '18px',
                  fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                  fontSmoothing: 'antialiased',
                  fontSize: '16px',
                  '::placeholder': {
                  color: '#aab7c4'
                  }
              },
              invalid: {
                  color: '#fa755a',
                  iconColor: '#fa755a'
              }
          },
          hidePostalCode: true
      }
    }
  },
 
  components: { Card },
 
  computed: {
    hasCard () {
      return this.$store.state.Profile.HasCard
    }
  },

  watch: {
    hasCard (value) {
      if (value) {
        this.editCard = false
      }
      if (!value) {
        this.editCard = true
      }
    }
  },

  methods: {
    pay () {
      // this.loading = true
      // createToken returns a Promise which resolves in a result object with
      // either a token or an error key.
      // See https://stripe.com/docs/api#tokens for the token object.
      // See https://stripe.com/docs/api#errors for the error object.
      // More general https://stripe.com/docs/stripe.js#stripe-create-token.
      createToken().then(
        data => 
          this.$emit('proceed', data, this.rememberCard, this.editCard)
      )
    }
  }
}
</script> 
 
<style>

.StripeElement {
  background-color: white;
  height: 40px;
  padding: 10px 12px;
  border-radius: 4px;
  border: 1px solid transparent;
  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>

