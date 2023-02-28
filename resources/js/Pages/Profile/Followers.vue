<template>
    <v-container>
        <v-card>
            <v-tabs v-model="tab" bg-color="pink-accent-4">
                <v-tab value="followers">Followers</v-tab>
                <v-tab value="following">Following</v-tab>
            </v-tabs>
            <v-card-text>
                <v-window v-model="tab">
                    <v-window-item value="followers">

                        <v-form ref="form">
                            <v-text-field v-model="search" type="search" label="Search Follower" density="compact"
                                variant="solo" append-inner-icon="mdi-magnify" single-line hide-details
                                @change="searchFollower">
                                <template v-slot:append-inner v-if="search_result >= 1 || search_result">
                                    <v-btn variant="plain" @click="search_result = ''">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </template>
                            </v-text-field>


                        </v-form>

                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-list lines="three">
                            <v-list-item v-if="!followers"> Nenhum seguidor ainda.</v-list-item>
                            <v-list-item v-if="search_not_found">
                                <div class="text-center">
                                    <v-chip v-model="search_not_found" class="text-center mr-2 bg-pink-accent-2">
                                        <template v-slot:append>
                                            <v-btn icon variant="plain" @click="search_not_found = false">
                                                <v-icon>mdi-close</v-icon>
                                            </v-btn>
                                        </template>
                                        Não foi possívem encontrar o usuário.
                                    </v-chip>

                                </div>

                            </v-list-item>
                            <v-list-item v-if="search_result" :title="search_result.name"
                                :subtitle="search_result.lastname">
                                <template v-slot:prepend>

                                    <v-avatar color="pink-accent-4">
                                        <v-img :lazy-src="`/storage/avatars/${search_result.image_name}`"
                                            :src="`/storage/avatars/${search_result.image_name}`" alt="profile_image"
                                            cover></v-img>
                                    </v-avatar>


                                </template>



                                <div v-if="search_result.status == false">Você não segue essa pessoa</div>

                                <div v-else>Seguindo</div>

                                <template v-slot:append>
                                    <v-btn v-if="search_result.status == false" text color="pink-accent-3"
                                        icon="mdi-account-plus" @click="alterStatus(search_result)"></v-btn>
                                    <v-btn text color="pink-accent-3" icon="mdi-account-minus"
                                        @click="unconfirm(search_result)"></v-btn>
                                    <v-btn text icon color="pink-accent-3" @click="remove">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                            </v-list-item>



                            <v-list-item v-if="followers" v-for="follower, index in followers" :key="follower.id"
                                :title="follower.name" :subtitle="follower.lastname" :search="search">
                                <template v-slot:prepend>

                                    <v-avatar color="pink-accent-4">
                                        <v-img :lazy-src="`/storage/avatars/${follower.image_name}`"
                                            :src="`/storage/avatars/${follower.image_name}`" alt="profile_image"
                                            cover></v-img>
                                    </v-avatar>


                                </template>

                                <div v-if="follower.status == false">Você não segue essa pessoa</div>

                                <div v-else>Seguindo</div>
                                <template v-slot:append>
                                    <v-btn v-if="follower.status == false" text color="pink-accent-3"
                                        icon="mdi-account-plus" @click="alterStatus(follower)"></v-btn>
                                    <v-btn text color="pink-accent-3" icon="mdi-account-minus"
                                        @click="unconfirm(follower)"></v-btn>
                                    <v-btn text icon color="pink-accent-3" @click="remove(follower)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </template>

                            </v-list-item>
                            <v-list-item v-if="search_result" :title="search_result.name"
                                :subtitle="search_result.lastname">
                                <template v-slot:prepend>

                                    <v-avatar color="pink-accent-4">
                                        <v-img :lazy-src="`/storage/avatars/${search_result.image_name}`"
                                            :src="`/storage/avatars/${search_result.image_name}`" alt="profile_image"
                                            cover></v-img>
                                    </v-avatar>
                                </template>



                                <div v-if="search_result.status == false">Você não segue essa pessoa</div>

                                <div v-else>Seguindo</div>

                                <template v-slot:append>
                                    <v-btn v-if="search_result.status == false" text color="pink-accent-3"
                                        icon="mdi-account-plus" @click="alterStatus(search_result)"></v-btn>
                                    <v-btn text color="pink-accent-3" icon="mdi-account-minus"
                                        @click="unconfirm(search_result)"></v-btn>
                                    <v-btn text icon color="pink-accent-3" @click="remove">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-spacer></v-spacer>
                        </v-list>

                    </v-window-item>
                    <v-window-item value="following">
                       

                        <div v-if="following.length >= 1">
                            <v-list lines="trhee">
                                <v-list-item v-if="search_not_found">
                                    <div class="text-center">
                                        <v-chip v-model="search_not_found" class="text-center mr-2 bg-pink-accent-2">
                                            <template v-slot:append>
                                                <v-btn icon variant="plain" @click="search_not_found = false">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </template>
                                            Não foi possívem encontrar o usuário.
                                        </v-chip>

                                    </div>

                                </v-list-item>
                                <v-list-item v-if="search_result" :title="search_result.name"
                                    :subtitle="search_result.lastname">

                                    <template v-slot:prepend>

                                        <v-avatar color="pink-accent-4">
                                            <v-img :lazy-src="`/storage/avatars/${search_result.image_name}`"
                                                :src="`/storage/avatars/${search_result.image_name}`" alt="profile_image"
                                                cover></v-img>
                                        </v-avatar>


                                    </template>



                                    <div v-if="search_result.status == false">Você não segue essa pessoa</div>

                                    <div v-else>Seguindo</div>

                                    <template v-slot:append>
                                        <v-btn v-if="search_result.status == false" text color="pink-accent-3"
                                            icon="mdi-account-plus" @click="alterStatus(search_result)"></v-btn>
                                        <v-btn text color="pink-accent-3" icon="mdi-account-minus"
                                            @click="unconfirm(search_result)"></v-btn>
                                        <v-btn text icon color="pink-accent-3" @click="remove">
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </template>
                                </v-list-item>

                                <v-list-item v-for="follow in following" :key="follow.id">
                                    <div v-if="follow.status == true">
                                        <v-list-item-title>
                                            {{ follow.name }}
                                        </v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ follow.lastname }}
                                        </v-list-item-subtitle>
                                    </div>


                                
                                        <template v-slot:prepend v-if="follow.status == true">

                                            <v-avatar color="pink-accent-4">
                                                <v-img :lazy-src="`/storage/avatars/${follow.image_name}`"
                                                    :src="`/storage/avatars/${follow.image_name}`" alt="profile_image"
                                                    cover></v-img>
                                            </v-avatar>
                                        

                                        </template>

                                    <template v-slot:append v-if="follow.status == true">
                                            <v-btn v-if="follow.status == false" text color="pink-accent-3"
                                                icon="mdi-account-plus" @click="alterStatus(follow)"></v-btn>
                                            <v-btn text color="pink-accent-3" icon="mdi-account-minus"
                                                @click="unconfirm(follow)"></v-btn>
                                            <v-btn text icon color="pink-accent-3" @click="remove">
                                                <v-icon>mdi-delete</v-icon>
                                            </v-btn>
                                        </template>
                                  
                                  
                                </v-list-item>
                            </v-list>

                        </div>
                        <div v-else class="text-center">
                            <v-chip class="ma-2" color="pink-accent-4">
                                Você ainda não segue pessoas
                            </v-chip>

                        </div>
                    </v-window-item>
                </v-window>


            </v-card-text>

        </v-card>

    </v-container>
