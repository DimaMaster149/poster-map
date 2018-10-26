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

        <ymap-marker v-for="marker in this.placemarkers"
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
    </div>
</template>

<script>
    export default {
        name: "Yandex",
         created:
            function () {
            this.axios.get("events/published")
                .then(resp =>{
                    let events = resp.data;
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
    margin:20px 50px 0 50px;
}
</style>