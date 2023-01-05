<template>
    <v-container>
        <v-sheet>
            <v-card>
                <v-card-title class="bg-pink-accent-4">
                    Agenda
                    <v-tabs v-model="tabs" color="pink-accent-2" grow bg-color="pink-accent-4">
                        <v-tab @click="attendance = true">
                            <v-icon>mdi-notebook-plus</v-icon>
                        </v-tab>
                        <v-tab @click="appointments = true">
                            <v-icon>mdi-calendar</v-icon>
                        </v-tab>

                    </v-tabs>
                </v-card-title>

                <v-card-text>


                    <v-window v-model="tabs">
                        <v-window-item v-model="attendances">
                            <v-card>
                                <v-card-title>
                                    <div>
                                        <v-alert type="success" v-if="success" variant="tonal" closable
                                            close-label="Close Alert" color="pink-accent-3">Agenda criada com
                                            sucesso</v-alert>
                                        <v-alert type="error" v-if="error" variant="tonal" closable
                                            close-label="Close Alert" color="pink-accent-3">{{ error }}</v-alert>
                                    </div>

                                </v-card-title>
                                <v-card-text>
                                    <v-expansion-panels>
                                        <v-expansion-panel title="Dias de trabalho" color="pink-accent-4">
                                            <v-expansion-panel-text>
                                                <v-form ref="form">
                                                    <v-radio-group v-model="dayWork" inline
                                                        label="Selecione os dias de trabalho" color="pink-accent-4">
                                                        <v-radio label="Todos os dias" value="allDays"></v-radio>
                                                        <v-radio label="Segunda a sexta" value="monToFray"></v-radio>
                                                        <v-radio label="terça a sábado" value="thirSat"></v-radio>
                                                        <v-radio label="sábado e domingo" value="satSun"></v-radio>
                                                        <v-radio label="segunda, quarta e sexta"
                                                            value="monWedFry"></v-radio>
                                                        <v-radio label="terça e quinta" value="thiThur"></v-radio>
                                                    </v-radio-group>
                                                </v-form>
                                            </v-expansion-panel-text>
                                        </v-expansion-panel>
                                    </v-expansion-panels>

                                    <v-divider>Maconha</v-divider>
                                    <v-spacer></v-spacer>

                                    <v-expansion-panels>
                                        <v-expansion-panel title="Horario de trabalho" color="pink-accent-3">
                                            <v-expansion-panel-text>
                                                <v-form ref="form">

                                                    <v-text-field type="time" v-model="h_initial"
                                                        label="Horario de abertura" required color="pink-accent-1">
                                                        {{ h_initial }}
                                                    </v-text-field>

                                                    <v-text-field type="time" v-model="h_close"
                                                        label="Horario de fechamento" color="pink-accent-1" required>
                                                        {{ h_close }}
                                                    </v-text-field>

                                                </v-form>
                                                <v-divider></v-divider>
                                                <v-spacer></v-spacer>


                                            </v-expansion-panel-text>
                                        </v-expansion-panel>
                                    </v-expansion-panels>
                                    <b>Dias de Atendimento:</b> {{ convertDayInArray() }} <b>Inicia:</b> {{ h_initial }}
                                    <b>Encerra:</b> {{ h_close }}
                                    <v-spacer></v-spacer>
                                    <v-spacer></v-spacer>
                                    <v-spacer></v-spacer>
                                    <v-spacer></v-spacer>

                                    <v-btn-group>
                                        <v-btn color="pink-accent-4" @click="save" text>
                                            <v-icon>
                                                mdi-content-save-check
                                            </v-icon>
                                            Save
                                        </v-btn>
                                        <v-btn color="pink-accent-4" @click="this.$refs.form.reset()" text>
                                            <v-icon>mdi-lock-reset</v-icon>
                                            Reset
                                        </v-btn>
                                    </v-btn-group>

                                </v-card-text>
                            </v-card>
                        </v-window-item>

                        <v-window-item v-model="appointments">
                            <v-card>
                                <v-card-text>
                                    <v-expansion-panels color="pink-accent-4">
                                        <v-expansion-panel title="Compromissos Marcados">
                                            <v-expansion-panel-text>
                                                <div v-if="appointmentsItem">
                                                    <v-sheet>
                                                        <v-card>
                                                            <div>
                                                                <v-alert type="success" v-if="success" variant="tonal"
                                                                    closable close-label="Close Alert">
                                                                    Agenda Atualizada com sucesso.
                                                                </v-alert>
                                                                <v-alert type="error" v-if="error" variant="tonal"
                                                                    closable close-label="Close Alert"
                                                                    color="pink-accent-3">
                                                                    {{ error}}
                                                                </v-alert>
                                                            </div>
                                                            <v-card-title>
                                                                <p> Veja seus compromissos marcados e sujestões de
                                                                    atendimento </p>
                                                            </v-card-title>

                                                            <v-divider></v-divider>
                                                            <v-spacer></v-spacer>

                                                            <v-card-text>
                                                                <v-table fixed-header height="300px">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="text-left">Dias disponiveis</th>
                                                                            <th class="text-left">Hora inicial</th>
                                                                            <th class="text-left">Hora Final</th>
                                                                            <th class="text-left">usuarios marcados</th>
                                                                            <th class="text-left">Criado em</th>
                                                                            <th class="text-left">Actions</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr v-for="item in appointmentsItem"
                                                                            :key="item.id">

                                                                            <td>{{ item.days_work.replace(/[^\w\s]/gi, ' ')}}</td>
                                                                            <td>{{ item.initial_hour }}</td>
                                                                            <td>{{ item.close_hour }}</td>

                                                                            <td>
                                                                                <v-btn icon class="mb-4"
                                                                                    color="pink-accent-4"
                                                                                    @click="showMarked(item)">
                                                                                    <v-icon>mdi-account</v-icon>
                                                                                </v-btn>


                                                                            </td>
                                                                            <td>{{ item.created_at.slice(0, 10) }}</td>
                                                                            <td>
                                                                                <v-btn-group>
                                                                                    <v-btn
                                                                                        color="pink-accent-4"
                                                                                        link
                                                                                        @click="editAppointment(item)">
                                                                                        <v-icon>mdi-pencil</v-icon>
                                                                                    </v-btn>
                                                                                    <v-btn
                                                                                        color="pink-accent-4"
                                                                                        link
                                                                                        @click="deleteAppointment(item)">
                                                                                        <v-icon>
                                                                                            mdi-delete
                                                                                        </v-icon>
                                                                                    </v-btn>
                                                                                </v-btn-group>
                                                                            </td>

                                                                        </tr>
                                                                    </tbody>

                                                                </v-table>
                                                            </v-card-text>
                                                        </v-card>
                                                        <div class="text-center">
                                                            <v-dialog v-model="markedDialog">
                                                                <v-card>
                                                                    <v-toolbar class="bg-pink-accent-4">
                                                                        <v-toolbar-title>Solicitações de Horário</v-toolbar-title>
                                                                        <template v-slot:append>
                                                                            <v-btn icon>
                                                                                <v-icon
                                                                                    @click="markedDialog = false">mdi-close</v-icon>
                                                                            </v-btn>
                                                                        </template>
                                                                    </v-toolbar>
                                                                    <v-card-text>
                                                                        <v-list lines="three" v-if="marked_users">
                                                                           
                                                                           
                                                                            <v-list-item 
                                                                                v-for="marked in marked_users"
                                                                                :key="marked.id"
                                                                                :title="marked.client_name"
                                                                                :subtitle="'Dia:' + ' ' + marked.marked_day + ' ' + 'Hora:' + ' ' + marked.marked_hour" 
                                                                                >
                                                                                <v-list-subheader>
                                                                                  <b>Comment:</b>  {{ marked.note }}
                                                                                 </v-list-subheader>
                                                                               
                                                                                <v-list-subheader v-if="marked.status == false" color="red" inset>
                                                                                    Não confirmado
                                                                                </v-list-subheader>
                                                                               
                                                                                <v-list-subheader v-if="marked.status == true" color="green" inset>
                                                                                    confirmado
                                                                                </v-list-subheader>

                                                                                
                                                                                  
                                                                                
                                                                                <template v-slot:prepend>

                                                                                   <v-avatar>
                                                                                        <v-img 
                                                                                            :lazy-src="`/storage/avatars/${marked.image_name}`"
                                                                                            :src="`/storage/avatars/${marked.image_name}`"
                                                                                            :alt="`${marked.image_name}`"
                                                                                            cover
                                                                                        ></v-img>
                                                                                   </v-avatar>

                                                                                  
                                                                                </template>

                                                                                <template v-slot:append>
                                                                                    <v-btn-group>
                                                                                        <v-btn 
                                                                                            class="text-white"
                                                                                            color="#672f0a"
                                                                                            @click="markedStatus(marked)"
                                                                                            text
                                                                                            v-if="marked.status == false"
                                                                                        >
                                                                                            <!-- <v-icon>mdi-plus</v-icon> -->
                                                                                            Confirmar
                                                                                        </v-btn>
                                                                                        <v-btn text color="pink-accent-4" @click="dismatchStatus(marked)" v-if="marked.status == true">
                                                                                            Recusar
                                                                                         <!--   <v-icon>mdi-close</v-icon> -->
                                                                                        </v-btn> 
                                                                                        <v-btn
                                                                                            :to="'/messages/' + marked.chat_id"
                                                                                            link
                                                                                            color="#FFFDD0"
                                                                                        >
                                                                                           <!-- <v-icon>mdi-send</v-icon> -->
                                                                                           Send message
                                                                                        </v-btn>
                                                                                       <v-btn text color="pink-accent-1" @click="removeMarked(marked)">
                                                                                            Remover
                                                                                         <!--   <v-icon>mdi-close</v-icon> -->
                                                                                        </v-btn>
                                                                                    </v-btn-group>


                                                                                </template>

                                                                                <v-divider inset></v-divider>
                                                                            </v-list-item>
                                                                        </v-list>

                                                                        <v-list lines="one" v-if="marked_users == 0">
                                                                            <v-list-item>
                                                                                Você ainda não possui solicitações de horário
                                                                            </v-list-item>
                                                                        </v-list>
                                                                    </v-card-text>
                                                                </v-card>

                                                            </v-dialog>
                                                        </div>
                                                    </v-sheet>

                                                </div>

                                                <div v-if="!appointmentsItem">
                                                    <p> Você ainda não possui compromisso </p>
                                                </div>


                                            </v-expansion-panel-text>
                                        </v-expansion-panel>
                                    </v-expansion-panels>

                                </v-card-text>
                            </v-card>
                        </v-window-item>

                    </v-window>
                </v-card-text>


                <v-divider></v-divider>
                <v-spacer></v-spacer>

            </v-card>

            <div class="text-center">
                <v-row>
                    <v-col class="d-flex" cols="12" sm="6">
                        <v-dialog v-model="editDialog">
                            <v-card>
                                <v-toolbar color="pink-accent-4">
                                    <v-toolbar-title>
                                        Edit Item
                                    </v-toolbar-title>
                                    <template v-slot:append>
                                        <v-btn icon="mdi-close" @click="editDialog = false"></v-btn>
                                    </template>
                                </v-toolbar>
                                <v-card-title>
                                    <v-form ref="form">
                                        <p> Seus dias atuais de trabalho são: <b>{{ editItem.days_work.replace(/[^\w\s]/gi, ' ') }}</b> </p>

                                        <v-radio-group v-model="dayWork" inline
                                            label="Selecione os novos dias de trabalho" color="pink-accent-4">
                                            <v-radio label="Todos os dias" value="allDays"></v-radio>
                                            <v-radio label="Segunda a sexta" value="monToFray"></v-radio>
                                            <v-radio label="terça a sábado" value="thirSat"></v-radio>
                                            <v-radio label="sábado e domingo" value="satSun"></v-radio>
                                            <v-radio label="segunda, quarta e sexta" value="monWedFry"></v-radio>
                                            <v-radio label="terça e quinta" value="thiThur"></v-radio>

                                        </v-radio-group>


                                        <v-text-field type="time" v-model="editItem.initial_hour"
                                            label="Horario de abertura" required color="pink-accent-1">
                                            {{ editItem.initial_hour }}
                                        </v-text-field>

                                        <v-text-field type="time" v-model="editItem.close_hour"
                                            label="Horario de fechamento" color="pink-accent-1" required>
                                            {{ editItem.close_hour }}
                                        </v-text-field>

                                    </v-form>

                                </v-card-title>
                                <v-card-actions>
                                    <v-btn-group color="pink-accent-4">
                                        <v-btn text @click="save">
                                            <v-icon>mdi-save</v-icon>
                                            save
                                        </v-btn>
                                        <v-btn text @click="this.$refs.form.reset()">
                                            <v-icon>mdi-reset</v-icon>
                                            Reset
                                        </v-btn>
                                        <v-btn text>
                                            close

                                        </v-btn>
                                    </v-btn-group>
                                </v-card-actions>

                            </v-card>
                        </v-dialog>

                        <v-dialog v-model="deleteDialog">
                            <v-row fluid>
                                <v-col>
                                    <v-card>
                                        <v-toolbar color="pink-accent-4">
                                            <v-toolbar-title>Remove this appoinment</v-toolbar-title>

                                            <template v-slot:append>
                                                <v-btn @click="deleteDialog = false">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </template>
                                        </v-toolbar>

                                        <v-card-text>
                                            Your sure to remove this appoinment ?
                                            {{ editItem.days_work.replace(/[^\w\s]/gi, ' ') }}
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-btn-group color="pink-accent-4">
                                                <v-btn @click="deleteItem">
                                                    <v-icon>mdi-delete</v-icon>
                                                    Remove
                                                </v-btn>
                                                <v-btn @click="deleteDialog = false">
                                                    <v-icon>mdi-refresh</v-icon>
                                                    Close
                                                </v-btn>
                                            </v-btn-group>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-dialog>
                    </v-col>
                </v-row>

            </div>
        </v-sheet>
    </v-container>


