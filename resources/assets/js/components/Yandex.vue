<template>
    <div class="map__wrap">
        <yandex-map
                :coords="[47.50, 35.10]"
                zoom="10"
                style="width: 90%; height: 600px;"
                :cluster-options="{
        1: {clusterDisableClickZoom: true}
        }"
                :behaviors="['drag', 'scrollZoom']"
                map-type="hybrid"
        >

            <ymap-marker v-for="marker in this.placemarkers" :key="marker.id"
                    :marker-id="marker.id"
                    marker-type="placemark"
                    :coords="marker.coords"
                    :hint-content="marker.title"
                    :balloon="{header: marker.title, body: marker.description, footer: marker.date}"
                    :icon="{color: 'green', glyph: 'cinema'}"
                    :cluster-name="marker.title"
            ></ymap-marker>
            <!--<ul>-->
                <!--<li v-for="event in publishedDailyEvents"> {{event.event_location}}</li>-->
            <!--</ul>-->
        </yandex-map>
        <div class="events__wrap">
            <div class="events">
                <div class="events__title">
                    Все события в городе Запорожье на {{searchDay}}
                </div>
                <div class="event-block" v-for="event in this.publishedDailyEvents" :key="event.event_id">
                    <div class="event-image__wrap">
                        <div class="event-image">
                            <img class="event-image__img" :src = "'/images/'+event.event_image" alt="">
                        </div>
                    </div>
                    <div class="event-about__wrap">
                        <div class="event-about">
                            <div class="event-about__title">{{event.event_title}}</div>
                            <div class="event-about__description">{{event.event_description}}</div>
                            <div class="event-about__location">Месторасположение: {{event.event_location}}</div>
                            <div class="event-about__date">Дата: {{event.event_date}}</div>
                            <div class="event-about__time">Время: {{event.event_time}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Yandex",
        data(){
            return{
                searchDay: '',
            }
        },
         created:
            function () {
            this.axios.get("events/published")
                .then(resp =>{
                    let events = resp.data;
                    this.searchDay = events[0].event_date;
                    this.$store.commit('loadPublishedDailyEvents', events);

            }).catch(err => {
                console.log(err);
            });
        },
        computed: {
            //Работает только когда исопльзуется компонентом
            publishedDailyEvents: function() {
                console.log('computed', this.$store.getters.getPublishedDailyEvents);
                return this.$store.getters.getPublishedDailyEvents;
            },
            placemarkers: function(){
                let eventArray = [];
                let events = this.$store.getters.getPublishedDailyEvents;
                events.forEach(function(event){

                   let eventObj = {
                       coords: [event.event_lat, event.event_long],
                       id: event.event_id,
                       title: `<div>${event.event_title}</div>`,
                       description: `<div>${event.event_description}</div>`,
                       date : `<div>${event.event_date}</div>`,
                   };
                   eventArray.push(eventObj);
                });
                console.log('computed array', eventArray);
              return eventArray;
            }
        },
    }
</script>

<style scoped>
.map__wrap{
    width:90%;
    margin:20px 50px 50px 50px;
}
    .events__wrap{
        padding: 0;
        margin:50px 100px 0 100px;
    }
    .events{
        display:flex;
        flex-direction: row;
    }
</style>