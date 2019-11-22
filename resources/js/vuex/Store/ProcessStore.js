const getDefaultState = () => {
    return {
      Loading: false,
      Complete: false,
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
      SET_COMPLETE(state, data) {
          state.Complete = data;
      },
      SET_LOADING(state, data) {
          state.Loading = data;
      },
  }
  
  
  export default {
      state,
      mutations,
      actions
  }
  