require('./bootstrap');

window.Vue = require('vue');
import VeeValidate from 'vee-validate'
import VueSweetalert2 from 'vue-sweetalert2'
import Store from './vuex/profile'

Vue.use(VeeValidate)
Vue.use(VueSweetalert2)

Vue.component('user-name', require('./components/UserName.vue').default);

Vue.component('create-job', require('./components/Job/Create.vue').default);
Vue.component('edit-job', require('./components/Job/edit.vue').default);
Vue.component('remove-job', require('./components/Job/Remove.vue').default);

Vue.component('create-profile', require('./components/Profile/Create.vue').default);
Vue.component('applicant-meta', require('./components/Profile/Meta/Applicant/Container.vue').default);
Vue.component('employer-meta', require('./components/Profile/Meta/Employer/Container.vue').default);
Vue.component('buy-credit', require('./components/Credit/Buy.vue').default);

Vue.component('apply-job', require('./components/Job/Applicant/Apply.vue').default);
Vue.component('applicants', require('./components/Job/Applicants.vue').default);
Vue.component('manage-applicants', require('./components/Job/ManageApplicants/Container.vue').default);
Vue.component('applicant-status', require('./components/Job/ApplicantStatus.vue').default);

Vue.component('send-message', require('./components/Message/Create.vue').default);

const app = new Vue({
    el: '#app',
    store: Store,
});

