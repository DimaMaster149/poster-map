<template>
    <div class="container">
        <div class="admin__wrap">
            <div class="admin">
                <div class="admin-form">
                    <form @submit="adminStore" enctype="multipart/form-data" >
                        <input type="hidden" name="event_id" v-model="event.event_id" @change="setEventId" >
                        <input type="hidden" name="event_long" :value="setEventLong">
                        <input type="hidden" name="event_lat" :value="setEventLat">
                        <div class="form-group">
                            <label for="event_title"> Введите название </label>
                            <input type="text" class="form-control" name="event_title" value=""
                                   v-model="event.event_title">
                        </div>
                        <div class="form-group">
                            <label for="event_description"> Введите описание </label>
                            <textarea type="text" class="form-control" name="event_description"
                                      v-model="event.event_description"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="event_location"> Введите месторасположение</label>
                            <input type="text" class="form-control" name="event_location" value="" placeholder="Запорожье, проспект Соборный, 142"
                                   v-model="event.event_location">
                        </div>
                        <div class="form-group">
                            <label for="event_date"> Выберите дату проведения </label>
                            <input class="form-control" name="event_date" placeholder="2018-10-25"
                                   v-model="event.event_date">
                        </div>
                        <div class="form-group">
                            <label for="event_time"> Введите время </label>
                            <input type="text" class="form-control" name="event_time" value="" placeholder="11:10"
                                   v-model="event.event_time">
                        </div>
                        <div class="form-group">
                            <label for="event_image"> Выберите картинку для афиши </label>
                            <input type="file" class="form-control" name="event_image" value="" v-on:change="onImageChange">
                        </div>
                        <div class="admin-form__image-description">
                            *Если при редактировании картинка не выбрана, значит она останется прежней.
                        </div>
                        <button class="btn btn-success">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="events__wrap">
            <button class="btn btn-info" @click="showProposedEvents">Предложенные</button>
            <button class="btn btn-success"  @click="showPublishedEvents">Опубликованные</button>
            <div v-if="this.showPublished" class="events">
                <div class="events__title">
                    Опубликованные события:
                </div>
                <div class="event-block" v-for="event in this.publishedAdminEvents" :key="event.event_id">
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
                        <div class="event-buttons__wrap">
                            <div class="event-buttons">
                                <div class="event-buttons__item">
                                    <button class="btn btn-success" @click="addEvent(event)">Добавить</button>
                                </div>
                                <div class="event-buttons__item">
                                    <button class="btn btn-warning" @click="editEvent(event)">Редактировать</button>
                                </div>
                                <div class="event-buttons__item">
                                    <button class="btn btn-danger" @click="deletePublishedEvent(event)">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="events">
                <div class="events__title">
                    Предложенные события:
                </div>
                <div class="event-block" v-for="event in this.proposedAdminEvents" :key="event.event_id">
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
                        <div class="event-buttons__wrap">
                            <div class="event-buttons">
                                <div class="event-buttons__item">
                                    <button class="btn btn-warning" v-on:click="editEvent(event)">Редактировать</button>
                                </div>
                                <div class="event-buttons__item">
                                    <button class="btn btn-danger" v-on:click="deleteProposedEvent(event)">Удалить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Admin",
        data(){
            return{
                event:{
                    event_id:'',
                    event_title:'',
                    event_description:'',
                    event_location:'',
                    event_date:'',
                    event_time:'',
                    event_image:{},
                    event_long:'',
                    event_lat:'',
                },
                showPublished:true,
                coords:{
                    long:'',
                    lat:'',
                }
            }
        },
        created:
            function () {
                this.axios.get("admin/events/proposed")
                    .then(resp =>{
                        let events = resp.data;
                        console.log(events);
                        this.$store.commit('loadProposedAdminEvents', events);
                    }).catch(err => {
                    console.log(err);
                });
                this.axios.get("admin/events/published")
                    .then(resp =>{
                        let events = resp.data;
                        console.log(events);
                        this.$store.commit('loadPublishedAdminEvents', events);
                    }).catch(err => {
                    console.log(err);
                });
            },
        computed:{
            //all proposed events
            proposedAdminEvents: function() {
                console.log('computed propose all', this.$store.getters.getProposedAdminEvents);
                return this.$store.getters.getProposedAdminEvents;
            },
            publishedAdminEvents: function() {
                console.log('computed published all', this.$store.getters.getPublishedAdminEvents);
                return this.$store.getters.getPublishedAdminEvents;
            },
        },
        methods: {
            onImageChange(e){
                console.log(e.target.files[0]);
                this.event.event_image = e.target.files[0];
            },
            adminStore(e) {
                e.preventDefault();
                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let re = /\s*,\s*/;
                let address = this.event.event_location.split(re);
                let city = address[0];
                let street = address[1];
                let house = address[2];
                // let geo_api = geocoderKey;
                let query = `https://geocode-maps.yandex.ru/1.x/?format=json&apikey=${geocoderKey}&geocode=${city},+${street},+${house}`;
                let instance = currentObj.axios.create();
                delete instance.defaults.headers.common['X-CSRF-TOKEN'];
                delete instance.defaults.headers.common['X-Requested-With'];
                instance({
                    method: 'get',
                    url: query,
                }).then(data =>{
                        console.log('geo data');
                        let json = JSON.parse(data.request.response);
                        let coords = json.response.GeoObjectCollection.featureMember[0].GeoObject.Point.pos.split(' ');
                        currentObj.event.event_long = coords[0];
                        currentObj.event.event_lat = coords[1];
                        console.log(this.event);
                        console.log(coords);

                    let formData = new FormData();
                    formData.append('event_id', this.event.event_id);
                    formData.append('event_title', this.event.event_title);
                    formData.append('event_description', this.event.event_description);
                    formData.append('event_location', this.event.event_location);
                    formData.append('event_date', this.event.event_date);
                    formData.append('event_time', this.event.event_time);
                    formData.append('event_image', this.event.event_image);
                    formData.append('event_long', this.event.event_long);
                    formData.append('event_lat', this.event.event_lat);

                    this.axios.post('/admin/events/published/store', formData, config)
                        .then(function (response) {
                            console.log(response);
                            currentObj.event.event_id = '';
                            currentObj.event.event_title = '';
                            currentObj.event.event_description = '';
                            currentObj.event.event_location = '';
                            currentObj.event.event_date = '';
                            currentObj.event.event_time = '';
                            currentObj.event.event_image = {};
                            currentObj.event.event_long = '';
                            currentObj.event.event_lat = '';
                            //не получается передать картинку
                            // currentObj.$store.commit('addProposedUserEvents', currentObj.event);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    }).catch(err=>{
                        console.log(err);
                    });
            },
            editEvent(event){
                let currentObj = this;
                this.event.event_id = event.event_id;
                this.event.event_title = event.event_title;
                this.event.event_description = event.event_description;
                this.event.event_location = event.event_location;
                this.event.event_date = event.event_date;
                this.event.event_time = event.event_time;
                this.event.event_image = {};
            },
            deleteProposedEvent (event){
                let currentObj = this;
                console.log('delete function for ', event);
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this event. ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.axios.delete("/admin/events/proposed/delete"+event.event_id)
                                .then(function(resp){
                                    console.log('delete response', resp);
                                    currentObj.$router.push('/');
                                }).catch((err)=>{
                                console.log(err)
                            });
                            swal("This event was deleted", {
                                icon: "success",
                            });
                        } else {
                            swal("This event is safe");
                        }
                    });
            },
            deletePublishedEvent (event){
                let currentObj = this;
                console.log('delete function for ', event);
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this event. ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.axios.delete("/admin/events/published/delete/"+event.event_id)
                                .then(function(resp){
                                    console.log('delete response', resp);
                                    currentObj.$router.push('/');
                                }).catch((err)=>{
                                console.log(err)
                            });
                            swal("This event was deleted", {
                                icon: "success",
                            });
                        } else {
                            swal("This event is safe");
                        }
                    });
            },
            showProposedEvents(){
                this.showPublished = false;
            },
            showPublishedEvents(){
                this.showPublished = true;
            },
            setEventId(){
                this.event.event_id = e.target.value;
            },
            setEventLong(){
              return this.event.event_long;
            }, setEventLat(){
                return this.event.event_lat;
            },
        },
    }
