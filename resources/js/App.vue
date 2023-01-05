<template>
  
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    <v-card class="mx-auto" elevation="12">
        <v-layout ref="app">
            <v-navigation-drawer v-if="auth_user != 0" permanent v-model="drawer" rail expand-on-hover
                class="text-white dark" gradient="to top right, rgba(19, 84, 122, .8), rgba(128, 208, 199, .8) "
                image="https://picsum.photos/1920/1080?random">
                <v-list>
                    <v-list-item :prepend-avatar="'storage/avatars/' + this.profile_img.image_name"
                        :title="auth_user.name + profile_user.lastname" 
                        :subtitle="auth_user.email"
                        v-on:click="this.dialog = true" 
                        nav
                    >

                    </v-list-item>

                    <v-divider></v-divider>

                    <v-list-item link to="/dashboard">
                        <template v-slot:prepend>
                            <v-icon>mdi-view-dashboard-outline</v-icon>
                        </template>

                        <v-list-item-title>Dashboard</v-list-item-title>
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
                            <vilist-item-title>search service</vilist-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/galery/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-folder-multiple-image</v-icon>
                            <vilist-item-title>Galery</vilist-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/followers/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-account-group</v-icon>
                            <vilist-item-title>Followers</vilist-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/chats/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-send</v-icon>
                            <vilist-item-title>Messages</vilist-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item link :to="'/appointment_book/' + auth_user.id">
                        <template v-slot:prepend>
                            <v-icon>mdi-notebook-plus</v-icon>
                            <vilist-item-title>Agenda</vilist-item-title>
                        </template>
                    </v-list-item>
                    <v-list-item v-for="[icon, text] in links" :key="icon" link>
                        <template v-slot:prepend>
                            <v-icon>{{ icon }}</v-icon>
                        </template>

                        <v-list-item-title>{{ text }}</v-list-item-title>
                    </v-list-item>

                    <v-list-item link to="/profileClient">
                        <template v-slot:prepend>
                            <v-icon>mdi-account</v-icon>
                        </template>

                        <v-list-item-title>Profile</v-list-item-title>
                    </v-list-item>
                    <v-list-item link>
                        <template v-slot:prepend>
                            <v-icon>mdi-logout</v-icon>
                        </template>

                        <v-list-item-title @click="logout()">Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-app-bar color="grey-lighten-2 text-white" name="app-bar" class="justify-center"
                image="https://picsum.photos/1920/1080?random">
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
                <!-- <v-col class="d-flex" cols="auto" sm="8">

                    <v-autocomplete v-model="values" :items="sugest_search" label="Search a Services"
                        placeholder="Start typing to Search" append-icon="mdi-database-search" hide-no-data
                        hide-selected @change="searchService(values, index)"
                        @click:append="searchService(values, index)" chips small-chips outlined :loading="loading"
                        desinty="compact" variant="solo" v-if="(auth_user.length != 0)" return-object>


                    </v-autocomplete>
                    <v-btn to="/profileRequired">buscar</v-btn>
                    <template v-slot:prepend>
                        <v-btn to="/profileRequired">buscar</v-btn>
                    </template>
                </v-col>-->
                

                <v-btn icon>
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>

            </v-app-bar>

            <v-main>
                <div v-if="(profile_prof.length >= 1)">
                    <v-row v-for="prof in profile_prof" :key="prof.id">
                        <v-col class="d-flex" cols="auto" sm="6">
                            
                            <v-avatar rounder="10" size="250">
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
                            {{error}}
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
            <v-card>
                <v-card-title>Editar imagem de perfil</v-card-title>
                <v-card-text>
                    <v-form ref="form" enctype="multipart/form-data">
                        <v-file-input small-chips label="file input" v-model="file" accept="image/*"
                            v-on:change="handleFileUpload()">
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
        links: [
            ['mdi-delete', 'Trash'],
        ],
        auth_user: [],
        profile_user: [],
        profile_img: [],
        profile_prof: [],
        dialog: false,
        file: [],
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
    }
}

</script>
