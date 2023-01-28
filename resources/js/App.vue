<template>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <v-card class="mx-auto" elevation="12">
        <v-layout ref="app">
            <v-navigation-drawer v-if="auth_user != 0 && auth_user.type == 'default'" permanent v-model="drawer" rail
                expand-on-hover class="text-white dark"
                gradient="to top right, rgba(19, 84, 122, .8), rgba(128, 208, 199, .8) "
                image="https://picsum.photos/1920/1080?random">
                <v-list>
                    <v-list-item :prepend-avatar="'storage/avatars/' + this.profile_img.image_name"
                        :title="auth_user.name + profile_user.lastname" :subtitle="auth_user.email"
                        v-on:click="this.dialog = true" nav>

                    </v-list-item>

                    <v-divider></v-divider>

                    <v-list-item link to="/dashboard">
                        <template v-slot:prepend>
                            <v-icon>mdi-view-dashboard-outline</v-icon>
                        </template>

                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="/profileClient">
                        <template v-slot:prepend>
                            <v-icon>mdi-account</v-icon>
                        </template>

                        <v-list-item-title>Profile</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="/profileProf">
                        <template v-slot:prepend>
                            <v-icon>mdi-inbox-arrow-down</v-icon>
                        </template>

                        <v-list-item-title>See my profile</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="/searchService">
                        <template v-slot:prepend>
                            <v-icon>mdi-magnify</v-icon>
                            <v-list-item-title>search service</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/galery/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-folder-multiple-image</v-icon>
                            <v-list-item-title>Galery</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/followers/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-account-group</v-icon>
                            <v-list-item-title>Followers</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/chats/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-send</v-icon>
                            <v-list-item-title>Messages</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/appointment_book/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-notebook-plus</v-icon>
                            <v-list-item-title>Agenda</v-list-item-title>
                        </template>
                    </v-list-item>


                    <v-list-item link>
                        <template v-slot:prepend>
                            <v-icon>mdi-logout</v-icon>
                        </template>

                        <v-list-item-title @click="logout()">Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-navigation-drawer v-if="auth_user != 0 && auth_user.type == 'enterprise'" permanent v-model="drawer" rail
                expand-on-hover image="https://picsum.photos/1920/1080?random">
                <v-list>
                    <v-list-item :prepend-avatar="'storage/avatars/' + this.profile_img.image_name"
                        :title="auth_user.name + profile_user.lastname" :subtitle="auth_user.email"
                        v-on:click="this.dialog = true" nav>

                    </v-list-item>

                    <v-divider></v-divider>

                    <v-list-item link to="/dashboardEnt">
                        <template v-slot:prepend>
                            <v-icon>mdi-view-dashboard-outline</v-icon>
                        </template>

                        <v-list-item-title>Dashboard</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="/profileClient">
                        <template v-slot:prepend>
                            <v-icon>mdi-account</v-icon>
                            Profile
                        </template>

                    </v-list-item>
                    <v-list-item link to="/profileProf">
                        <template v-slot:prepend>
                            <v-icon>mdi-inbox-arrow-down</v-icon>
                        </template>

                        <v-list-item-title>See my profile</v-list-item-title>
                    </v-list-item>
                    <v-list-item link to="/searchService">
                        <template v-slot:prepend>
                            <v-icon>mdi-magnify</v-icon>
                            <v-list-item-title>search service</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/galery/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-folder-multiple-image</v-icon>
                            <v-list-item-title>Galery</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/followers/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-account-group</v-icon>
                            <v-list-item-title>Followers</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/chats/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-send</v-icon>
                            <v-list-item-title>Messages</v-list-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/appointment_book/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-notebook-plus</v-icon>
                            <v-list-item-title>Agenda</v-list-item-title>
                        </template>
                    </v-list-item>

                    <v-list-item link to="/#/">
                        <template v-slot:prepend>
                            <v-icon>mdi-wrench-cog</v-icon>
                            Settings
                        </template>

                    </v-list-item>

                    <v-list-item link>
                        <template v-slot:prepend>
                            <v-icon>mdi-logout</v-icon>
                        </template>

                        <v-list-item-title @click="logout()">Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-app-bar v-if="auth_user.type == 'default'" color="grey-lighten-2 text-white" name="app-bar"
                class="justify-center" image="https://picsum.photos/1920/1080?random">
                <template v-slot:image>
                    <v-img>
                    </v-img>
                </template>

                <template v-slot:prepend>
                    <v-btn v-if="auth_user" icon>
                        <v-icon @click="drawer = !drawer">mdi-hamburger</v-icon>
                    </v-btn>
                    <v-app-bar-nav-icon icon="mdi-home" to="/">

                    </v-app-bar-nav-icon>
                    <v-btn icon to="/dashboard" v-if="auth_user">
                        <v-icon>mdi-view-dashboard-outline</v-icon>
                    </v-btn>

                </template>

                <v-app-bar-title>TiTulo</v-app-bar-title>

                <v-spacer></v-spacer>

                <v-btn icon to="/login" v-if="(auth_user.length == 0)">
                    <v-icon>mdi-login</v-icon>

                </v-btn>

                <v-btn icon to="/logout" v-else @click="logout">
                    <v-icon>mdi-logout</v-icon>
                </v-btn>


                <div class="d-flex justify-center align-center w-100" id="title_name">

                    <v-btn @click="print('app-bar')" transition="scroll-y-transition" v-if="(auth_user)">
                        {{ auth_user.name }} {{ profile_user.lastname }}
                    </v-btn>
                </div>

                <div class="d-flex justify-space-around">
                    <v-menu>
                        <template v-slot:activator="{ props }">
                            <v-btn icon v-bind="props" stacked>
                                <v-badge
                                    color="red"
                                    dot
                                    v-if="notifications.length >= 1"
                                    content="+9"
                                >
                                    <v-icon>mdi-bell-sleep</v-icon>
                                </v-badge>
                                <v-icon v-else>mdi-bell-sleep</v-icon>
                             
                            </v-btn>
                        </template>
                        <v-list v-if="notifications.length >= 1">
                            <v-list-item v-for="notification, index in notifications" :key="index" :value="index">
                              
                                <v-list-item-title @click="markasread(notification, index)">
                                    <div>
                                        <v-avatar>
                                            <v-icon icon="mdi-account-circle" color="primary"></v-icon>
                                        </v-avatar>
                                        <b>Cliente:</b> {{ notification.data.client_name }}
                                        <b> Dia: </b> {{ notification.data.marked_day }}
                                    </div>
                                   
                                </v-list-item-title>
                              
                                    <div class="text-center">
                                        {{notification.data.service_status}}
                                       <b>Hora:</b> {{ notification.data.marked_hour }}
                                        <b>Service:</b> {{ notification.data.marked_service }}
                                    </div>
                                    <div class="text-center">
                                        <b>Obs:</b> {{ notification.data.note }}
                                    </div>
                                    <hr>
                                        <v-btn-group>
                                            <v-btn color="pink-accent-4" link variant="plain" :to="`/searchProfile/${notification.data.client_id}`">Ver perfil</v-btn>
                                            <v-btn color="pink-accent-4" link variant="plain" @click="confirmService(notification, index)">Confirmar</v-btn>
                                            <v-btn color="pink-accent-4" link variant="plain" @click="removeNotification(notification, index)">Recusar</v-btn>
                                           
                                        </v-btn-group>
                                        
                                  
                            </v-list-item>

                            <v-btn block color="pink-accent-4" @click="markedAllRead(notification)">Marcar todas</v-btn>
                        </v-list>
                        
                        <v-list v-else>
                            <v-list-item>
                                <v-list-item-title>Nenhuma notificação</v-list-item-title>
                            </v-list-item>
                        </v-list>

                        
                    </v-menu>
                </div>
                <v-btn icon>
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>



            </v-app-bar>

            <v-app-bar v-if="auth_user.type == 'enterprise'" color="grey-lighten-2 text-white" name="app-bar"
                class="justify-center" image="https://picsum.photos/1920/1080?random">
                <template v-slot:image>
                    <v-img>
                    </v-img>
                </template>

                <template v-slot:prepend>
                    <v-btn v-if="auth_user" icon>
                        <v-icon @click="drawer = !drawer">mdi-hamburger</v-icon>
                    </v-btn>
                    <v-app-bar-nav-icon icon="mdi-home" to="/">

                    </v-app-bar-nav-icon>
                    <v-btn icon to="/dashboardEnt" v-if="auth_user">
                        <v-icon>mdi-view-dashboard-outline</v-icon>
                    </v-btn>

                </template>

                <v-app-bar-title>TiTulo</v-app-bar-title>

                <v-spacer></v-spacer>

                <v-btn icon to="/login" v-if="(auth_user.length == 0)">
                    <v-icon>mdi-login</v-icon>

                </v-btn>

                <v-btn icon to="/logout" v-else @click="logout">
                    <v-icon>mdi-logout</v-icon>
                </v-btn>


                <div class="d-flex justify-center align-center w-100" id="title_name">

                    <v-btn @click="print('app-bar')" transition="scroll-y-transition" v-if="(auth_user)">
                        {{ auth_user.name }} {{ profile_user.lastname }}
                    </v-btn>
                </div>


                <v-btn icon>
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>

            </v-app-bar>

            <v-main>
                <div class="text-center">
                    <v-alert v-model="success" variant="elevated" type="success" closable close-icon="mdi-close" close-label="close alert">
                        
                            <!-- <template v-slot:append>
                                <v-btn link variant="text" @click="success = false">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </template>
                        -->
                                Horario confirmado
                          
                        
                
                    </v-alert>
                
                </div>
                <div v-if="(profile_prof.length >= 1)">
                    <v-row v-for="prof in profile_prof" :key="prof.id">
                        <v-col class="d-flex" cols="auto" sm="6">

                            <v-avatar rounder="10" size="250" cover>
                                <v-img :src="('/storage/avatars/' + prof.image_name)" :alt=prof.image_name></v-img>
                            </v-avatar>

                        </v-col>
                        <v-col>

                            <p>{{ prof.name }} {{ prof.lastname }}</p>
                            <p>
                                <small> {{ prof.profissao }}</small>
                            </p>
                            <p>
                                <v-icon icon="mdi-map-marker"></v-icon>
                                <small>{{ prof.cidade }}</small>
                                <v-icon icon="mdi-map-marker"></v-icon>
                                <small>{{ prof.bairro }}</small>
                            </p>
                            <p>

                            <p>
                                <!--<v-chip
                                        class="ma-2"
                                        color="pink-accent-2"
                                        outlined
                                        v-for="prof_especial in prof.especialidades"
                                        :key="prof_especial"   
                                    >
                                        <v-icon left v-if="(prof_especial.length >= 1)">
                                             mdi-fire
                                        </v-icon>
                                        {{prof_especial}}
                                    </v-chip>
                                   -->
                                {{ prof.especialidades }}
                            </p>
                            <v-col>
                                <v-btn color="primary" to="/profileRequired">
                                    <v-icon>mdi-account</v-icon>
                                    Perfil
                                </v-btn>
                                <v-btn color="primary" @click="sendMessage()">
                                    <v-icon>mdi-message</v-icon>
                                    Mensagem
                                </v-btn>
                            </v-col>
                            </p>

                        </v-col>

                    </v-row>
                    <v-divider></v-divider>
                    <v-spacer></v-spacer>
                    <v-spacer></v-spacer>


                    <v-btn block color="primary" @click="seeMore()">ver mais</v-btn>
                </div>

                <div v-else>
                    <v-row>
                        <v-col class="d-flex" cols="12" sm="6">
                            {{ error }}
                        </v-col>
                    </v-row>

                </div>

                <br>

                <router-view></router-view>
            </v-main>


        </v-layout>
    </v-card>
    <!-- Dialog upload file-->
    <div class="text-center">
        <v-dialog v-model="dialog">
            <v-sheet>
                <v-card>
                    <v-toolbar class="bg-pink-accent-4">
                        <v-card-title>Editar imagem de perfil</v-card-title>
                        <template v-slot:append>
                            <v-btn @click="dialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                    </v-toolbar>

                    <v-card-text>
                        <v-form ref="form" enctype="multipart/form-data">
                            <v-file-input small-chips label="file input" v-model="file" accept="image/*">
                            </v-file-input>

                        </v-form>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="success" link @click="upload">
                            Upload
                        </v-btn>
                        <v-btn color="error" link @click="reset">
                            Reset
                        </v-btn>
                        <v-btn link @click="close">
                            close
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-sheet>

        </v-dialog>
       
    </div>

    

