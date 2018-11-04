import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        publishedDailyEvents: [],
        proposedUserEvents: [],
        proposedAdminEvents:[],
        publishedAdminEvents:[],
    },
    getters:{
        getPublishedDailyEvents: state => {
            return state.publishedDailyEvents;
        },
        getProposedUserEvents: state =>{
            return state.proposedUserEvents;
        },
        getProposedAdminEvents: state =>{
            return state.proposedAdminEvents;
        },
        getPublishedAdminEvents: state =>{
            return state.publishedAdminEvents;
        },
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
        //todo: refresh events after adding them in Propose and Admin components
        loadProposedAdminEvents: (state, payload)=>{
            if(payload){
                state.proposedAdminEvents = payload;
            }else{
                console.log('no payload for mutation');
            }
        },
        loadPublishedAdminEvents: (state, payload)=>{
            if(payload){
                state.publishedAdminEvents = payload;
            }else{
                console.log('no payload for mutation');
            }
        },
    },
});
