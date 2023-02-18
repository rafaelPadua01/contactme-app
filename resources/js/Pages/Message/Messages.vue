<template>
    <v-container>
        <v-row fluid>
            <v-col v-for="chat in chats" :key="chat.id">
                <v-sheet>
                    <v-card v-scoll.self="onScroll" class="overflow-y-auto" max-height="600">
                        <div>
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
                        </div>


                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <div>
                            <v-sheet>
                                <div class="text-center">
                                    <v-chip class="ma-2 bg-warning" dark>Suas ultimas conversas...</v-chip>
                                </div>
                                <div v-if="messages || voice_messages">
                                    <div v-for="message in messages" :key="message.id">
                                        <v-list v-if="message.receiver_id == chat.receiver_id">
                                            <v-list-item>
                                                <v-menu top>
                                                    <template v-slot:activator="{ props }">
                                                        <v-chip class="ma-2" dark :color="chat.color" v-bind="props">
                                                            {{ message.message }}
                                                            <template v-slot:append>
                                                                <p class="ma-2 text-grey" v-if="message.status == false">
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
                                                <div class="text-blue-darken-4">
                                                    {{ message.created_at.slice(0, 10) }}
                                                </div>
                                            </v-list-item>

                                        </v-list>

                                        <v-list v-if="message.sender_id === chat.user_id" class="text-right">

                                            <v-list-item>
                                                <v-menu top>
                                                    <template v-slot:activator="{ props }">
                                                        <v-chip class="ma-2" dark :color="chat.color" v-bind="props">
                                                            {{ message.message }}
                                                            <template v-slot:append>
                                                                <p class="ma-2 text-grey" v-if="message.status == false">
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
                                                <div class="text-blue-darken-4">
                                                    {{ message.created_at.slice(0, 10) }}
                                                </div>
                                            </v-list-item>
                                        </v-list>
                                    </div>
                                    <div v-if="!messages || voice_messages">
                                        <div v-for="voice in voice_messages" :key="voice.id">
                                            <v-list v-if="voice.receiver_id === chat.receiver_id">

                                                <v-list-item>
                                                    <v-menu top>
                                                        <template v-slot:activator="{ props }">
                                                            <v-chip class="ma-2" dark v-bind="props">
                                                                <div class="clip">
                                                                    <audio
                                                                        :src="`/storage/voice/${chat.id}/${voice.audio_name}`"
                                                                        controls></audio>
                                                                </div>

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
                                                    <div class="ma-2 text-blue-darken-4">
                                                        {{ voice.created_at.slice(0, 10) }}
                                                    </div>
                                                </v-list-item>
                                            </v-list>

                                            <v-list v-if="voice.sender_id !== chat.sender_id || voice.sender_id === chat.receiver_id &&
                                                voice.sender_id === chat.sender_id" class="text-right">
                                                <v-list-item>
                                                    <v-menu top>
                                                        <template v-slot:activator="{ props }">
                                                            <v-chip v-bind="props">
                                                                <div class="clip">
                                                                    <audio
                                                                        :src="`/storage/voice/${chat.id}/${voice.audio_name}`"
                                                                        controls></audio>
                                                                </div>

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
                                                    <div class="ma-2 text-blue-darken-4">
                                                        {{ voice.created_at.slice(0, 10) }}
                                                    </div>
                                                </v-list-item>
                                            </v-list>
                                        </div>

                                    </div>
                                    <div v-if="fileImport">
                                        {{ fileImport.file }}
                                    </div>
                                </div>
                            </v-sheet>
                        </div>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>
                        <div v-if="fileImport">
                            <div>
                                <v-chip>
                                    {{fileImport.name}}
                                    <template v-slot:append>
                                        <v-btn icon>
                                            <v-icon>mdi-close</v-icon>
                                        </v-btn>
                                    </template>
                                </v-chip>
                            </div> 
                                       <v-img :src="fileImport.name" :alt="fileImport.name"> </v-img>
                                    </div>
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
                            <v-text-field v-model="textMessage" placeholder="message here" variant="solo" density="compact"
                                single-line hide-details>
                                {{ fileName }}
                                <template v-slot:prepend-inner>
                                    
                                    <v-btn icon class="text-grey" :loading="isSelecting" @click="handleFileImport">
                                        <v-file-input ref="uploader" @change="onFileChanged" hide-input>
                                            <v-icon>mdi-paperclip</v-icon>
                                        </v-file-input>
                                       
                                    </v-btn>

                                    <input ref="uploader" type="file" class="d-none" @change="onFileChanged">
                               
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
                                        <v-btn icon :color="chat.color" class="clip record mb-4 text-white"
                                            @click="micRequest(chat)">
                                            <v-icon>mdi-microphone</v-icon>
                                        </v-btn>


                                        <v-btn icon :color="chat.color" class="mb-4 text-white" @click="sendMessage(chat)">
                                            <v-icon>mdi-send</v-icon>
                                        </v-btn>
                                        <v-btn icon :color="chat.color" class="mb-4 text-white"
                                            @click="backspace(textMessage)">
                                            <v-icon>mdi-backspace</v-icon>
                                        </v-btn>

                                        <v-btn icon :color="chat.color" class="mb-4 text-white" @click="textMessage = ''">
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
        isSelecting: false,
        selectedFile: null,
        fileImport: false,

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
                    return this.messages = response.data;

                })
                .catch((response) => {
                    console.log('Error :' + response);
                });
        },
        getVoiceMessages() {
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
            axios.post(`/chats/changeColor/${this.$route.params.id}`, color)
                .then((response) => {
                    return chat.color = response.data;
                })
                .catch((response) => {
                    return alert('Error:' + response);
                });
        },
        handleFileImport(){
            this.isSelecting = true;
            
            window.addEventListener('focus', () => {
                this.isSelecting = false;
            }, {once: true});

            this.$refs.uploader.click();
        },
        onFileChanged(e){
            this.selectedFile = e.target.files[0];
            this.fileImport = this.selectedFile;
            console.log(this.fileImport);
            return this.textMessage;
            //doSomething
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
                            const audio = document.createElement("audio");


                            const blob = new Blob(chunks, { type: "audio/ogg; codecs=opus" });
                            const audioUrl = window.URL.createObjectURL(blob);
                            audio.src = audioUrl;
                            let voice_message = { audio: blob, receiver_id: chat.sender_id };

                            axios.post(`/messages/voice/${this.$route.params.id}`, voice_message, {
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

                            //   deleteButton.onclick = (e) => {
                            //       let evtTgt = e.target;
                            //       evtTgt.parentNode.parentNode.remove(evtTgt.parentNode);
                            //   };
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
            axios.post(`/messages/send/${this.$route.params.id}`, messages)
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
                    return alert('Error:' + response.error);
                });
        },
        listenMessageEvent() {
            axios.get('/user')
                .then((response) => {
                    this.user = response.data;
                    window.Echo.private(`message-event.${this.user.id}`)
                        .listen('MessageEvent', (e) => this.messages.push(e.message));
                    return this.getMessages()

                })
                .catch((response) => {
                    return alert('Error ' + response.error);
                });

        },
        listenVoiceMessageEvent() {
            axios.get('/user')
                .then((response) => {
                    this.user = response.data;
                    window.Echo.private(`voice-message-event.${this.user.id}`)
                        .listen('VoiceMessageEvent', (e) => this.voice_messages.push(e.voice_messages));
                    return this.getVoiceMessages();
                })
                .catch((response) => {
                    return alert('error' + response.error);
                });

        },
        removeVoiceMessage(voice) {
            axios.post(`/messages/voice/delete/${voice.id}`)
                .then((response) => {
                    return this.voice_messages.splice(this.voice_messages.indexOf(voice.id), 1);
                })
                .catch((response) => {
                    alert('error:' + response.error);
                });
        }

    },
    created() {
        this.getUser();
        this.getChats();
        this.getMessages();
        this.getVoiceMessages();
        this.listenMessageEvent();
        this.listenVoiceMessageEvent();
    }
}
</script>
