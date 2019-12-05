import Vue from 'vue';
import Vuex from 'vuex';

import Profile from './Store/ProfileStore';
import Process from './Store/ProcessStore';
import Applicant from './Store/ApplicantStore';
import Messages from './Store/MessagesStore';

Vue.use(Vuex);
Vue.config.debug = true;

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        Profile,
        Process,
        Applicant,
        Messages
    },
    strict: false
});
