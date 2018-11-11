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
        //Для юзеров
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
        addProposedUserEvents:(state, payload)=>{
            if(payload){
                let updated = false;
                let id = payload.event_id;
                state.proposedUserEvents.forEach(function(item, i) {
                    if(item.event_id === id) {
                        state.proposedUserEvents[i] = payload;
                        console.log('update');
                        updated = true;
                    }
                });
                if(updated === false){
                    state.proposedUserEvents.push(payload);
                    console.log('add');
                }
            }else{
                console.log('no payload for mutation');
            }
        },
        deleteProposedUserEvents:(state, payload)=> {
            if(payload){
                console.log('payload for deleting is', payload);
                let id = payload.event_id;
                state.proposedUserEvents = state.proposedUserEvents.filter(event => event.event_id !== id);
            }else{
                console.log('no payload for delete mutation');
            }
        },
        //Для админа
        //todo:исправить и проверить все мутации
        addPublishedAdminEvents:(state, payload)=>{
            if(payload){
                let updated = false;
                let id = payload.event_id;
                state.publishedAdminEvents.forEach(function(item, i) {
                    if(item.event_id === id) {
                        state.publishedAdminEvents[i] = payload;
                        console.log('update');
                        updated = true;
                    }
                });
                if(updated === false){
                    state.publishedAdminEvents.push(payload);
                    console.log('add');
                }
            }else{
                console.log('no payload for mutation');
            }
        },
        deleteProposedAdminEvents:(state, payload)=> {
            if(payload){
                console.log('payload for deleting is', payload);
                let id = payload.event_id;
                state.proposedAdminEvents = state.proposedAdminEvents.filter(event => event.event_id !== id);
            }else{
                console.log('no payload for delete mutation');
            }
        },
        deletePublishedAdminEvents:(state, payload)=> {
            if(payload){
                console.log('payload for deleting is', payload);
                let id = payload.event_id;
                state.publishedAdminEvents = state.publishedAdminEvents.filter(event => event.event_id !== id);
            }else{
                console.log('no payload for delete mutation');
            }
        },
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
