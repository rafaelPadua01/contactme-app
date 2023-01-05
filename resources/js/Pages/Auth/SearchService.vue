<template>
        <v-container>
                <v-card>
                        <v-card-title>
                                Buscador de Serviços
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <v-card-text>
                                <v-form ref="form">
                                        <v-text-field v-model="search" :items="sugest_search"
                                                label="Search a Services" placeholder="Start typing to Search"
                                                append-icon="mdi-database-search" hide-no-data hide-selected
                                                v-on:change="searchService(values, index)" chips small-chips outlined
                                                :loading="loading" desinty="compact" variant="solo"
                                                v-if="(auth_user.length != 0)" return-object>
                                        </v-text-field>
                                </v-form>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-card-text>
                                <v-list v-if="profile_prof">
                                        <v-list-item v-for="prof in profile_prof" :key="prof.id">
                                                <v-list-item-title>Found Users
                                                        ({{ profile_prof.length }})
                                                </v-list-item-title>

                                                <v-list-item-text>
                                                        <v-card>
                                                                <v-img v-if="cloaks == 0"
                                                                        src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                                                                        height="250px" cover>
                                                                        <v-avatar cover size="200" rounded="10">
                                                                                <v-img :lazy-src="('/storage/avatars/' + prof.image_name)"
                                                                                        :src="('/storage/avatars/' + prof.image_name)">

                                                                                </v-img>

                                                                        </v-avatar>
                                                                        <b class="text-white"> {{ prof.name }} {{
                                                                                        prof.lastname
                                                                        }}</b>


                                                                </v-img>
                                                                <v-row>
                                                                        <v-col v-for="cloak in cloaks" :key="cloak.id">
                                                                                <v-img v-if="cloak.selected == true"
                                                                                        :lazy-src="`storage/cloak/${cloak.image_name}`"
                                                                                        :src="`storage/cloak/${cloak.image_name}`"
                                                                                        height="250px" cover>
                                                                                        <v-avatar cover size="200"
                                                                                                rounded="10">
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

                                                                        </v-col>
                                                                </v-row>
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
                                                                                <b> Seguidores</b> ({{ count_followers
                                                                                }})

                                                                        </p>
                                                                 </v-card-text>
                                                                <v-card-actions>
                                                                        <v-btn :to="'/searchProfile/' + prof.id"
                                                                                color="pink-accent-4" class="mb-4">
                                                                                <v-icon>mdi-account</v-icon>
                                                                                see profile
                                                                        </v-btn>
                                                                        <v-btn class="mb-4" color="pink-accent-4"
                                                                                @click="sendMessage()">
                                                                                <v-icon>mdi-account</v-icon>
                                                                                send message
                                                                        </v-btn>
                                                                        <v-btn class="mb-4" color="pink-accent-4"
                                                                                @click="follow()">
                                                                                <v-icon>mdi-plus</v-icon>
                                                                                Follow
                                                                        </v-btn>
                                                                </v-card-actions>
                                                        </v-card>
                                                </v-list-item-text>
                                        </v-list-item>
                                </v-list>
                                <v-list v-else>
                                        <v-list-item-title>Found Users ({{ count_followers }})</v-list-item-title>
                                        <v-list-item>
                                                Nenhum Serviço encontrado
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
                getCloak() {
                        axios.get('/cloak')
                                .then((response) => {
                                        this.cloaks = response.data;
                                        return this.cloaks;
                                }).catch((response) => {
                                        return alert('Error: '.response);
                                });
                },
                onClick() {
                        this.loading = true
                        return this.searchService();
                        // setTimeout(() => {
                        //         this.loading = false;
                        //         this.loaded = true;
                        // }, 2000)
                },
                searchService() {
                        this.loading = true;
                        var search = { search: this.search.charAt(0).toUpperCase() + this.search.slice(1)};
                      
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
                follow() {
                        axios.post(`/Follower/create/${this.auth_user.id}`)
                                .then((response) => {
                                        this.follower = response.data;
                                        return this.follower;
                                })
                                .catch((response) => {
                                        console.log(response.request.status);
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
                this.getCloak();

        }
}
</script>