import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        publishedDailyEvents: [],
        proposedUserEvents: [],
    },
    getters:{
        getPublishedDailyEvents: state => {
            return state.publishedDailyEvents;
        },
        getProposedUserEvents: state =>{
            return state.proposedUserEvents;
        }
    },
    mutations:{
        loadPublishedDailyEvents: (state, payload)=>{
            if(payload){
                state.publishedDailyEvents = payload;
            }else{
                console.log('no payload for mutation');
            }
        },
        loadProposedUserEvents: (state, payload)=>{
            if(payload){
                state.proposedUserEvents = payload;
            }else{
                console.log('no payload for mutation');
            }
        },
        // addProposedUserEvents: (state, payload) => {
        //     state.proposedUserEvents.push(payload);
        // },
    },
});