</script>

<style scoped>
    .admin__wrap{
        margin:20px 0 0 0;
    }
    .admin{
        display:flex;
        justify-content: center;
    }
    .admin-form{
        border:1px solid black;
        padding:50px;
    }
    .events__wrap{
        width:80%;
        height: auto;
        margin:50px 100px 20px 100px;
        padding-right: 100px;
    }
    .events{
        display:flex;
        flex-direction: column;
    }
    .events__title{
        width:100%;
        font-size:18px;
        text-align: center;
        font-weight: 600;
        font-family: Roboto, sans-serif;
        margin:0 0 10px 0;
    }
    .event-block {
        width: 100%;
        margin: 10px 0 15px 0;
        display: flex;
    }
    .event-image__wrap {
        max-width: 350px;
        height: auto;
        padding: 0 50px 0 0;
    }
    .event-image__img{
        width:100%;
        height: auto;
    }
    .event-about {
        font-size: 16px;
        font-family: Roboto, sans-serif;
        font-weight: 400;
    }
    .event-about__title {
        font-size: 18px;
        font-weight: 500;
        padding-bottom: 10px;
    }
    .event-about__description {
        padding-bottom: 15px;
    }
    .event-buttons{
        display:flex;
        flex-direction: row;
        justify-content: flex-start;
    }
    .event-buttons__wrap{
        margin-top: 10px;
    }
    .event-buttons__item{
        margin: 10px 15px 0 0;
    }
    .admin-form__image-description {
        font-size: 14px;
        margin-bottom: 10px;
        color: #696969;
    }
</style>