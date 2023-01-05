<template>
    <v-container>
        <v-card>
            <v-img v-if="cloaks == 0" src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg" height="250px" cover>
                <v-avatar size="200" rounded="8">
                    <v-img :lazy-src="('/storage/avatars/' + profile_user.image_name)"
                        :src="('/storage/avatars/' + profile_user.image_name)" alt="avatar" cover>

                    </v-img>
                </v-avatar>


            </v-img>

            <v-card-title>
                <b class="text-white">{{ profile_user.name }} {{ profile_user.lastname }} </b>
            </v-card-title>
            <v-spacer></v-spacer>
            <v-row>
                <v-col v-for="cloak in cloaks" :key="cloak.id">
                    <v-img v-if="cloak.selected == true" :lazy-src="`/storage/cloak/${cloak.image_name}`"
                        :src="`/storage/cloak/${cloak.image_name}`" height="250px" cover>
                        <v-avatar cover size="200" rounded="10">
                            <v-img :lazy-src="('/storage/avatars/' + profile_user.image_name)"
                                :src="('/storage/avatars/' + profile_user.image_name)" alt="avatar">

                            </v-img>
                        </v-avatar>
                    </v-img>
                </v-col>
            </v-row>


            <v-card-subtitle>
                <v-row>
                    <v-col class="d-flex" cols="12" sm="6">
                        <small>
                            <b>
                                <v-icon>mdi-map-marker</v-icon> {{ profile_user.cidade }}
                            </b>
                        </small>
                        <small>
                            <b>
                                <v-icon>mdi-map-marker</v-icon> {{ profile_user.bairro }}
                            </b>
                        </small>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="6">
                        <small>
                            <b>
                                <b>Sexo:</b> {{ profile_user.sexo }}
                            </b>
                        </small>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="6">
                        <v-btn-group>
                            <v-btn v-if="followers.length == 0" color="primary" icon @click="follow">
                                <v-icon>mdi-account-multiple-plus</v-icon>

                            </v-btn>
                            <v-btn v-if="followers.length >= 1" color="primary" icon @click="unfollow">
                                <v-icon>mdi-account-multiple-minus</v-icon>

                            </v-btn>
                            <v-btn color="primary" icon @click="windowMessage">
                                <v-icon>mdi-message</v-icon>
                            </v-btn>
                            <v-btn color="primary" icon @click="windowAppointments = true">
                                <v-icon>mdi-notebook-plus</v-icon>
                            </v-btn>
                        </v-btn-group>

                    </v-col>

                </v-row>

            </v-card-subtitle>

            <v-card-text>
                <v-row>
                    <v-col class="d-flex" cols="12" sm="6" v-if="(count_followers >= 1)">
                        <p><b>Seguidores:</b> ({{ (count_followers) }})</p>
                    </v-col>

                    <v-col class="d-flex" cols="12" sm="6">
                        <b>profissao: {{ profile_user.profissao }}</b>
                    </v-col>

                </v-row>
                <v-divider></v-divider>
                <v-spacer></v-spacer>
                <v-row>
                    <v-col class="d-flex" cols="12" sm="6">
                        <b> Especialidades: {{ profile_user.especialidades }}</b>
                    </v-col>

                    <v-col class="d-flex" cols="12" sm="6">
                        <p>
                            <b>LastJob:</b> {{ profile_user.lastjob }}
                        </p>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col>
                        <b>E-mail: {{ profile_user.email }}</b>
                    </v-col>
                    <v-col class="d-flex" cols="12" sm="6">
                        <p> <b> Bio:</b>{{ profile_user.descricao }}</p>
                    </v-col>
                </v-row>

                <v-divider></v-divider>
                <v-spacer></v-spacer>

                <v-row>
                    <v-col class="d-flex" cols="12" sm="6">
                        <v-avatar rounded="0" v-for="(img, index) in galery_images" :key="img.id">

                            <v-img cover :lazy-src="`/storage/galery/${img.name_galery}/${img.name_image}`"
                                :src="`/storage/galery/${img.name_galery}/${img.name_image}`" height="1500"
                                max-heigth="500" class="bg-grey-lighten-2" onclick="alert('Trabalhando nisso...')">
                            </v-img>

                        </v-avatar>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
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
    <div class="text-center">
        <v-dialog v-model="dialogMessage">
            <v-row>
                <v-col class="d-flex" cols="12" sm="6">
                    <v-toolbar color="pink-accent-3">
                        <v-toolbar-title>
                            {{ profile_user.name }} {{ profile_user.lastname }}

                        </v-toolbar-title>
                        <template v-slot:append>
                            <v-btn icon @click="dialogMessage = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </template>
                    </v-toolbar>
                    <v-card>

                        <v-card-text>
                            <div class="text-center bg-pink-accent-4">
                                Você Disse: {{ messages.message }}
                            </div>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-card-actions>
                            <v-row>
                                <v-col cols="12" sm="12">
                                    <v-textarea class="mx-2" rows="1" v-model="messages" label="Write message here...">
                                        <template v-slot:append-inner>
                                            <v-btn class="mb-4" color="pink-accent-3" icon @click="removeCharter">
                                                <v-icon>mdi-backspace</v-icon>

                                            </v-btn>

                                            <v-btn class="mb-4" color="pink-accent-3" icon @click="sendMessage">
                                                <v-icon>mdi-message</v-icon>

                                            </v-btn>

                                            <v-btn class="mb-4" color="pink-accent-3" icon @click="messages = ''">
                                                <v-icon>mdi-close</v-icon>

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
                                    <v-alert type="error" v-if="this.error" variant="tonal" @click="this.error = false">
                                        {{ this.error }}
                                    </v-alert>
                                    <v-alert type="success" v-if="this.success" variant="tonal" @click="this.success = false">
                                        {{ this.success }}
                                    </v-alert>
                                </div>
                                <v-form ref="form">

                                    <div>
                                        <v-text-field
                                            :label="'Horario:' + this.editAppoiment.initial_hour + '-' + this.editAppoiment.close_hour"
                                            v-model="this.editAppoiment.initial_hour" :rules="initialHourRules"
                                            :placeholder="this.editAppoiment.initial_hour + '.' + this.editAppoiment.close_hour"
                                            type="time" required>

                                        </v-text-field>

                                        <v-text-field label="Seu Nome" v-model="this.auth_user.name"
                                            :rules="c_nameRules" :placeholder="this.auth_user.name" required>

                                        </v-text-field>

                                        <v-text-field :label="'selecione o dia:' + this.editAppoiment.days_work"
                                            v-model="marked_day" :rules="dayMarkerRules" type="date" required>

                                        </v-text-field>

                                        <v-select 
                                            v-model="service"
                                            :rules="[v => !!v || 'Selecione um serviço']"
                                            :items="this.especialidades"
                                            :item-title="this.profile_user.especialidades" 
                                            persistent-hint
                                            return-object
                                            single-line label="Selecione o serviço"
                                            :placeholder="'selecione uma especialidade'"
                                            required
                                        >

                                        </v-select>

                                        <v-textarea label="Observação" v-model="comment" placeholder="Observação..."
                                            required>

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
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        auth_user: [],
        profile_user: [],
        followers: [],
        galery_images: [],
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

    }),
    methods: {
        getUser() {
            axios.get('/user')
                .then((response) => {
                    this.auth_user = response.data;
                })
                .catch((respoonse) => {
                    this.error = response;
                });
        },
        searchProfile() {
            axios.get('/searchProfile/' + this.$route.params.id)
                .then((response) => {
                    this.profile_user = response.data;
                    this.especialidades = JSON.parse(this.profile_user.especialidades);
                    return this.profile_user;
                })
                .catch((response) => {
                    alert('Error :' + response);
                });
        },
        getCloak() {
            axios.get('/cloak')
                .then((response) => {
                    this.cloaks = response.data;
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
            axios.get(`/imageGalery/selectedAll/${this.$route.params.id}`)
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
            axios.post(`/chats/create/${this.profile_user.id}`, message)
                .then((response) => {
                    this.dialogMessage = false;
                    return this.messages = response.data;
                })
                .catch((response) => {
                    return alert('Error:' + response);
                });
        },
        removeCharter() {
            alert('Trabalhando nisso aqui');
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
            let day_compare = new Date(this.marked_day.split('-'))
                .toLocaleDateString('pt-br', { weekday: 'long' })
                .normalize("NFD").replace(/[^a-zA-Z\s]/g, "")
                .replace('feira', ''); //converte o valor do input para array e converte para dia da semana e remove a palavra 'feira' 
            const day_work = JSON.parse(this.editAppoiment.days_work.split('-')); //remove '-' do ex: array segunda-terca para ['segunda', 'terca'] 
            
            let findDay = day_work.find(element => element == day_compare); // percorre o array buscando o dia passado no input
             
            if(findDay){
                let data = {
                        appointment_id: this.editAppoiment.id,
                        marked_hour: this.editAppoiment.initial_hour,
                        client_name: this.auth_user.name,
                        marked_day: new Date(this.marked_day.split('-')).toLocaleString('pt-br', { weekday: 'long' }),
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
                            if(response.response.status == 500){
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
            }
            else{
                this.error = 'Este dia não está disponível';
                return setTimeout(() => {
                                this.error = false;
                                this.editAppoinment = '';
                            }, 9000);
            }
            
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