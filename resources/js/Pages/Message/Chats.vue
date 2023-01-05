<template>
    <v-container>
        <v-row fluid>
            <v-col v-if="chats.length == 0">
                <v-card>
                    <v-card-text>
                        Não existem conversas aqui...   
                    </v-card-text>
                </v-card>
                
            </v-col>
        <v-col class="d-flex" cols="12" sm="6" v-for="chat in chats" :key="chat.id">
            <v-card>
                <v-toolbar color="pink-accent-4">
                    <v-toolbar-title>
                        <v-avatar rounded="10" size="40">
                            <v-img :src="`/storage/avatars/${chat.image_name}`" cover>
                            </v-img>
                        </v-avatar>
                        {{ chat.name }} {{ chat.lastname }}
                    </v-toolbar-title>
                    <template v-slot:append>
                        <v-btn icon>
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                </v-toolbar>

                <v-card-text v-if="!chats">
                    <p>Nenhuma conversa encontrada</p>
                </v-card-text>
                <v-card-text v-else>
                    {{ chat.message }} ...
                </v-card-text>
                <v-card-subtitle>
                    <b>Criado em: {{ chat.created_at  }}</b> 
                </v-card-subtitle>

                <v-card-actions>
                    <v-btn icon color="primary" :to="`/messages/${chat.id}`">
                        <v-icon>mdi-eye</v-icon>
                    
                    </v-btn>
                    <v-btn icon color="error">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-col>
      </v-row>
    </v-container>
   

</template>

<script>
import axios from 'axios';

    export default {
        data: () => ({
            chats: [],
        }),
        methods: {
            getChats(){
                axios.get(`/chats/${this.$route.params.id}`)
                .then((response) => {
                    this.chats = response.data;
                })
                .catch((response) => {
                    return alert('Error: ' + response)
                })
            }
        },
        created() {
            this.getChats();
        },
    }
</script>