</template>

<script>
import axios from 'axios';
export default {
    data: () => ({
        tab: null,
        followers: [],
        following: [],
        search: '',
        search_following: '',
        search_result: false,
        search_not_found: false,
    }),
    computed: {
        // searchFollower() { 
        //     this.followers.map((follower) => {
        //         if (this.search && (follower.follower_name == this.search) || (follower.follower_lastname == this.search)) {
        //             this.followers.indexOf(follower) > -1;
        //             console.log( this.followers.indexOf(follower) > -1);
        //            return this.followers;
        //         }
        //         else
        //         {
        //             alert('erro aqui');
        //         }
        //         
        //      });
        //     return this.followers;
        // }
    },
    methods: {
        getFollowers() {
            axios.get(`/Follower/followers/${this.$route.params.id}`)
                .then((response) => {
                    return this.followers = response.data;
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                });
        },
        getFollowing() {
            axios.get(`/Follower/following/${this.$route.params.id}`)
                .then((response) => {
                    this.following = response.data;
                })
                .catch((response) => {
                    alert('Error'.response);
                })
        },
        searchFollower() {
            this.followers.map((follower) => {
                if (this.search == follower.name || this.search == follower.lastname) {
                    // this.followers.indexOf(follower) > -1;
                    this.search = "";
                    return this.search_result = Object.assign(follower);
                    console.log(this.followers);
                    //return this.followers;    
                }
                this.search_result = false;
                this.search = "";
                this.search_not_found = true;

                return this.search_result;
            });
        },
        //searchFollowing() {
        //    this.following.filter((following) => {
        //        if (this.search_following.toLowerCase() === following.name.toLowerCase() || this.search_following === following.lastname) {
        //            this.search_following = "";
        //            return this.search_result = Object.assign(following);
//
        //        }
        //        this.search_result = false;
        //        this.search_following = "";
        //        this.search_not_found = true;
        //        return this.search_result;
        //    });
       // },
        alterStatus(follower) {
            axios.post(`/Follower/alterStatus/${follower.user_id}`)
                .then((response) => {
                    this.getFollowers();
                    this.getFollowing();
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
            axios.post(`/Follower/unconfirm/${follower.user_id}`)
                .then((response) => {
                    this.getFollowers();
                    this.getFollowing();
                    return follower.status = response.data;
                }).catch((response) => {
                    return alert('Error:' + response);
                });
        },
        remove(follower) {
            axios.post(`/Follower/unfollow/${this.$route.params.id}`)
                .then((response) => {
                    return this.followers.splice(this.followers.indexOf(follower), 1);;
                }).catch((response) => {
                    return alert('Error:'.response);
                });
        },
    },
    created() {
        this.getFollowers();
        this.getFollowing();
    }
}
</script>