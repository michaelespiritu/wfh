const getDefaultState = () => {
    return {
      Data: [],
      Waiting: [],
      Reject: [],
      Shortlist: [],
      Type: 'all',
      Status: null,
      Temp: null
    }
  }
  
  const state = getDefaultState()
  
  const actions = {
      get_project({ commit }, data) {
        commit('GET_PROJECT', data)
      },
      reset_project({ commit }) {
        commit('RESET_PROJECT')
      }
  }
  
  const mutations = {
      SET_APPLICANT_TYPE(state, data) {
          state.Type = data;
      },
      SET_APPLICANT_DATA(state, data) {
          state.Data = data;
      },
      RESET_APPLICANT_DATA(state) {
          state.Data = [];
      },
      SET_APPLICANT_TEMP(state, data) {
          state.Temp = data;
      },
      SET_STATUS(state, data) {
          state.Status = data;
      },
      UPDATE_SPECIFIC_STATUS(state, elementData) {
        console.log(elementData.identifier)
        state.Data.filter(function (val, index) {
            val.identifier == elementData.identifier ? state.Data[index] = elementData : null
        });
      },
        SET_APPLCIANT_WAITING(state, data) {
            state.Waiting = data;
        },
        SET_APPLCIANT_REJECT(state, data) {
            state.Reject = data;
        },
        SET_APPLCIANT_SHORTLIST(state, data) {
            state.Shortlist = data;
        },
  }
  
  
  export default {
      state,
      mutations,
      actions
  }
  