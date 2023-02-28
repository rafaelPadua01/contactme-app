<template>
    <v-container>
        <v-row fluid>
            <v-col v-if="!chats">
                <v-sheet>
                    <v-card>
                    <v-card-text>
                        <p class="text-h6 text-center">Não existem conversas aqui...</p>   
                        <hr>
                    </v-card-text>

                    </v-card>
                
                </v-sheet>
             
            </v-col>
        <v-col class="d-flex" cols="12" sm="6" v-for="chat in chats" :key="chat.id">
            <v-card v-if="chat">
                <v-toolbar :color="chat.color">
                    <v-toolbar-title :color="chat.color">
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

                <v-card-text v-if="!chats" >
                    <p>Nenhuma conversa encontrada</p>
                </v-card-text>
                <v-card-text v-else>
                    <v-chip :color="chat.color">
                        {{ messages.message }}
                    </v-chip>
                    
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
            <div>
                <v-dialog v-if="error">{{ error }}</v-dialog>
            </div>
           
        </v-col>
      </v-row>
    </v-container>
   

</template>

<script>
import axios from 'axios';

    export default {
        data: () => ({
            chats: [],
            messages: [],
            error: false,
        }),
        methods: {
            getChats(){
                axios.get(`/chats/${this.$route.params.id}`)
                .then((response) => {
                    this.chats = response.data;
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                })
            },
            getMessages(){
                axios.get(`/messages/${this.$route.params.id}`)
                .then((response) => {
                    this.messages = response.data;
                })
                .catch((response) => {
                    this.error = response;
                });
            }
        },
        created() {
            this.getChats();
            this.getMessages();
        },
    }
</script>