</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        tabs: null,
        attendance: false,
        appointments: false,
        menu: false,
        dayWork: 'monToFray',
        date: '',
        h_initial: '',
        h_close: '',
        success: false,
        error: false,
        appointmentsItem: [],
        markedDialog: false,
        editDialog: false,
        deleteDialog: false,
        editIndex: -1,
        editItem: '',
        marked_users: [],
        markedIndex: -1,
        editMarked: '',

    }),
    watch: {
        editDialog(val) {
            val || this.close();
        },
        deleteDialog(val) {
            val || this.close();
        }

    },
    methods: {
        convertDayInArray() {
            let day_work = '';
            if (this.dayWork == 'allDays') {
                day_work = 'segunda-terca-quarta-quinta-sexta-sabado-domingo';
            }
            else if (this.dayWork == 'monToFray') {
                day_work = 'segunda-terca-quarta-quinta-sexta';

            }
            else if (this.dayWork == 'thirSat') {
                day_work = 'terca-quarta-quinta-sexta-sabado';
            }
            else if (this.dayWork == 'satSun') {
                day_work = 'sabado-domingo';
            }
            else if (this.dayWork == 'monWedFry') {
                day_work = 'segunda-quarta-sexta'
            }
            else {
                day_work = 'terca-quinta';
            }

             return day_work.split('-');

        },
        save() {
            if (this.editIndex > -1) {
                let new_item = { initial_hour: this.editItem.initial_hour, close_hour: this.editItem.close_hour, days_work: this.convertDayInArray() }
                axios.post(`/appointments/update/${this.editItem.id}`, new_item)
                    .then((response) => {
                        this.success = true;
                        this.editDialog = false;

                        return Object.assign(this.appointmentsItem[this.editIndex], new_item);
                    })
                    .catch((response) => {
                        this.error = response;

                    });

            }
            else {
                let datas = { initial_hour: this.h_initial, close_hour: this.h_close, day_work: this.convertDayInArray() }
                axios.post(`/appointments/${this.$route.params.id}`, datas)
                    .then((response) => {
                        this.success = true;
                        return alert(response.data);
                    })
                    .catch((response) => {
                        if (response.request.status == 500) {
                            return this.error = 'Você deve preeencher todos os campos deste formulário'
                        }

                        this.error = response;
                        return;
                    })
            }
        },
        getAppointments() {
            axios.get(`/appointments/${this.$route.params.id}`)
                .then((response) => {
                    return this.appointmentsItem = response.data;
                })
                .catch((response) => {
                    this.error = response;
                    return;
                })
        },
        editAppointment(item) {
            this.editIndex = this.appointmentsItem.indexOf(item);
            this.editItem = Object.assign({}, item);
            this.editDialog = true;
        },
        deleteAppointment(item) {
            this.editIndex = this.appointmentsItem.indexOf(item);
            this.editItem = Object.assign({}, item);
            this.deleteDialog = true;
        },
        deleteItem(item) {
            axios.post(`/appointments/delete/${this.editItem.id}`)
                .then((response) => {
                    this.success = response.data;
                    this.deleteDialog = false;
                    return this.appointmentsItem.splice(this.editIndex, 1);
                })
                .catch((response) => {

                    this.error = response;
                });
        },
        getMarkedUser(item) {
            axios.get(`/service/usersMarked/${item.id}`)
                .then((response) => {
                    return this.marked_users = response.data;
                })
                .catch((response) => {
                    this.error = response;
                    return false;
                });
        },
        showMarked(item) {
            // this.markedIndex = this.marked_users.indexOf(item);
            // this.editMarked = Object.assign({}, item);
            this.getMarkedUser(item);
            this.markedDialog = true;

        },
        markedStatus(marked){
            axios.post(`/service/marked/alterStatus/${marked.id}`)
            .then((response) => {
                this.success = response.data;
               return marked.status = true;
               // return Object.assign({}, this.marked_users[marked.id], true);
            })
            .catch((response) => {
                this.error = response;
                return false;
            });
        },
        dismatchStatus(marked){
            axios.post(`/service/marked/dismatchStatus/${marked.id}`)
            .then((response) => {
                //this.marked_users.splice({}, item);
                return marked.status = false;
                return true;
            })
            .catch((response) => {
                this.error = response;
                return false;
            });
        },
        removeMarked(marked){
            axios.post(`/service/marked/remove/${marked.id}`)
            .then((response) => {
                return this.marked_users.splice(marked, 1);
            })
            .catch((response) => {
                this.error = response;
                return false;    
            });
        },
        close() {
            this.editDialog = false;
            this.deleteDialog = false;
        }

    },
    created() {
        this.getAppointments();

    }
}

</script>