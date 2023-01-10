<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-toolbar color="pink-accent-4">
                    <v-toolbar-title>Seguidores</v-toolbar-title>
                </v-toolbar>
                <v-form ref="form">
                    <v-text-field v-model="search" type="search" label="Search Follower" density="compact"
                        variant="solo" append-inner-icon="mdi-magnify" single-line hide-details>
                    </v-text-field>
                </v-form>

                <v-divider></v-divider>
                <v-spacer></v-spacer>

                <v-list lines="three">

                    <v-list-item v-for="follower, index in searchFollower" :key="follower.id" :title="follower.follower_name"
                        :subtitle="follower.follower_lastname" :search="search">
                        <template v-slot:prepend v-if="follower.image_name.length >= 1 && index >= 1">
                            <v-avatar color="pinki-accent-4">
                                <v-img :lazy-src="`/storage/avatars/${follower.image_name}`"
                                    :src="`/storage/avatars/${follower.image_name}`" alt="profile_image"></v-img>
                            </v-avatar>
                            
                        </template>
                        <div v-if="follower.status == false">Você não segue essa pessoa</div>
                        <div v-else>Seguindo</div>
                        <template v-slot:append>
                            <v-btn v-if="follower.status == false" text color="pink-accent-3" icon="mdi-account-plus"
                                @click="confirmFollow(follower)"></v-btn>
                            <v-btn text color="pink-accent-3" icon="mdi-account-minus"
                                @click="unconfirm(follower)"></v-btn>
                            <v-btn text icon color="pink-accent-3" @click="remove">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </template>

                    </v-list-item>
                    <v-divider></v-divider>
                    <v-spacer></v-spacer>
                </v-list>
            </v-card-text>
        </v-card>

    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        followers: [],
        search: '',
    }),
    computed: {
        searchFollower() {
            this.followers.map((follower) => {
                if (this.search && (follower.follower_name === this.search) || (follower.follower_lastname == this.search)) {
                    this.followers.indexOf(follower) > -1;
                    return this.followers;
                }
            });
             return this.followers;
        }
    },
    methods: {
        getFollowers() {
            axios.get(`/Follower/followers/${this.$route.params.id}`)
                .then((response) => {
                    return this.followers = response.data;
                })
                .catch((response) => {
                    return alert('Error: '.response);
                });
        },
        confirmFollow(follower) {
            axios.post(`/Follower/confirm/${follower.id}`)
                .then((response) => {
                
                 return follower.status = response.data;
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
        unconfirm(follower) {
            console.log(follower);
            axios.post(`/Follower/unconfirm/${follower.id}`)
                .then((response) => {
                    return follower.status = response.data;
                }).catch((response) => {
                    return alert('Error:' + response);
                });
        },
        remove() {
            axios.post(`/Follower/unfollow/${this.$route.params.id}`)
                .then((response) => {
                    return this.followers.splice(this.followers.id, 1);;
                }).catch((response) => {
                    return alert('Error:'.response);
                });
        },

    },
    created() {
        this.getFollowers();
    }
}
</script>