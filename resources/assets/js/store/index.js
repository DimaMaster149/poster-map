import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        publishedDailyEvents: [],
    },
    getters:{
        getPublishedDailyEvents: state => {
            return state.publishedDailyEvents;
        }
    },
    mutations:{
        loadPublishedDailyEvents: (state, payload)=>{
            if(payload){
                state.publishedDailyEvents = payload;
            }else{
                console.log('no payload for mutation');
            }
        }
    },
});
