<template>
    <v-row justify="space-around">
        <v-col cols="auto">
            <v-dialog transition="dialog-bottom-transition" max-width="600">
                <template v-slot:activator="{ props }" class="grey-lighten-2">
                    <v-btn color="white" v-bind="props" rounded elevation="12">Junte-se</v-btn>
                </template>
                <template v-slot:default="{ isActive }" v-model="dialogForm" v-if="dialogForm == true">
                    <v-card>
                        <v-toolbar class="bg-blue-lighten-1 text-white dark" dark>Cadastro de usuário</v-toolbar>
                        <v-card-text>
                            <div class="text-h2" cols="auto">
                                <v-tabs>
                                    <v-tab @click="tabCliente = true">
                                        Cliente
                                    </v-tab>
                                    <v-tab @click="tabEmpresa = true; tabCliente = false">
                                        Empresa
                                    </v-tab>
                                </v-tabs>

                                <v-window v-model="tabCliente" v-if="tabCliente">
                                    <v-card flat>
                                        <v-card-text>
                                            <v-form ref="form" v-model="valid">
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12" md="4">
                                                            <v-text-field v-model="name" :rules="nameRules"
                                                                :counter="10" label="name" required>
                                                            </v-text-field>
                                                        </v-col>
                                                      <!--  <v-col cols="12" md="4">
                                                            <v-text-field v-model="lastname" :rules="lastnameRules"
                                                                :counter="10" label="last name" required></v-text-field>
                                                        </v-col> -->
                                                        <v-col cols="12" md="4">
                                                            <v-text-field v-model="email" :rules="emailRules"
                                                                :counter="10" label="Email" required></v-text-field>
                                                        </v-col>
                                                    </v-row> 
                                                    
                                                    <v-row>
                                                        <v-col cols="12" md="4">
                                                        <v-text-field 
                                                            v-model="password"
                                                            :rules="passwordRules"
                                                            :counter="10"
                                                            type="password"
                                                            label="Password"
                                                            required>
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" md="4">
                                                        <v-text-field
                                                            v-model="confirmPassword"
                                                            :rules="confirmPasswordRules" 
                                                            :counter="10"
                                                            type="password"
                                                            label="confirmPassword" 
                                                            required>
                                                        </v-text-field>
                                                    </v-col>
                                                    </v-row>
                                                </v-container>
                                            </v-form>
                                        </v-card-text>
                                    </v-card>
                                </v-window>
                                <v-window v-model="tabEmpresa" v-if="tabEmpresa && tabCliente == false">
                                    <v-card flat>
                                        <v-card-text>
                                            Formulário de Cadastro de empresa
                                        </v-card-text>
                                    </v-card>
                                </v-window>
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn color="success" class="mr-4" @click="validate">
                                Cadastrar
                            </v-btn>
                            <v-btn color="error" class="mr-4" @click='reset'>
                                Limpar
                            </v-btn>
                            <v-btn text @click="isActive.value = false">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
        </v-col>
    </v-row>
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        dialogForm: true,
        tabCliente: true,
        tabEmpresa: false,
        name: '',
        nameRules: [
            v => !!v || 'Name is required',
            v => (v && v.length <= 50) || 'Name must be less than 10 characters',
        ],
        email: '',
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        password: '',
        passwordRules: [
            v => !!v || 'Password is required',
            v => (v && v.length <= 10) || 'Password must be less than 8 characters',
        ],
        confirmPassword: '',
        confirmPasswordRules: [
            v => !!v || 'Confirm password is required',
            v => (v && v.length <= 10) || 'Confirm password must be like password',
           
        ]
    }),
    methods: {
        async validate() {
            const { valid } = await this.$refs.form.validate();
            
            if(this.password != this.confirmPassword)
            {
                alert('Os campos senha e confirmação de senha devem ser iguais');
                return false;
            }
            if(!valid){
                alert('Os campos devem ser preenchidos corretamente')
                return false;
            }
            else return this.save();
        },
        reset() {
            this.$refs.form.reset();
        },
        save() {
            axios.post('/create/' + this.email + '/' + this.name + '/' + this.password )
            .then((response) => {
                alert(response.data);
                window.location = '/dashboard';
               this.dialogForm = false;
                return true;
            })
            .catch((response) => {
                alert('Error:' + response);
                return false;
            });
           // alert(this.email + this.password + this.confirmPassword +'Sentimos muito o Cadastro de usuario ainda não está finalizado');
        }
    }
}
</script>