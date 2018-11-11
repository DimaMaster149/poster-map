<template>
    <div>
        <div class="header__wrap">
            <div class="container">
                <div class="header">
                    <div class="nav__wrap">
                            <div class="nav">
                                <div class="nav__item">
                                    <router-link :to="{ name: 'yandex' }">Карта</router-link>
                                </div>
                                <div v-if="this.type !== 2" class="nav__item">
                                    <router-link :to="{ name: 'propose' }">Предложить</router-link>
                                </div>
                                <div v-if="this.type === 1" class="nav__item">
                                    <router-link :to="{ name: 'admin' }">Добавить</router-link>
                                </div>
                            </div>
                    </div>
                    <div class="auth__wrap">
                        <div class="auth">
                            <div v-if="this.type === 2" class="auth__item">
                                <a href="login">Войти</a>
                            </div>
                            <div v-if="this.type === 2" class="auth__item">
                                <a href="register">Зарегистрироваться</a>
                            </div>
                            <div v-if="this.type !== 2" class="auth__item">
                                <router-link to="/" @click.native="logout" >Выйти</router-link>
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
        name: "App",
        // type: 0 - user, 1 - admin, 2 - unauthorized
        props: {
            type: Number
        },
        data: () => ({
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }),
        methods:{
            logout:()=>{
                axios.post('logout').then(response => {
                    if (response.status === 302 || 401) {
                        console.log('logout');
                    }
                    else {
                        // throw error and go to catch block
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
        },
    }
</script>

<style>
    body{
        margin: 0 !important;
        padding: 0;
    }
    a{
        text-decoration: none;
    }
    .header__wrap{
        width:100%;
        height: 60px;
        background-color: #FFEFD5;
    }
    .header{
       display:flex;
       justify-content: space-between;
       font-size:20px;
       height:60px;
       width:100%;

    }
    .nav__wrap{
        margin-left: 50px;
    }
    .nav, .auth{
        display:flex;
        flex-direction: row;
        align-items: center;
        height: 100%;
    }
    .nav__item, .auth__item{
        display:block;
        min-width:50px;
        max-width:250px;
        height: 30px;
        padding: 0 10px 0 10px;
    }
    .nav__item a, .auth__item a{
        text-decoration: none;
    }
    .nav__item a{
        color:#00008B;
        font-weight: 600;
    }
    .nav__item a:hover, .auth__item a:hover{
        font-size:21px;
    }
    .nav__item a:hover,
    .auth__item a:hover
    {
        color:#D2691E;
    }
    .auth__wrap{
        margin-right: 50px;
    }
    .auth{
        display:flex;
        flex-direction: row;
    }
</style>