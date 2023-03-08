<template>
        <v-container>
                <v-card>
                        <v-card-title class="bg-pink-accent-4">
                                Buscador de Serviços
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <v-card-text>
                                Faça uma busca por um usuario, serviço ou cidade.
                                <v-form ref="form">
                                        <v-text-field v-model="search" :items="sugest_search" label="Search a Services"
                                                placeholder="Start typing to Search" append-icon="mdi-database-search"
                                                hide-no-data hide-selected v-on:change="searchService(values, index)" outlined
                                                :loading="loading" desinty="compact" variant="solo"
                                                v-if="(auth_user.length != 0)" return-object>
                                        </v-text-field>
                                </v-form>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-card-text>
                                <v-list>
                                        <v-list-item v-if="this.profile_prof">
                                                <v-list-item-title>Found Users
                                                        ({{ profile_prof.length }})
                                                </v-list-item-title>
                                                <v-list-item v-for="prof in profile_prof" :key="prof.id">
                                                        <v-card v-if="prof.cloak_status == true">
                                                                <v-img :lazy-src="`storage/cloak/${prof.cloak_image}`"
                                                                        :src="`storage/cloak/${prof.cloak_image}`"
                                                                        height="250px" cover>
                                                                        <v-avatar size="200" rounded="10" class="float-center">
                                                                                <v-img :lazy-src="`storage/avatars/${prof.image_name}`"
                                                                                        :src="`storage/avatars/${prof.image_name}`"
                                                                                        cover>
                                                                                </v-img>
                                                                        </v-avatar>

                                                                        <b class="text-white"> {{ prof.name }} {{ prof.name }}
                                                                        </b>

                                                                </v-img>

                                                                <v-card-subtitle>
                                                                        <p>
                                                                                <v-icon>mdi-map-marker</v-icon>
                                                                                {{ prof.cidade }}
                                                                                <v-icon>mdi-map-marker</v-icon>
                                                                                {{ prof.bairro }}
                                                                        </p>

                                                                </v-card-subtitle>
                                                                <v-card-text>
                                                                        <p>
                                                                                <b>Profissão:</b> {{ prof.profissao }}
                                                                                <b>especialidades:</b> {{ prof.especialidades }}
                                                                        </p>
                                                                        <p>
                                                                                <b>Seguidores: ({{ count_followers }})</b>
                                                                        </p>
                                                                </v-card-text>

                                                                <v-card-actions>
                                                                        <v-btn-group>
                                                                                <v-btn class="mb-4" color="pink-accent-4"
                                                                                        variant="plain"
                                                                                        :to="`/searchProfile/${prof.id}`">
                                                                                        <v-icon>mdi-account</v-icon>
                                                                                        see profile
                                                                                </v-btn>
                                                                                <v-btn class="mb-4" color="pink-accent-4"
                                                                                        variant="plain"
                                                                                        @click="$event => sendMessage()">
                                                                                        <v-icon>mdi-account</v-icon>
                                                                                        send message
                                                                                </v-btn>
                                                                                <v-btn class="mb-4" color="pink-accent-4"
                                                                                        variant="plain" @click="follow(prof)">
                                                                                        <v-icon>mdi-plus</v-icon>
                                                                                        follow
                                                                                </v-btn>
                                                                        </v-btn-group>
                                                                </v-card-actions>
                                                        </v-card>
                                                        <v-card v-else-if="!prof.cloak_status">
                                                                <v-img src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                                                        height="250px" cover>
                                                                        <v-avatar cover size="200" rounded="10">
                                                                                <v-img :lazy-src="('/storage/avatars/' + prof.image_name)"
                                                                                        :src="('/storage/avatars/' + prof.image_name)">

                                                                                </v-img>

                                                                        </v-avatar>
                                                                        <b class="text-white"> {{
                                                                                prof.name
                                                                        }} {{
        prof.lastname
}}</b>


                                                                </v-img>

                                                                <v-card-subtitle>
                                                                        <p>
                                                                                <v-icon>mdi-map-marker</v-icon> Cidade:
                                                                                {{ prof.cidade }}
                                                                                <v-icon>mdi-map-marker</v-icon> Bairro:
                                                                                {{ prof.bairro }}
                                                                        </p>
                                                                </v-card-subtitle>


                                                                <v-card-text>
                                                                        <p>
                                                                                <b> Profisão:</b> {{ prof.profissao }}
                                                                                <b> especialidades:</b>
                                                                                {{ prof.especialidades }}

                                                                        </p>
                                                                        <p>
                                                                                <b> Seguidores</b> ({{
                                                                                        count_followers
                                                                                }})

                                                                        </p> Found Users ({{ count_followers }})

                                                                        Nenhum Serviço encontrado
                                                                </v-card-text>

                                                        </v-card>
                                                </v-list-item>

                                        </v-list-item>
                                        <v-list-item v-else-if="!this.profile_prof">
                                                <p class="text-h6">
                                                        Found Users ({{ 0 }})
                                                </p>

                                                <p class="text-h8">
                                                        Nenhum Serviço encontrado
                                                </p>

                                        </v-list-item>
                                </v-list>

                                <v-divider></v-divider>
                        </v-card-text>
                        <v-btn block color="primary" class="mb-4" v-if="(profile_prof.length >= 1)" @click="seeMore()">
                                <v-icon>mdi-eye</v-icon>
                                see more
                        </v-btn>
                </v-card>
        </v-container>
