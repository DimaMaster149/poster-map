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
                                <div class="nav__item">
                                    <router-link :to="{ name: 'example' }">Предложить</router-link>
                                </div>
                                <div class="nav__item">
                                    <router-link :to="{ name: 'example' }">Добавить</router-link>
                                </div>
                            </div>
                    </div>
                    <div class="auth__wrap">
                        <div class="auth">
                            <div class="auth__item">
                                <a href="login">Войти</a>
                            </div>
                            <div class="auth__item">
                                <a href="register">Зарегистрироваться</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        </div>
    </div>
</template>

<script>
    export default {
        name: "App"
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
        padding:10px;
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