<template>
    <v-app style="margin-top: -1%" max-height="1500">
        <v-main>
            <v-container class="py-8" fluid>
                <v-row>
                    <v-col cols="12">
                        <v-sheet>
                            <v-card>
                                <v-toolbar class="bg-pink-accent-4">
                                    <v-toolbar-title v-if="profile_user.sexo == 'masculino'">Bem Vindo {{ auth_user.name }}
                                        {{ profile_user.lastname }}</v-toolbar-title>
                                    <v-toolbar-title v-if="profile_user.sexo == 'feminino'">Bem Vinda {{ auth_user.name }}
                                        {{ profile_user.lastname }} </v-toolbar-title>
                                    <v-toolbar-title v-if="profile_user.sexo == 'outro'">Bem Vinda(o) <b>{{ auth_user.name
                                    }} {{ profile_user.lastname }}</b> </v-toolbar-title>
                                </v-toolbar>

                                <v-card-text>
                                    <div class="d-flex justify-center">
                                        <v-sheet class="ma-2 pa-2">
                                            <v-card width="1000" height="370">
                                                <v-card-title class="bg-primary" v-for="img_prof in profile_img"
                                                    :key="img_prof.id">
                                                    <v-avatar size="100">
                                                        <v-img :lazy-src="`/storage/avatars/${img_prof.image_name}`"
                                                            :src="`/storage/avatars/${img_prof.image_name}`"
                                                            :alt="`${img_prof.image_name}`" cover>
                                                        </v-img>

                                                    </v-avatar>
                                                    {{ auth_user.name }} {{ profile_user.lastname }}
                                                </v-card-title>
                                                <v-card-text>
                                                    <div class="d-flex">
                                                        <v-row fluid>
                                                            <v-col class="text-h6" v-for="img_prof in profile_img"
                                                                :key="img_prof.id">

                                                            </v-col>

                                                        </v-row>
                                                    </div>

                                                </v-card-text>


                                                <v-card-text>
                                                    <v-row>
                                                        <v-col>
                                                            <div class="d-flex" cols="12" sm="6">
                                                                <v-textarea v-model="post" label="Post Here...">
                                                                    your post here...
                                                                </v-textarea>
                                                            </div>

                                                            <div>
                                                                <v-btn-group>
                                                                    <v-btn icon variant="plain" color="red"
                                                                        @click="createPostEmoji">
                                                                        <v-icon>mdi-emoticon</v-icon>
                                                                    </v-btn>
                                                                    <v-btn icon variant="plain" color="green"
                                                                        @click="createPostImg">
                                                                        <v-icon>mdi-image-area</v-icon>
                                                                    </v-btn>
                                                                    <v-btn icon variant="plain" color="blue"
                                                                        @click="createPost">
                                                                        <v-icon>mdi-share</v-icon>
                                                                    </v-btn>
                                                                    <v-btn icon variant="plain" color="error"
                                                                        @click="createPost">
                                                                        <v-icon>mdi-delete-empty</v-icon>
                                                                    </v-btn>
                                                                </v-btn-group>
                                                            </div>
                                                        </v-col>
                                                    </v-row>

                                                </v-card-text>

                                                <v-divider></v-divider>
                                                
                                            </v-card>


                                            <v-divider></v-divider>
                                            <v-spacer></v-spacer>



                                        </v-sheet>


                                    </div>
                                    <div class="d-flex justify-center">
                                     <v-sheet class="ma-2 pa-2" width="1050">
                                            <v-card-text>
                                                Post Here
                                                <v-divider></v-divider>
                                                <v-list line="two">
                                                    <v-list-subheader></v-list-subheader>
                                                    <template v-for="post in posts" :key="post.id">
                                                        <v-list-item>
                                                            <template v-slot:append>
                                                                <v-btn icon variant="plain">
                                                                    <v-icon>mdi-dots-vertical</v-icon>
                                                                </v-btn>
                                                            </template>
                                                        </v-list-item>
                                                        <v-list-item>
                                                            <template v-slot:prepend>
                                                                <v-avatar color="grey-darken-1"></v-avatar>
                                                            </template>
                                                          
                                                        </v-list-item>

                                                        <v-list-item-title>Message {{ post.post }}</v-list-item-title>

                                                        <v-list-item-subtitle>
                                                            {{ post.id }}
                                                        </v-list-item-subtitle>

                                                        <v-list-item>
                                                            <v-btn variant="plain" icon>
                                                                <v-icon>mdi-thumb-up</v-icon>
                                                            </v-btn>
                                                            <v-btn variant="plain" icon>
                                                                <v-icon>mdi-comment</v-icon>
                                                            </v-btn>
                                                            <v-btn variant="plain" icon>
                                                                <v-icon>mdi-share</v-icon>
                                                            </v-btn>
                                                           
                                                            <v-btn variant="plain" icon>
                                                                <v-icon>mdi-delete</v-icon>
                                                            </v-btn>
                                                           
                                                        </v-list-item>

                                                        <v-divider v-if="post" :key="`divider-$(post)`" inset></v-divider>
                                                    </template>
                                                </v-list>
                                            </v-card-text>
                                        </v-sheet>
                                    </div>

                                </v-card-text>
                                <router-view></router-view>

                            </v-card>


                        </v-sheet>

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
        profile_img: [],
        posts: [],
        post: '',
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
                    this.profile_img.push(response.data);
                    return this.profile_img;
                })
                .catch((response) => {
                    return alert(response);
                })
        },
        createPostEmoji() {
            alert('Estamos trabalhando aqui');
        },
        createPostImg() {
            alert('Estamos Trabalhando aqui...')
        },
        createPost() {
            let data = { post: this.post };
            axios.post(`/post/create/${this.auth_user.id}`, data)
                .then((response) => {
                    return this.posts.push(response.data);
                })
                .catch((response) => {
                    alert('Error'.response);
                })
        },
        getPost() {
            axios.get('/post')
                .then((response) => {
                    return this.posts = response.data;
                })
                .catch((response) => {
                    return alert('error:' + response);
                });
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
        },
    },
    created() {
        this.user();
        this.profile();
        this.ProfileImg();
        this.getPost();
    }

}
</script>