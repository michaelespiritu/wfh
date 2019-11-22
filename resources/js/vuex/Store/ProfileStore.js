const getDefaultState = () => {
    return {
      Identifier: null,
      Name: null,
      Title: null,
      Applicant: {
        Skills: [],
        CoverLetter: null,
      },
      Company: {
            Name: null,
            URL: null,
            Description: null,
            Logo: null,
            HQ: null,
        }
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
        SET_IDENTIFIER(state, data) {
            state.Identifier = data;
        },
        SET_NAME(state, data) {
            state.Name = data;
        },
        SET_TITLE(state, data) {
            state.Title = data
        },
        SET_SKILLS(state, data) {
            state.Applicant.Skills = data
        },
        PUSH_SKILL(state, data) {
            state.Applicant.Skills.push(data)
        },
        REMOVE_SKILL(state) {
            state.Applicant.Skills.splice(index,1)
        },
        SET_COVERLETTER(state, data) {
            state.Applicant.CoverLetter = data
        },
        SET_COMPANY_NAME(state, data) {
            state.Company.Name = data
        },
        SET_COMPANY_HQ(state, data) {
            state.Company.HQ = data
        },
        SET_COMPANY_URL(state, data) {
            state.Company.URL = data
        },
        SET_COMPANY_DESCRIPTION(state, data) {
            state.Company.Description = data
        },
  }
  
  
  export default {
      state,
      mutations,
      actions
  }
  