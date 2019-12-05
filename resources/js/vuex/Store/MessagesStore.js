const getDefaultState = () => {
    return {
      Messages: null,
      TempMessage: null,
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
      SET_MESSAGES(state, data) {
          state.Messages = data;
      },
      SET_TEMP_MESSAGE(state, data) {
          state.TempMessage = data;
      },
  }
  
  
  export default {
      state,
      mutations,
      actions
  }
  