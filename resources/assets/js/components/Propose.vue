<template>
    <div class="container">
        <div class="propose__wrap">
            <div class="propose">
                <div class="propose-form">
                    <form @submit="proposeStore" enctype="multipart/form-data" >
                        <input type="hidden" name="event_id" v-model="event.event_id" @change="setEventId" >
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
                        <div class="propose-form__image-description">
                            *Если при редактировании картинка не выбрана, значит она останется прежней.
                        </div>
                        <button class="btn btn-success">Предложить</button>
                    </form>
                </div>
            </div>
        </div>
        {{this.type}}

        <div class="events__wrap">
            <div class="events">
                <div class="events__title">
                    Ваши предложенные события:
                </div>
                <div class="event-block" v-for="event in this.proposedUserEvents" :key="event.event_id">
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
                                    <button class="btn btn-danger" v-on:click="deleteEvent(event)">Удалить</button>
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
    import Datepicker from 'vuejs-datepicker';

    export default {
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
                },
                timePickerOptions:{
                    format: "YYYY-MM-DD",
                    lang: 'en'
                }
            }
        },
        // type: 0 - user, 1 - admin, 2 - unauthorized
        props: {
            type: Number
        },
        created:
            function () {
                this.axios.get("events/proposed")
                    .then(resp =>{
                        let events = resp.data;
                        this.$store.commit('loadProposedUserEvents', events);
                    }).catch(err => {
                    console.log(err);
                });
            },
        computed:{
            proposedUserEvents: function() {
                console.log('computed propose', this.$store.getters.getProposedUserEvents);
                return this.$store.getters.getProposedUserEvents;
            },
        },
        methods: {
            onImageChange(e){
                console.log(e.target.files[0]);
                this.event.event_image = e.target.files[0];
            },
            proposeStore(e) {
                e.preventDefault();
                 let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let formData = new FormData();
                formData.append('event_id', this.event.event_id);
                formData.append('event_title', this.event.event_title);
                formData.append('event_description', this.event.event_description);
                formData.append('event_location', this.event.event_location);
                formData.append('event_date', this.event.event_date);
                formData.append('event_time', this.event.event_time);
                formData.append('event_image', this.event.event_image);

                this.axios.post('/events/proposed/store', formData, config)
                    .then(function (response) {
                        currentObj.$store.commit('addProposedUserEvents', response.data);
                        currentObj.event.event_id = '';
                        currentObj.event.event_title = '';
                        currentObj.event.event_description = '';
                        currentObj.event.event_location = '';
                        currentObj.event.event_date = '';
                        currentObj.event.event_time = '';
                        currentObj.event.event_image = {};
                        //не получается передать картинку
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            editEvent(event){
                this.event.event_id = event.event_id;
                this.event.event_title = event.event_title;
                this.event.event_description = event.event_description;
                this.event.event_location = event.event_location;
                this.event.event_date = event.event_date;
                this.event.event_time = event.event_time;
                this.event.event_image = {};
            },
            deleteEvent (event){
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
                            this.axios.delete("/events/proposed/delete/"+event.event_id)
                                .then(function(resp){
                                    currentObj.$store.commit('deleteProposedUserEvents', event);
                                    console.log('delete response', resp);
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
            setEventId(){
                this.event.event_id = e.target.value;
            },
        },
        name: "Propose",
        components:{
            Datepicker,
        },
    }
</script>

<style scoped>
.propose__wrap{
    margin:20px 0 0 0;
}
.propose{
    display:flex;
    justify-content: center;
}
.propose-form{
    border:1px solid #155724;
    padding:50px;
    box-shadow: 0px 4px 10px 4px rgba(18, 132, 23, 0.48);
}
.events__wrap{
    width:100%;
    height: auto;
    margin:50px 100px 20px 100px;
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
    width: 45%;
    padding: 0 50px 0 0;
}
.event-image__img{
    width:100%;
    height: auto;
}
.event-about__wrap{
    width:55%;
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
.propose-form__image-description {
    font-size: 14px;
    margin-bottom: 10px;
    color: #696969;
}
</style>