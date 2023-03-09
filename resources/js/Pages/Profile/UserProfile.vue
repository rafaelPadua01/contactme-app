<template>
    <v-container>
        <v-sheet>
            <div>
                <v-alert type="error" v-model="erroDialog" @click="this.$router.push('/searchService')">
                    Perfil incompleto.
                </v-alert>
            </div>
            <v-card>
                <v-row>
                    <v-col v-for="profile in profile_user" :key="profile.id">
                        <v-card-text>

                            <v-parallax v-if="profile.c_image.length >= 1 && profile.c_image_status == true"
                                :lazy-src="`/storage/cloak/${profile.c_image}`" :src="`/storage/cloak/${profile.c_image}`"
                                height="250px" cover>
                                <v-avatar cover size="200" rounded="10">
                                    <v-img :lazy-src="('/storage/avatars/' + profile.image_name)"
                                        :src="('/storage/avatars/' + profile.image_name)" alt="avatar" cover>

                                    </v-img>
                                </v-avatar>
                                <b class="text-white"> {{ profile.name }} {{ profile.lastname }} </b>

                            </v-parallax>


                        </v-card-text>
                        <v-card-subtitle>
                            <v-row>
                                <v-col class="d-flex" cols="12" sm="6">
                                    <small>
                                        <b>
                                            <v-icon>mdi-map-marker</v-icon> {{ profile.cidade }}
                                        </b>
                                    </small>
                                    <small>
                                        <b>
                                            <v-icon>mdi-map-marker</v-icon> {{ profile.bairro }}
                                        </b>
                                    </small>
                                </v-col>
                                <v-col class="d-flex" cols="12" sm="6">
                                    <small>
                                        <b>
                                            <b>Sexo:</b> {{ profile.sexo }}
                                        </b>
                                    </small>
                                </v-col>

                                <v-divider></v-divider>
                                <v-col>
                                    <v-btn-group>
                                        <v-btn class="mr-4" size="x-large" v-if="followers.length == 0"
                                            color="pink-accent-2" icon @click="follow" variant="tonal">
                                            <v-icon>mdi-account-multiple-plus</v-icon>
                                            <v-tooltip activator="parent" location="top">Follow {{ profile.name }} {{ profile.lastname }}</v-tooltip>
                                        </v-btn>
                                        <v-btn class="mr-4" size="x-large" v-if="followers.length >= 1"
                                            color="pink-accent-4" icon @click="unfollow" variant="tonal">
                                            <v-icon>mdi-account-multiple-minus</v-icon>
                                            <v-tooltip activator="parent" location="top">Unfollow {{ profile.name }} {{ profile.lastname }}</v-tooltip>
                                        </v-btn>
                                        <v-btn class="mr-4" color="pink-accent-4" size="x-large" icon @click="windowMessage"
                                            variant="tonal">
                                            <v-icon>mdi-message</v-icon>
                                            <v-tooltip activator="parent" location="top">Send message to user {{ profile.name }} {{ profile.lastname }}</v-tooltip>
                                        </v-btn>
                                        <v-btn class="mr-4" size="x-large" color="pink-accent-4" icon
                                            @click="windowAppointments = true" variant="tonal">
                                            <v-icon>mdi-notebook-plus</v-icon>
                                            <v-tooltip activator="parent" location="top">Available times </v-tooltip>
                                        </v-btn>
                                    </v-btn-group>
                                    <div class="text-center">
                                        <v-dialog v-model="dialogMessage">
                                            <v-row>
                                                <v-col>
                                                    <v-card>
                                                        <v-toolbar color="pink-accent-3">
                                                            <v-toolbar-title>
                                                                {{ profile.name }} {{ profile.lastname }}

                                                            </v-toolbar-title>
                                                            <template v-slot:append>
                                                                <v-btn icon @click="dialogMessage = false">
                                                                    <v-icon>mdi-close</v-icon>
                                                                </v-btn>
                                                            </template>
                                                        </v-toolbar>

                                                        <v-card-text>
                                                            <div class="d-flex justify-around-space" cols="12" sm="12">
                                                                You say: <v-chip class="mr-2" color="pink-accent-4">{{
                                                                    messages }}</v-chip>
                                                            </div>
                                                        </v-card-text>
                                                        <v-divider></v-divider>
                                                        <v-spacer></v-spacer>

                                                        <v-card-actions>
                                                            <v-row>
                                                                <v-col cols="12" sm="12">
                                                                    <v-textarea class="mx-2" rows="1" v-model="messages"
                                                                        label="Write message here...">
                                                                        <template v-slot:append-inner>
                                                                            <v-btn class="mb-4" color="pink-accent-3" icon
                                                                                @click="removeCharter">
                                                                                <v-icon>mdi-backspace</v-icon>

                                                                            </v-btn>
                                                                            <v-btn class="mb-4" color="pink-accent-3" icon
                                                                                @click="messages = ''">
                                                                                <v-icon>mdi-close</v-icon>

                                                                            </v-btn>

                                                                            <v-btn class="mb-4" color="pink-accent-3" icon
                                                                                @click="sendMessage(profile)">
                                                                                <v-icon>mdi-message</v-icon>

                                                                            </v-btn>
                                                                        </template>

                                                                    </v-textarea>
                                                                </v-col>
                                                            </v-row>
                                                            <v-row>
                                                                <v-col cols="12" sm="6">

                                                                </v-col>
                                                            </v-row>

                                                        </v-card-actions>
                                                    </v-card>
                                                </v-col>
                                            </v-row>

                                        </v-dialog>

                                        <v-dialog v-model="markDialog">
                                            <v-row>
                                                <v-col>
                                                    <v-card>
                                                        <v-toolbar color="pink-accent-1">
                                                            <v-toolbar-title>
                                                                Solicitação de horario

                                                            </v-toolbar-title>
                                                            <template v-slot:append>
                                                                <v-btn icon @click="markDialog = false">
                                                                    <v-icon>mdi-close</v-icon>

                                                                </v-btn>
                                                            </template>
                                                        </v-toolbar>

                                                        <v-card-text>
                                                            <v-sheet>
                                                                <div>
                                                                    <v-alert type="error" v-if="this.error" variant="tonal"
                                                                        @click="this.error = false">
                                                                        {{ this.error }}
                                                                    </v-alert>
                                                                    <v-alert type="success" v-if="this.success"
                                                                        variant="tonal" @click="this.success = false">
                                                                        {{ this.success }}
                                                                    </v-alert>
                                                                </div>
                                                                <v-form ref="form">

                                                                    <div>
                                                                        <v-text-field
                                                                            :label="'Horario:' + this.editAppoiment.initial_hour + '-' + this.editAppoiment.close_hour"
                                                                            v-model="this.editAppoiment.initial_hour"
                                                                            :rules="initialHourRules"
                                                                            :placeholder="this.editAppoiment.initial_hour + '.' + this.editAppoiment.close_hour"
                                                                            type="time" required>

                                                                        </v-text-field>

                                                                        <v-text-field label="Seu Nome"
                                                                            v-model="this.auth_user.name"
                                                                            :rules="c_nameRules"
                                                                            :placeholder="this.auth_user.name" required>

                                                                        </v-text-field>
                                                                        <v-row>
                                                                            <v-col
                                                                                v-for="day, index in convertDayWorkInArray()"
                                                                                :key="day.id">

                                                                                <v-checkbox v-model="marked_day"
                                                                                    :rules="dayMarkerRules" :label="day"
                                                                                    color="pink-accent-4" hide-details
                                                                                    required :value="day">

                                                                                </v-checkbox>
                                                                            </v-col>
                                                                        </v-row>



                                                                        <!-- <v-text-field
                                                                            :label="'selecione o dia:' + this.editAppoiment.days_work"
                                                                            v-model="marked_day" :rules="dayMarkerRules"
                                                                            type="date" required>

                                                                        </v-text-field> -->
                                                                        {{ this.profile_user.especialidades }}
                                                                        <v-select v-model="service"
                                                                            :rules="[v => !!v || 'Selecione um serviço']"
                                                                            :items="this.especialidades"
                                                                            :item-title="this.especialidades"
                                                                            persistent-hint return-object single-line
                                                                            label="Selecione o serviço"
                                                                            :placeholder="'selecione uma especialidade'"
                                                                            required>

                                                                        </v-select>
                                                                        {{ this.profile_user.especialidades }}
                                                                        <v-textarea label="Observação" v-model="comment"
                                                                            placeholder="Observação..." required>

                                                                        </v-textarea>
                                                                    </div>
                                                                </v-form>
                                                            </v-sheet>
                                                        </v-card-text>

                                                        <v-card-actions>
                                                            <v-btn-group>
                                                                <v-btn @click="saveMarker">Save</v-btn>
                                                                <v-btn @click="this.$refs.form.reset()">Reset</v-btn>
                                                                <v-btn @click="this.markDialog = false">Close</v-btn>
                                                            </v-btn-group>
                                                        </v-card-actions>
                                                    </v-card>
                                                </v-col>
                                            </v-row>

                                        </v-dialog>
                                    </div>
                                </v-col>

                            </v-row>

                        </v-card-subtitle>
                        <v-card-text>
                            <v-row>
                                <v-col class="d-flex" cols="12" sm="6" v-if="(count_followers >= 1)">
                                    <p>
                                        <b>
                                            <v-icon>mdi-account-group-outline</v-icon>
                                            Seguidores:</b> ({{ (count_followers) }})
                                    </p>
                                </v-col>

                                <v-col class="d-flex" cols="12" sm="6">
                                    <b>
                                        <v-icon>mdi-engine-outline</v-icon>
                                        profissao: {{ profile.profissao }}
                                    </b>
                                </v-col>

                            </v-row>

                            <v-spacer></v-spacer>
                            <v-row>
                                <v-col>
                                    <strong>
                                        <v-icon>mdi-toolbox</v-icon>
                                        Especialidades:
                                    </strong>
                                    <v-chip class="mr-2" color="pink-accent-4" v-for="especialidade in especialidades">
                                        <v-icon color="red-accent-4">mdi-fire</v-icon>
                                        {{ especialidade }}
                                    </v-chip>

                                </v-col>
                            </v-row>



                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>

                            <v-row>
                                <v-col>
                                    <b>
                                        <v-icon>mdi-email-fast</v-icon>
                                        E-mail: {{ profile.email }}
                                    </b>
                                </v-col>
                                <v-col class="d-flex" cols="12" sm="6">
                                    <p>
                                        <b>
                                            <v-icon>
                                                mdi-account-hard-hat
                                            </v-icon> LastJob:</b> {{ profile.lastjob }}
                                    </p>
                                </v-col>

                                <v-col class="d-flex" cols="12" sm="6">
                                    <p>
                                        <b>
                                            <v-icon>mdi-semantic-web</v-icon>
                                            Bio:
                                        </b>{{ profile.descricao }}
                                    </p>
                                </v-col>
                            </v-row>

                            <v-divider></v-divider>
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>

                            <v-row>
                                <v-col>
                                    <v-slide-group v-model="slide_image" class="pa-4" selected-class="bg-primary"
                                        show-arrows>
                                        <v-slide-group-item v-for="(img, index) in galery_images" :key="img.id"
                                            v-slot="{ isSelected, toggle, selectedClass }">
                                            <v-card v-if="index <= 4" color="pink-lighten-1"
                                                :class="['ma-4', selectedClass]" height="400" width="250" @click="toggle">

                                                <div class="d-flex fill-height align-center justify-center">
                                                    <v-img cover
                                                        :lazy-src="`/storage/galery/${img.name_galery}/${img.name_image}`"
                                                        :src="`/storage/galery/${img.name_galery}/${img.name_image}`"
                                                        height="2500" max-heigth="500" class="bg-grey-lighten-2"
                                                        @click="showImage(img)">
                                                    </v-img>

                                                </div>
                                            </v-card>
                                        </v-slide-group-item>
                                    </v-slide-group>

                                </v-col>
                            </v-row>
                        </v-card-text>

                    </v-col>
                </v-row>
            </v-card>
            <div>
                <v-dialog v-model="showImgDialog" transition="fab-transition">
                    <v-img :lazy-src="`/storage/galery/${objectImg.name_galery}/${objectImg.name_image}`"
                        :src="`/storage/galery/${objectImg.name_galery}/${objectImg.name_image}`"
                        :alt="`/storage/galery/${objectImg.name_galery}/${objectImg.name_image}`" max-height="600">
                        <v-btn-group class="float-right">
                            <v-btn icon variant="plain">
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                            <v-btn icon variant="plain" @click="showImgDialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-btn-group>


                    </v-img>

                </v-dialog>
            </div>
        </v-sheet>

        <div class="text-center">

            <v-dialog v-model="windowAppointments">
                <v-card class="">
                    <v-toolbar color="pink-accent-4">
                        <v-toolbar-title>
                            Horarios disponiveis

                        </v-toolbar-title>
                        <template v-slot:append>
                            <v-btn icon @click="windowAppointments = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                    </v-toolbar>

                    <v-card-text>
                        <v-row>
                            <v-col>
                                <div>
                                    <v-alert type="error" v-if="this.error" variant="tonal">{{ this.error }}</v-alert>
                                </div>
                                <v-table fixed-header height="250px" hover>
                                    <thead>
                                        <tr>
                                            <th class="text-left">Dias disponiveis</th>
                                            <th class="text-left">Abertura</th>
                                            <th class="text-left">Fechamento</th>
                                            <th class="text-left">Marcar Horário</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="appointment in appointments" :key="appointment.id">
                                            <td>{{ appointment.days_work }}</td>
                                            <td>{{ appointment.initial_hour }}</td>
                                            <td>{{ appointment.close_hour }}</td>
                                            <td>
                                                <v-btn class="mb-4" icon color="pink-accent-4"
                                                    @click="dialogMarker(appointment)">
                                                    <v-icon>mdi-pencil-plus</v-icon>
                                                </v-btn>
                                            </td>

                                        </tr>
                                    </tbody>

                                </v-table>
                            </v-col>
                        </v-row>


                    </v-card-text>
                </v-card>

            </v-dialog>


        </div>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        auth_user: [],
        profile_user: [],
        followers: [],
        galery_images: [],
        slide_image: [],
        cloaks: [],
        appointments: [],
        day_work: [],
        count_followers: 0,
        dialogMessage: false,
        markDialog: false,
        messages: [],
        windowAppointments: false,
        error: false,
        success: false,
        appointmentIndex: -1,
        editAppoiment: '',
        comment: '',
        erroDialog: false,
        objectImg: false,
        indexImg: -1,
        especialidades: [],
        initialHourRules: [
            v => !!v || '*Campo Hora é obrigatorio',
            v => (v && v.length <= 7 || '*Hora inválida'),
        ],
        nameRules: [
            v => !!v || '*Campo nome é obrigatorio',
            v => (v && v.length <= 10 || 'Name must be less than 10 characters'),
        ],
        dayMarkerRules: [
            v => !!v || '*Campo dia é obrigatorio',
            v => (v != 'todos-dias' && v.length <= 10 || '*Campo data é obrigatório'),
        ],
        marked_day: '',
        service: 'select a service',
        showImgDialog: false,
    }),
    methods: {
        getUser() {
            axios.get('/user')
                .then((response) => {
                    this.auth_user = response.data;
                })
                .catch((response) => {
                    this.error = response;
                });
        },
        searchProfile() {
            axios.get(`/searchProfile/${this.$route.params.id}`)
                .then((response) => {
                    this.profile_user = response.data;
                    for (let i = 0; i <= this.profile_user.length; i++) {
                        this.especialidades = JSON.parse(this.profile_user[i].especialidades);
                        return this.especialidades;
                    }
                    // this.especialidades = JSON.parse(this.profile_user.especialidades);
                    return this.profile_user;
                })
                .catch((response) => {
                    alert('Error :' + response);
                });
        },
        getCloak() {
            axios.get(`/cloaks/${this.$route.params.id}`)
                .then((response) => {
                    this.cloaks = response.data;
                    if (this.cloaks.length == 0) {
                        this.erroDialog = true;
                    }
                    return this.cloaks;
                })
                .catch((response) => {
                    return alert('Error :' + response);
                });
        },
        getAppointments() {
            axios.get(`/appointments/${this.$route.params.id}`)
                .then((response) => {
                    return this.appointments = response.data;
                })
                .catch((response) => {
                    return this.error = response;
                });
        },
        convertDayWorkInArray() {
            const days_work = this.editAppoiment.days_work.split(' ');
            return days_work;
        },
        countFollowers() {
            axios.get('/Follower')
                .then((response) => {
                    let count = 0;
                    this.followers = response.data
                    for (let i = 0; i < this.followers.length; i++) {
                        count += i + 1;

                    }
                    return this.count_followers = count;
                })
                .catch((response) => {
                    alert('Error: '.response);
                });
        },
        imageGalery() {
            axios.get(`/imageGalery/all/${this.$route.params.id}`)
                .then((response) => {
                    this.galery_images = response.data;
                    //  this.galery_images.push(response.data);
                }).catch((response) => {
                    alert('Error: '.response);
                });
        },
        follow() {
            axios.post(`/Follower/create/${this.$route.params.id}`)
                .then((response) => {
                    //this.follower = response.data;
                    return this.followers.push(response.data);
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
        unfollow() {
            axios.post(`/Follower/unfollow/${this.$route.params.id}`)
                .then((response) => {
                    return this.followers.splice(this.followers.id, 1);;
                }).catch((response) => {
                    return alert('Error:'.response);
                });
        },
        windowMessage() {
            return this.dialogMessage = true;
        },
        sendMessage() {
            let message = { messages: this.messages }
            axios.post(`/chats/create/${this.$route.params.id}`, message)
                .then((response) => {
                    this.dialogMessage = false;
                    return this.messages = response.data;
                })
                .catch((response) => {
                    return alert('Error:' + response);
                });
        },
        removeCharter() {
            return this.messages = this.messages.slice(0, -1);
        },
        dialogMarker(appointment) {
            this.appointmentIndex = this.appointments.indexOf(appointment);
            this.editAppoiment = Object.assign({}, appointment);
            this.markDialog = true;
        },
        async validate() {
            const { valid } = await this.$refs.form.validate();
            if (valid) return this.saveMarker();

        },
        saveMarker() {
            let data = {
                appointment_id: this.editAppoiment.id,
                marked_hour: this.editAppoiment.initial_hour,
                client_name: this.auth_user.name,
                marked_day: this.marked_day,
                marked_service: this.service,
                note: this.comment,
            }
            axios.post(`/service/create/${this.$route.params.id}`, data)
                .then((response) => {
                    this.success = 'Sua solicitação de horario foi enviada, aguarde que em breve entraremos em contato.';
                    return setTimeout(() => {
                        this.success = false;
                        this.editAppoinment = '';
                    }, 9000)
                    //return this.markDialog = false;
                })
                .catch((response) => {
                    if (response.response.status == 500) {
                        this.error = 'todos os campos devem ser preenchidos';
                        // this.error = response;
                        return setTimeout(() => {
                            this.error = false;
                            this.editAppoinment = '';
                        }, 9000);
                    }
                    this.error = response;
                    return setTimeout(() => {
                        this.error = false;
                        this.editAppoinment = '';
                    }, 9000);

                });
        },
        showImage(img) {
            this.objectImg = Object.assign({}, img);
            this.indexImg = this.galery_images.indexOf(img);
            this.showImgDialog = true;
            console.log(this.indexImg, this.showImgDialog)
            //alert(JSON.stringify(img));
        }
    },
    created() {
        this.getUser();
        this.searchProfile();
        this.countFollowers();
        this.imageGalery();
        this.getCloak();
        this.getAppointments();
    }
}

</script>