</template>

<script>
import axios from 'axios';

export default {

    data: () => ({
        drawer: true,
        rail: true,
        layout: null,
        auth_user: [],
        notifications: [],
        profile_user: [],
        profile_img: [],
        profile_prof: [],
        dialog: false,
        file: [],
        notificationIndex: -1,
        success: false,
    }),
    methods: {
        print(key) {
            alert(JSON.stringify(this.$refs.app.getLayoutItem((key), null, 2)))
        },
        user() {
            axios.get('/user')
                .then((response) => {
                    this.auth_user = response.data;
                    return this.auth_user;
                })
                .catch((response) => {
                    return 'Error: ' + response;
                });
        },
        profile() {
            axios.get('/profile')
                .then((response) => {
                    this.profile_user = response.data;
                    return this.profile_user;
                })
                .catch((response) => {
                    return response;
                });
        },
        getNotifications() {
            axios.get(`/user/getNotifications`)
                .then((response) => {
                    this.notifications = response.data;
                })
                .catch((response) => {
                    return false;
                });
        },
        markasread(notification, index) {
            this.notificationIndex = this.notifications.indexOf(index);
            axios.post(`/user/markasread/${notification.id}`)
            .then((response) => {
                return this.notifications.splice(this.notificationIndex);
            })
            .catch((response) => {
                alert(response);
            });
        },
        markedAllRead(){
            axios.post(`/user/markAll`)
            .then((response) => {
                return this.notifications.splice(this.notifications);
            })
            .catch((response) => {
                alert(response);
            });
        },
        confirmService(notification, index){
            axios.post(`/service/marked/alterStatus/${notification.data.service_id}`)
            .then((response) => {
                this.markasread(notification, index);
                this.success = response.data;
                return setTimeout(() => {
                    this.success = false;
                }, 2000);

               // return this.markasread(notification, index);
            })
            .catch((response) => {
                alert(response);
            });
        },  
        removeNotification(notification,index) {
            this.notificationIndex = this.notifications.indexOf(index);
            console.log(this.notificationIndex);
            axios.post(`/service/marked/remove/${notification.data.service_id}`)
                .then((response) => {
                    return this.markasread(notification,index);
                    //return this.notifications.splice(this.notificationIndex);
                })
                .catch((response) => {
                    alert(response);
                });
        },  
        ProfileImg() {
            axios.get('/profileImg')
                .then((response) => {
                    this.profile_img = JSON.stringify(response.data);
                    return this.profile_img;
                })
                .catch((response) => {
                    return alert(response);
                })
        },
        upload() {
            let data = {
                profile_image: this.file
            }
            axios.post('/profileImg/update/' + this.profile_user.id, data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }

                })
                .then((response) => {
                    this.close();
                    this.profile_img = response.data;
                    //this.ProfileImg();
                    window.location.reload();
                    // return this.profile_img.push(response.data);
                })
                .catch((response) => {
                    return 'Error: ' + response;
                });

        },
        reset() {
            this.$refs.form.reset();
        },
        close() {
            this.dialog = false;
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
    },
    mounted() {
        this.getNotifications();
    },
}

</script>
