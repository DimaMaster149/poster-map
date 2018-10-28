<template>
    <div class="container">
        <div class="propose__wrap">
            <div class="propose">
                <div class="propose-block">
                    <form @submit="proposeStore" enctype="multipart/form-data" >
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
                            <input type="text" class="form-control" name="event_date" value="" placeholder="2018-10-25"
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
                        <button class="btn btn-success">Предложить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatePicker from 'vue2-datepicker'

    export default {
        data(){
            return{
                event:{
                    event_title:'',
                    event_description:'',
                    event_location:'',
                    event_date:'',
                    event_time:'',
                    event_image:{},
                }
            }
        },
        methods: {
            onImageChange(e){
                console.log(e.target.files[0]);
                this.event.event_image = e.target.files[0];
            },
            customFormatter(date) {
                return moment(date).format('MMMM Do YYYY');
            },
            proposeStore(e) {
                e.preventDefault();
                 let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                };

                let formData = new FormData();
                formData.append('event_title', this.event.event_title);
                formData.append('event_description', this.event.event_description);
                formData.append('event_location', this.event.event_location);
                formData.append('event_date', this.event.event_date);
                formData.append('event_time', this.event.event_time);
                formData.append('event_image', this.event.event_image);

                this.axios.post('/events/proposed/store', formData, config)
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
        },
        name: "Propose",
        components:{
            DatePicker
        },
    }
</script>

<style scoped>

</style>