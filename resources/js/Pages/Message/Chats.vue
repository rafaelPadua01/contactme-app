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
                    <v-toolbar :color="chat.color" class="text-white">
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

                    <v-card-text v-if="!chats">
                        <p>Nenhuma conversa encontrada</p>
                    </v-card-text>
                    <v-card-text v-else v-for="message in messages">
                        <v-chip :color="chat.color">
                            {{ message.message }}
                        </v-chip>

                    </v-card-text>
                    <v-card-subtitle class="text-center text-blue-darken-4">
                        <b>Criado em: {{ chat.created_at.slice(0, 10) }}</b>
                    </v-card-subtitle>
                    <hr>
                    <v-card-actions class="justify-center">
                        <v-btn-group>
                            <v-btn class="mr-4" icon color="primary" :to="`/messages/${chat.id}`" variant="plain">
                                <v-icon>mdi-eye</v-icon>
                            </v-btn>
                            <v-btn class="mr-4" icon color="error" variant="plain" @click="deleteChat(chat)">
                                <v-icon>mdi-delete</v-icon>
                            </v-btn>
                        </v-btn-group>

                    </v-card-actions>
                </v-card>
                <div>
                    <v-dialog v-if="error">{{ error }}</v-dialog>

                    <v-dialog v-model="chatDialog" v-if="chatDialog">
                        <v-card>
                            <v-toolbar>
                                <v-toolbar-title>
                                    Delete chat
                                </v-toolbar-title>
                                <template v-slot:append>
                                    <v-btn class="mr-2" icon variant="plain">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </template>
                            </v-toolbar>
                            <v-card-text>
                                Remover o chat deste usuário ? {{ chatObject.name }}
                            </v-card-text>

                            <v-card-actions class="justify-center">
                                <v-btn-groups>
                                    <v-btn class="mr-2" variant="plain" color="primary"
                                        @click="confimDeleteChat(chatObject)">
                                        <v-icon>mdi-delete-empty</v-icon>
                                        Delete
                                    </v-btn>
                                    <v-btn class="mr-2" varian="plain" color="default">
                                        <v-icon>mdi-close</v-icon>
                                        Cancel
                                    </v-btn>

                                </v-btn-groups>
                            </v-card-actions>
                        </v-card>

                    </v-dialog>
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
        chatIndex: -1,
        chatObject: null,
        chatDialog: false,
        error: false,
    }),
    methods: {
        getChats() {
            axios.get(`/chats/${this.$route.params.id}`)
                .then((response) => {
                    this.chats = response.data;
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                })
        },
        getMessages() {
            axios.get(`/messages/${this.$route.params.id}`)
                .then((response) => {
                    this.messages = response.data;
                })
                .catch((response) => {
                    this.error = response;
                });
        },
        deleteChat(chat) {
            this.chatIndex = this.chats.indexOf(chat);
            this.chatObject = Object.assign({}, chat);
            this.chatDialog = true;

        },
        confimDeleteChat(chatObject){
            axios.post(`/chats/delete/${chatObject.id}`)
            .then((response) => {
                this.chats.splice(this.chats[this.chatIndex], chatObject.id);
                this.chatDialog = false;
                return
            })
            .catch((response) => {
                alert('Error:' + response);
            });
        }
    },
    created() {
        this.getChats();
        this.getMessages();
    },
}
</script>