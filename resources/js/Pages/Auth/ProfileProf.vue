<template>
    <v-app>
        <v-main>
            <v-container class="py-8" fluid>
                <v-sheet>
                    <v-card class="mx-auto">
                        <v-row>
                            <v-col>
                                <v-img v-if="cloak_user == 0" src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="250px" cover>
                                    <v-avatar color="grey" size="200" rounded="12">
                                        <v-img :src="'storage/avatars/' + profile_img.image_name" alt="profile_image" cover>
                                
                                        </v-img>
                                    </v-avatar>
                                    <v-toolbar color="rgba(0,0,0,0)">
                                        <template v-slot:prepend>
                                
                                            <v-btn color="grey-lighten-4" icon="mdi-cloud-upload" small @click="cloak_dialog = true" link></v-btn>
                                        </template>
                                    </v-toolbar>
                                </v-img>
                            </v-col>
                        </v-row>
                    
                    
                    <v-row>
                        <v-col v-for="cloak in cloak_user" :key="cloak.id">
                            <v-parallax v-if="cloak.selected == true" :lazy-src="'storage/cloak/' + cloak.image_name"
                                :src="'storage/cloak/' + cloak.image_name" height="300px" cover>
                                <v-avatar color="grey" size="200" rounded="12">
                                    <v-img :src="'storage/avatars/' + profile_img.image_name" alt="profile_image" cover>

                                    </v-img>
                                </v-avatar>
                               

                                <v-toolbar color="rgba(0,0,0,0)">
                                    
                                    <template v-slot:prepend>
                                        <v-spacer></v-spacer>
                                <v-spacer></v-spacer>
                                <v-spacer></v-spacer>
                                
                                    <v-btn color="grey-lighten-2" icon="mdi-cloud-upload" @click="cloak_dialog = true" link>
                                        </v-btn>
                                    </template>
                                </v-toolbar>
                            </v-parallax>
                           
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col class="d-flex" cols="12" sm="6">
                            <v-card-text>
                                <v-row>
                                    <v-col>
                    
                                        <p><small><strong> Name: </strong> {{ auth_user.name }} {{ profile_user.lastname }}
                                            </small> </p>
                    
                                    </v-col>
                                    <v-col class="d-flex" cols="12" sm="6">
                                        <div>
                                            <p><small><strong>Sexo: </strong> {{ profile_user.sexo }}</small> </p>
                                        </div>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-col>
                    </v-row>
                     <v-spacer></v-spacer>

                     <v-row>
                        <v-col>
                            <v-card-text>
                                <v-row>
                                    <v-col>
                                        <v-btn-group>
                                            <v-btn color="primary" @click="followUser" link>
                                                <v-icon>mdi-plus</v-icon> Folow
                                            </v-btn>
                                            <v-btn color="primary" @click="dialogMessage" link>
                                                <v-icon>mdi-send</v-icon> Message
                                            </v-btn>
                                            <v-btn color="primary" @click="others" link>
                                                <v-icon>mdi-plus</v-icon> outro
                                            </v-btn>
                                        </v-btn-group>
                                    </v-col>
                                </v-row>
                                
                                <v-divider></v-divider>
                                <v-spacer></v-spacer>

                                <v-row>
                                    <v-col class="d-flex" cols="12" sm="6">
                                        <p><small><strong>Uf</strong>{{ profile_user.uf }}</small> </p>
                                    </v-col>
                                    <v-col class="d-flex" cols="12" sm="6">
                                        <p><small><strong>Cidade: </strong> {{ profile_user.cidade }} </small></p>
                                    </v-col>
                                </v-row>
                            
                                <v-row>
                                    <v-col class="d-flex" cols="12" sm="6">
                                        <div>
                                            <p><small><strong>Profissão: </strong> {{ profile_prof.profissao }}</small></p>
                            
                                        </div>
                                    </v-col>
                                    <v-col class="d-flex" cols="4" sm="4">
                                        <p><small><strong>E-mail:</strong> {{ auth_user.email }}</small></p>
                                    </v-col>
                                </v-row>
                            
                                <v-divider></v-divider>
                                <v-spacer></v-spacer>
                                <v-row>
                                    <v-col class="d-flex" cols="4" sm="4">
                            
                                        <div class="text-center">
                                            <v-chip class="ma-2" color="pink-accent-4" v-for="especialidade in profile_prof.especialidades"
                                                :key="especialidade">
                                                <v-icon start icon="mdi-fire"></v-icon>
                                                {{ especialidade }}
                                            </v-chip>
                                        </div>
                                    </v-col>
                                    <v-col class="d-flex" cols="4" sm="4">
                                        <p><small><strong>Level: {{ profile_prof.tempo_experiencia }}</strong></small></p>
                            
                                    </v-col>
                                </v-row>
                            
                            </v-card-text>
                        </v-col>
                     </v-row>
                    

                </v-card>

                </v-sheet>
                
                <div class="text-center">
                    
                    <v-dialog v-model="cloak_dialog">
                        <v-card>
                            <v-toolbar color="pink-accent-4">
                                <template v-slot:append>
                                        <v-btn @click="cloak_dialog = false">
                                            <v-icon>mdi-close</v-icon>
                                        </v-btn>
                                    </template>
                                <v-toolbar-title>
                                    Upload image
                                    
                                </v-toolbar-title>
                               
                            </v-toolbar>
                           
                            <v-card-text>
                                <v-row>
                                    <v-col>
                                        <div>
                                            <v-alert type="success" v-if="this.success" @click="this.cloak_dialog = false">
                                                Para visualizar sua capa, vá até a aba 'Galery' selecione 'Capas'
                                                e altere a visualização para true
                                            </v-alert>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                      
                                      
                                        </div>
                                        <v-sheet>
                                            <v-form ref="form">
                                            <v-file-input v-model="file" color="pink-accent-3" counter label="File input" placeholder="Select your file"
                                                preppend-icon="mdi-cloud-upload" variant="outlined" :show-size="1000" v-on:change="handleFile()">
                                                <template v-slot:selection="{ fileNames }">
                                                    <template v-for="(fileName, index) in fileNames" :key="fileName">
                                                        <v-chip v-if="file.length < 2" color="pink-accent-4" label size="small" class="mr-2">
                                                            <v-icon>mdi-fire</v-icon>
                                                            {{ fileName }}
                                                        </v-chip>
                                        
                                                        <span v-else-if="index === 2" class="text-overline text-grey-darken-3 mx-2">
                                        
                                                            + {{ file.length - 2 }} file(s)
                                                        </span>
                                                    </template>
                                                </template>
                                            </v-file-input>
                                        </v-form>
                                        </v-sheet>
                                       

                                    </v-col>
                                </v-row>
                                
                            </v-card-text>
                            <v-card-actions>
                                <v-btn icon color="primary">
                                    <v-icon @click="uploadCloak">mdi-cloud-upload</v-icon>

                                </v-btn>
                                <v-btn @click="cloak_dialog = false">Close</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </div>
            </v-container>
        </v-main>
    </v-app>


