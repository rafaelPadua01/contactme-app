<template>
    <v-container>
        <v-row fluid>
            <v-col v-for="chat in chats" :key="chat.id">
                <v-sheet>
                    <v-card v-scoll.self="onScroll" class="overflow-y-auto" max-height="600">
                        <v-toolbar dark :color="chat.color">
                            <v-toolbar-title class="text-white" dark>
                                <v-avatar rounded="2" size="30px">
                                    <v-img :lazy-src="`/storage/avatars/${chat.image_name}`"
                                        :src="`/storage/avatars/${chat.image_name}`" cover>
                                    </v-img>
                                </v-avatar>
                                {{ chat.name }} {{ chat.lastname }}

                            </v-toolbar-title>
                            <template v-slot:append>
                                <v-menu top>
                                    <template v-slot:activator="{ props }">
                                        <v-btn class="mb-4 text-white" icon color="default" @click="chatOptions = true"
                                            v-bind="props">
                                            <v-icon>mdi-dots-vertical</v-icon>
                                        </v-btn>
                                    </template>

                                    <v-color-picker class="ma-2" show-swatches swatches-max-height="400px"
                                        v-model="colorPicker" :modes="['hexa']"
                                        v-on:update:model-value="getColor(colorPicker, chat)">

                                    </v-color-picker>

                                </v-menu>

                            </template>

                        </v-toolbar>

                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <v-sheet>
                            <v-card-text v-if="messages == 0">
                                <v-row>
                                    <v-col>
                                        <v-menu top>
                                            <template v-slot:activator="{ props }">
                                                <v-chip class="ma-2" dark :color="chat.color">
                                                    Inicie uma conversa com este usuário.
                                                </v-chip>
                                            </template>
                                        </v-menu>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-text v-else>

                                <div>
                                    <v-row v-for="(message, index) in messages" :key="index">
                                        <v-col v-if="message.user_id == chat.sender_id" :color="chat.color">
                                            <v-menu top>
                                                <template v-slot:activator="{ props }">

                                                    <v-chip class="ma-2" dark :color="chat.color"
                                                        @click="listItem = true" v-bind="props" v-if="messages">

                                                        <b> {{ message.message }}</b>
                                                        <template v-slot:append>
                                                            <p class="ma-2 text-right text-grey"
                                                                v-if="message.status == false">
                                                                <v-icon>mdi-check</v-icon>
                                                            </p>
                                                            <p class="ma-2 text-right text-green"
                                                                v-if="message.status == true">
                                                                <v-icon>mdi-check-all</v-icon>
                                                            </p>
                                                        </template>
                                                    </v-chip>



                                                    <v-chip class="ma-2 bg-pink-accent-2" dark color="pink-accent"
                                                        @click="listItem = true" v-bind="props" v-if="!messages">
                                                        Inicie uma conversa
                                                        <template v-slot:append>
                                                            <p class="ma-2 text-right text-grey"
                                                                v-if="message.status == false">
                                                                <v-icon>mdi-check</v-icon>
                                                            </p>
                                                            <p class="ma-2 text-right text-green"
                                                                v-if="message.status == true">
                                                                <v-icon>mdi-check-all</v-icon>
                                                            </p>
                                                        </template>
                                                    </v-chip>
                                                    <!--   <div>
                                                        <v-row>
                                                            <v-col>
                                                                <article class="clip ma-2" dark :color="chat.color"
                                                                    @click="listItem = true">
                                                                    <p class="sound-clips"></p>
                                                                </article>
                                                            </v-col>
                                                        </v-row>
                                                    </div> -->
                                                </template>
                                                <v-list v-model="listItem">
                                                    <v-list-item>
                                                        <v-list-item-title @click="removeMessage(message)">
                                                            <v-icon>
                                                                mdi-delete
                                                            </v-icon>
                                                            Remove
                                                        </v-list-item-title>
                                                    </v-list-item>
                                                </v-list>

                                            </v-menu>

                                        </v-col>
                                        <v-col v-if="message.user_id == chat.receiver_id" class="text-right">
                                            <v-menu top>
                                                <template v-slot:activator="{ props }">
                                                    <v-chip class="ma-2" dark :color="chat.color"
                                                        @click="listItem = true" v-bind="props" v-if="messages">

                                                        <b>{{ message.message }}</b>
                                                        <template v-slot:append>
                                                            <p class="ma-2 text-right text-grey"
                                                                v-if="message.status == false">
                                                                <v-icon>mdi-check</v-icon>
                                                            </p>
                                                            <p class="ma-2 text-right text-green"
                                                                v-if="message.status == true">
                                                                <v-icon>mdi-check-all</v-icon>
                                                            </p>
                                                        </template>
                                                    </v-chip>
                                                    <v-chip class="ma-2" dark :color="chat.color"
                                                        @click="listItem = true" v-bind="props" v-if="!messages">
                                                        Inicie uma conversa
                                                        <template v-slot:append>
                                                            <p class="ma-2 text-right text-blue-accent-3"
                                                                v-if="message.status == false">
                                                                <v-icon>mdi-check</v-icon>
                                                            </p>
                                                            <p class="ma-2 text-right text-green"
                                                                v-if="message.status == true">
                                                                <v-icon>mdi-check-all</v-icon>
                                                            </p>
                                                        </template>
                                                    </v-chip>
                                                </template>
                                                <v-list v-model="listItem">
                                                    <v-list-item>
                                                        <v-list-item-title @click="removeMessage(message)">
                                                            <v-icon>
                                                                mdi-delete
                                                            </v-icon>
                                                            Remove
                                                        </v-list-item-title>
                                                    </v-list-item>
                                                </v-list>

                                            </v-menu>

                                        </v-col>
                                    </v-row>
                                    <v-row v-for="voice in voice_messages" :key="voice.id">
                                        <v-col class="text-right">
                                            <v-menu top>
                                                <template v-slot:activator="{props}">
                                                    <v-chip class="ma-2 dark" :color="chat.color" v-bind="props">
                                                    <b>{{ voice.audio_name }}</b>
                                                    <template v-slot:append>
                                                            <p class="ma-2 text-right text-grey"
                                                                v-if="voice.status == false">
                                                                <v-icon>mdi-check</v-icon>
                                                            </p>
                                                            <p class="ma-2 text-right text-green"
                                                                v-if="voice.status == true">
                                                                <v-icon>mdi-check-all</v-icon>
                                                            </p>
                                                        </template>
                                                </v-chip>

                                               
                                                </template>
                                                <v-list v-model="listItem">
                                                    <v-list-item-title @click="removeVoiceMessage(voice)">
                                                        <v-icon>mdi-delete</v-icon>
                                                        Remove
                                                    </v-list-item-title>
                                                </v-list>
                                            </v-menu>
                                          
                                        </v-col>
                                    </v-row>
                                    <div align="right">
                                        <v-row>
                                            <v-col>
                                                <article class="clip ma-2" dark :color="chat.color"
                                                    @click="listItem = true">
                                                    <p class="sound-clips"></p>
                                                </article>
                                            </v-col>
                                        </v-row>
                                    </div>
                                </div>

                                <v-spacer></v-spacer>
                            </v-card-text>
                        </v-sheet>




                        <!--    <template v-slot:append>
                                                            <p class="ma-2 text-right text-grey"
                                                                v-if="message.status == false">
                                                                <v-icon>mdi-check</v-icon>
                                                            </p>
                                                            <p class="ma-2 text-right text-green"
                                                                v-if="message.status == true">
                                                                <v-icon>mdi-check-all</v-icon>
                                                            </p>
                                                        </template> -->

                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <div class="text-right">
                            <v-chip class="ma-2 bg-pink-accent-4" v-for="resp in message"
                                v-if="chat.reveiver_id !== chat.sender_id"><b>Your answered: </b> {{ textMessage }}
                            </v-chip>
                            <p class="ma-2 text-right text-pink-accent-4" v-if="textMesage">

                                <v-icon v-if="textMessage">mdi-check</v-icon>
                            </p>

                        </div>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-card-actions>
                            <v-text-field v-model="textMessage" placeholder="message here" variant="solo"
                                density="compact" single-line hide-details>
                                <template v-slot:append-inner>
                                    <v-btn icon class="text-grey">
                                        <v-icon>mdi-paperclip</v-icon>
                                    </v-btn>
                                </template>
                                <template v-slot:append>
                                    <v-btn-group>
                                        <v-menu v-model="emotions" :close-on-content-click="false" location="top">
                                            <template v-slot:activator="{ props }">
                                                <v-btn icon :color="chat.color" class="mb-4 text-white" v-bind="props"
                                                    @click="this.emotions = true">
                                                    <v-icon>mdi-emoticon</v-icon>
                                                </v-btn>
                                            </template>

                                            <v-card min-width="500">
                                                <v-toolbar>
                                                    <v-toolbar-title>
                                                        lista de icones
                                                    </v-toolbar-title>
                                                    <template v-slot:append>
                                                        <v-btn icon @click="this.emotions = false">
                                                            <v-icon>mdi-close</v-icon>
                                                        </v-btn>
                                                    </template>
                                                </v-toolbar>
                                                <hr>
                                                Desculpe ainda estamos trabalhando nisso...
                                            </v-card>

                                        </v-menu>

                                        <article class="clip d-flex">
                                            <v-btn icon :color="chat.color" class="record mb-4 text-white"
                                                @click="micRequest(chat)">
                                                <v-icon>mdi-microphone</v-icon>
                                            </v-btn>
                                        </article>

                                        <v-btn icon :color="chat.color" class="mb-4 text-white"
                                            @click="sendMessage(chat)">
                                            <v-icon>mdi-send</v-icon>
                                        </v-btn>
                                        <v-btn icon :color="chat.color" class="mb-4 text-white"
                                            @click="backspace(textMessage)">
                                            <v-icon>mdi-backspace</v-icon>
                                        </v-btn>

                                        <v-btn icon :color="chat.color" class="mb-4 text-white"
                                            @click="textMessage = ''">
                                            <v-icon>mdi-close</v-icon>
                                        </v-btn>
                                    </v-btn-group>

                                </template>
                            </v-text-field>
                        </v-card-actions>
                    </v-card>


                </v-sheet>
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
        voice_messages: [],
        swatches: [
            '#FF0000', '#AA0000', '#5500000',
            '#FFFF00', '#AAAA00', '#5555000',
            '#00FFFF', '#00AAAA', '#0055555',
            '#0000FF', '#0000AA', '#0000055',
        ],
        textMessage: '',
        searchChat: '',
        closeOnClick: true,
        listItem: false,
        chatOptions: false,
        colorPicker: '#fff',
        emotions: false,

    }),

    methods: {
        getUser() {
            axios.get(`/user`)
                .then((response) => {
                    return this.user = response.data;
                })
                .catch((response) => {
                    alert('Error: ' + response);
                });
        },
        listenMessageEvent() {
            axios.get('/user')
                .then((response) => {
                    this.user = response.data;
                    window.Echo.private(`message-event.${this.user.id}`)
                        .listen('MessageEvent', (e) => this.messages.push(e.message));
                    return this.getMessages();

                })
                .catch((response) => {
                    return alert(response);
                });
            console.log();

        },
        getChats() {
            axios.get(`/selectChat/${this.$route.params.id}`)
                .then((response) => {

                    this.chats = response.data;
                })
                .catch((response) => {
                    return alert('Error: ' + response)
                })
        },
        getMessages() {
            axios.get(`/messages/show/${this.$route.params.id}`)
                .then((response) => {
                    this.messages = response.data;
                    return this.sendMessage(this.messages.user_id);
                })
                .catch((response) => {
                    return alert('Error :' + response);
                });
        },
        getVoiceMessages(){
            axios.get(`/messages/voice/show/${this.$route.params.id}`)
            .then((response) => {
                this.voice_messages = response.data;
            })
            .catch((response) => {
                alert('Error' + response);
            });
        },
        getColor(colorPicker, chat) {
            let color = { colorPicker: this.colorPicker };
            axios.post(`/chats/changeColor/${chat.id}`, color)
                .then((response) => {
                    return chat.color = response.data;
                })
                .catch((response) => {
                    return alert('Error:' + response);
                });
        },
        micRequest(chat) {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices
                    .getUserMedia(
                        {
                            audio: true,
                        }
                    )
                    .then((stream) => {
                        const mediaRecorder = new MediaRecorder(stream);
                        const record = document.querySelector(".record");
                        const soundClips = document.querySelector(".sound-clips");
                        let chunks = [];

                        record.onmousedown = () => {
                            mediaRecorder.start();
                            record.style.background = 'blue';
                        };

                        mediaRecorder.ondataavailable = (e) => {
                            chunks.push(e.data);
                        };

                        record.onmouseup = () => {
                            mediaRecorder.stop();
                            record.style.background = chat.color;
                        };

                        mediaRecorder.onstop = (e) => {
                            let date = new Date();
                            const day = date.getDate();
                            const month = (date.getMonth() + 1);
                            const year = date.getFullYear();
                            const hours = date.getHours();
                            const minutes = date.getMinutes();
                            const clipName = year + '-' + month + '-' + day + '-' + hours + ':' + minutes;//prompt("enter a name for your sound clip");

                            const clipContainer = document.createElement("article");
                            const clipLabel = document.createElement("p");
                            const audio = document.createElement("audio");
                            const deleteButton = document.createElement("button");

                            clipContainer.classList.add("clip");
                            audio.setAttribute("controls", "");

                            deleteButton.innerHTML = "<span class='mdi mdi-delete'></span>";
                            deleteButton.style.width = '2%';
                            deleteButton.style.height = '20%';
                            deleteButton.style.borderRadius = '50%';
                            deleteButton.style.background = 'grey';
                            deleteButton.style.color = 'white';
                            deleteButton.style.border = 'none';
                            deleteButton.style.textAlign = 'center';
                            deleteButton.style.fontSize = "1rem";
                            deleteButton.style.transition = "all";
                            deleteButton.style.cursor = "pointer";
                            // deleteButton.style.marginTop = "0%";
                            deleteButton.style.marginRight = '25%';



                            //  deleteButton.innerHTML = "Remove";
                            clipLabel.innerHTML = clipName;

                            clipLabel.style.fontSize = '0.7rem';
                            clipLabel.style.marginTop = '0rem';
                            clipLabel.style.color = 'blue';


                            clipContainer.appendChild(audio);
                            clipContainer.appendChild(clipLabel);
                            clipContainer.appendChild(deleteButton);
                            soundClips.appendChild(clipContainer);

                            const blob = new Blob(chunks, { type: "audio/ogg; codecs=opus" });
                            const audioUrl = window.URL.createObjectURL(blob);
                            audio.src = audioUrl;
                            let voice_message = { audio: blob, receiver_id: chat.sender_id };
                            //console.log(mediaRecorder, stream);
                            axios.post(`/messages/voice/${chat.id}`, voice_message, {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                                .then((response) => {
                                    return this.voice_messages.push(response.data);
                                })
                                .catch((response) => {
                                    alert('Erro' + response);
                                });

                            deleteButton.onclick = (e) => {
                                let evtTgt = e.target;
                                evtTgt.parentNode.parentNode.remove(evtTgt.parentNode);
                            };



                        };
                    })
                    .catch((err) => {
                        console.log(`The Following getUserMedia error ocurred: ${err}`);
                    });
            }
            else {
                console.log('getUserMedia not supported on your browser');
            }
        },
        sendMessage(chat) {
            let messages = { messages: this.textMessage, chat_id: chat.id }
            axios.post(`/messages/send/${chat.id}`, messages)
                .then((response) => {
                    this.dialogMessage = false;
                    this.textMessage = '';
                    return this.messages.push(response.data);
                })
                .catch((response) => {
                    return alert('Error:' + response);
                });
        },
        backspace(textMessage) {
            return this.textMessage = textMessage.slice(0, textMessage.length - 1);
        },
        removeMessage(message) {

            axios.post(`/messages/remove/${message.id}`)
                .then((response) => {
                    return this.messages.splice(this.messages.indexOf(message.id), 1);
                })
                .catch((response) => {
                    return alert('Error:' + response);
                })
        }

    },
    created() {
        this.getUser();
        this.getChats();
        this.getMessages();
        this.getVoiceMessages();
        this.listenMessageEvent();
    }
}
</script>
