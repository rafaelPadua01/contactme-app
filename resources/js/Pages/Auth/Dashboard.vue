<template>
    <v-app style="margin-top: -1%" max-height="1500">
        <v-main>
             <v-container class="py-8" fluid>
                <v-row>
                    <v-col cols="12">
                        <v-card>
                            <v-card-title v-if="profile_user.sexo == 'masculino'">Bem Vindo <b>{{ auth_user.name }} {{profile_user.lastname}}</b></v-card-title> 
                            <v-card-title v-if="profile_user.sexo == 'feminino'">Bem Vinda <b>{{ auth_user.name }} {{profile_user.lastname}}</b> </v-card-title>
                            <v-card-title v-if="profile_user.sexo == 'outro'">Bem Vinda(o) <b>{{ auth_user.name }} {{profile_user.lastname}}</b> </v-card-title>
                            <router-view></router-view>
                            <!-- <v-list line="two">
                                <v-list-subheader>{{ card }}</v-list-subheader>
                                <template v-for="n in 6" :key="n">
                                    <v-list-item>
                                        <template v-slot:prepend>
                                            <v-avatar color="grey-darken-1"></v-avatar>
                                        </template>
                                    </v-list-item>

                                    <v-list-item-title>Message {{ n }}</v-list-item-title>

                                    <v-list-item-subtitle>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil repellendus
                                        distinctio similique
                                    </v-list-item-subtitle>

                                    <v-divider v-if="n !== 6" :key="`divider-$(n)`" inset></v-divider>
                                </template>
                            </v-list> -->
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>

</template>

<script>
import axios from 'axios';


export default {
    
    data: () => ({
        drawer: true,
        cards: ['Today', 'Yesterday'],
        auth_user: '',
        profile_user: [],
    }),
    methods: {
        user() {
            axios.get('/user')
                .then((response) => {
                    this.auth_user = response.data;
                    return this.auth_user;
                })
                .catch((response) => {
                    return 'Error: ' + response;
                })
        },
        profile() {
            axios.get(`/profile`)
            .then((response) => {
                return this.profile_user = response.data;
            })
            .catch((response) => {
                return response;
            });
        },
         ProfileImg() {
            axios.get('/profileImg')
                .then((response) => {
                    this.profile_img = response.data;
                    return this.profile_img;
                })
                .catch((response) => {
                    return alert(response);
                })
        },
        logout() {
            axios.post('/logout')
                .then((response) => {
                    window.location = '/login';
                    return true;
                })
                .catch((response) => {
                    alert('Erro' + response);
                    return false;
                });
        }
    },
    created() {
        this.user();
        this.profile();
        this.ProfileImg();
    }

}
</script>