</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        auth_user: [],
        profile_user: [],
        profile_img: [],
        profile_prof: [],
        cloak_user: [],
        cloak_dialog: false,
        file: [],
        success: false,
    }),
    methods: {
        User() {
            axios.get('/user')
                .then((response) => {
                    this.auth_user = response.data;
                    return this.auth_user;
                }).catch((response) => {
                    return alert('Error : ' + response);
                });
        },
        profileUser() {
            axios.get('/profile')
                .then((response) => {
                    this.profile_user = response.data;
                    return this.profile_user;
                })
                .catch((response) => {
                    return 'Error: ' + response;
                });
        },
        profileImg() {
            axios.get('/profileImg')
                .then((response) => {
                    this.profile_img = response.data;
                    return this.profile_img;
                }).catch((response) => {
                    return 'Error :' + response;
                });
        },
        profileProf() {
            axios.get('/professionalProfile')
                .then((response) => {
                    this.profile_prof = response.data;
                    return this.profile_prof;
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                });
        },
        profileCloak() {
            axios.get(`/cloak`)
                .then((response) => {
                    this.cloak_user = response.data;
                    return this.cloak_user;
                })
                .catch((response) => {
                    alert('Error :' + response);
                })
        },
        handleFile() {
            this.$refs.file;
        },
        uploadCloak() {
            let file = { file: this.file }
            axios.post(`/cloak/upload/${this.profile_user.id}`, file,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
                .then((response) => {
                    this.cloak_user = response.data;
                    this.success = true;

                    setTimeout(() => {
                        this.$router.push(`/cloaks/${this.auth_user.id}`);
                        return this.cloak_user;
                    }, 2000);
                    
                })
                .catch((response) => {
                    alert('Error: '.response);
                });

        },
        followUser() {
            alert('Estamos trabalhando nisso');
        },
        dialogMessage() {
            alert('Estamos trabalhando nisso');
        },
        others() {
            alert('Estamos trabalhando nisso');
        }
    },

    created() {
        this.User();
        this.profileUser();
        this.profileImg();
        this.profileProf();
        this.profileCloak();
    }
}

</script>