</template>

<script>
import axios from 'axios';

export default {
        data: () => ({
                loaded: false,
                loading: false,
                search: '',
                auth_user: [],
                sugest_search: ['Trancista', 'Manicure', 'Cabeleleira', 'outros...'],
                profile_prof: [],
                follower: '',
                followers: [],
                count_followers: 0,
                cloaks: [],
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
                                });
                },
                onClick() {
                        this.loading = true
                        return this.searchService();
                },
                searchService() {
                        this.loading = true;
                        var search = { search: this.search.charAt(0).toUpperCase() + this.search.slice(1) };

                        axios.post('/searchService/' + this.auth_user.id, search)
                                .then((response) => {
                                        this.profile_prof = response.data;
                                        if (this.profile_prof == false) {
                                                this.error = 'Não temos nenhum usuário ofertando este serviço no momento...'
                                        }
                                        this.loading = false;
                                        this.loaded = true;
                                        return this.profile_prof;

                                })
                                .catch((response) => {
                                        this.loading = false;
                                        this.loaded = true;
                                        return alert(response);
                                });
                        //seta um periodo de termino da função
                        setTimeout(() => {
                                this.loading = false; //fecha o carregamento
                                this.loaded = true; // carregamento recebe true
                        }, 20000); //encerra após 2000 /ms 


                },
                seeProfile() {
                        alert('Trabalhando aqui');
                },
                sendMessage() {
                        alert('Trabalhando aqui');
                },
                follow(prof) {
                        axios.post(`/Follower/create/${prof.id}`)
                                .then((response) => {
                                        this.follower = response.data;
                                        return this.follower;
                                })
                                .catch((response) => {
                                        if (response.request.status == 500) {
                                                alert('Você Já segue está pessoa...');
                                        }
                                        else {
                                                alert('Error :' + response);
                                        }

                                });
                },
                countFollowers() {
                        axios.get('Follower')
                                .then((response) => {
                                        let count = 0;
                                        this.followers = response.data
                                        for (let i = 0; i < this.followers.length; i++) {
                                                count += i + 1;
                                                return this.count_followers = count;
                                        }
                                }).catch((response) => {

                                });
                },
                seeMore() {
                        alert('Trabalhando aqui');
                }
        },
        created() {
                this.user();
                this.countFollowers();
        }
}
</script>