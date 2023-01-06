<template>
    <v-row justify="space-around">
        <v-col cols="auto">
            <v-dialog transition="dialog-bottom-transition" max-width="600">
                <template v-slot:activator="{ props }" class="grey-lighten-2">
                    <v-btn color="white" v-bind="props" rounded elevation="12">Junte-se</v-btn>
                </template>
                <template v-slot:default="{ isActive }" v-model="dialogForm" v-if="dialogForm == true">
                    <v-card>
                        <v-toolbar class="bg-pink-accent-1 text-white dark" dark>
                            <v-toolbar-title>
                                Cadastro de usuário
                            </v-toolbar-title>
                            <template v-slot:append>
                                <v-btn icon @click="dialogForm = false">
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </template>
                        </v-toolbar>
                        <v-card-text>
                            <div class="text-h2" cols="auto">
                                <v-tabs color="pink-accent-3">
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
                                                <div>
                                                    <v-alert type="error" v-if="this.error">
                                                        {{ error }}
                                                    </v-alert>
                                                    <v-alert type="success" v-if="this.success"
                                                        @click="this.redirect()">
                                                        Cadastrado com sucesso
                                                    </v-alert>
                                                </div>
                                                <v-container>
                                                    <v-row>
                                                        <v-col cols="12" md="6">
                                                            <v-text-field v-model="name" :rules="nameRules"
                                                                :counter="100" label="Seu nome:" required>
                                                            </v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" md="6">
                                                            <v-text-field v-model="email" :rules="emailRules"
                                                                :counter="10" label="Seu E-mail"
                                                                required></v-text-field>
                                                        </v-col>
                                                    </v-row>

                                                    <v-row>
                                                        <v-col cols="12" md="6">
                                                            <v-text-field v-model="password" :rules="passwordRules"
                                                                :counter="10" type="password" label="Password" required>
                                                            </v-text-field>
                                                        </v-col>
                                                        <v-col cols="12" md="6">
                                                            <v-text-field v-model="confirmPassword"
                                                                :rules="confirmPasswordRules" :counter="10"
                                                                type="password" label="confirmPassword" required>
                                                            </v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                    <v-row>
                                                        <v-col class="text-center">
                                                            <v-btn-group>
                                                                <v-btn color="pink-accent-4" @click="validate" link>
                                                                    <v-icon>mdi-content-save-plus</v-icon>
                                                                </v-btn>
                                                                <v-btn color="pink-accent-4" @click='reset' link>
                                                                    <v-icon>mdi-backspace</v-icon>
                                                                </v-btn>
                                                                <v-btn color="pink-accent-4" link
                                                                    @click="isActive.value = false">
                                                                    <v-icon>mdi-close</v-icon>

                                                                </v-btn>
                                                            </v-btn-group>
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
                                            <v-form ref="formEmp" v-model="valid">
                                                <div>
                                                    <v-alert type="error" v-if="this.error">
                                                        {{ error }}
                                                    </v-alert>
                                                    <v-alert type="success" v-if="this.success"
                                                        @click="this.redirect()">
                                                        Cadastrado com sucesso
                                                    </v-alert>
                                                </div>
                                                <v-row>
                                                    <v-col>
                                                        <v-text-field v-model="nameEmp" label="Nome da Empresa"
                                                            :rules="ruleNameEmp" type="text"></v-text-field>
                                                    </v-col>
                                                    <v-col>
                                                        <v-text-field v-model="emailEmp" label="Email da Empresa"
                                                            :rules="ruleEmailEmp" type="email"></v-text-field>
                                                    </v-col>
                                                </v-row>

                                                <v-row>
                                                    <v-col class="d-flex">
                                                        <v-text-field v-model="passwordEmp" label="password"
                                                            :rules="rulePasswordEmp" type="password"></v-text-field>
                                                    </v-col>
                                                    <v-col>
                                                        <v-text-field v-model="confirmPasswordEmp"
                                                            label="confirmPassword" :rules="ruleConfirmPassEmp"
                                                            type="password"></v-text-field>
                                                    </v-col>
                                                </v-row>

                                                <v-row>
                                                    <v-col class="text-center">
                                                        <v-btn-group>
                                                            <v-btn class="bg-pink-accent-4" link @click="validateEmp">
                                                                <v-icon>mdi-content-save-plus</v-icon>
                                                            </v-btn>
                                                            <v-btn class="bg-pink-accent-4" link
                                                                @click="this.$refs.formEmp.reset()">
                                                                <v-icon>mdi-backspace</v-icon>
                                                            </v-btn>
                                                            <v-btn class="bg-pink-accent-4" link
                                                                @click="isActive.value = false">
                                                                <v-icon>mdi-close</v-icon>
                                                            </v-btn>
                                                        </v-btn-group>
                                                    </v-col>
                                                </v-row>
                                            </v-form>
                                        </v-card-text>
                                    </v-card>
                                </v-window>
                            </div>
                        </v-card-text>
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
        error: false,
        success: false,
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

        ],
        nameEmp: '',
        ruleNameEmp: [
            v => !!v || 'Name enterprise is required',
            v => (v && v.length <= 50) || 'Name must be last than 10 characters',
        ],
        emailEmp: '',
        ruleEmailEmp: [
            v => !!v || 'E-mail enterprise is required',
            v => /.+@.+\..+/.test(v) || 'E-mail enterprise is required',
        ],
        passwordEmp: '',
        rulePasswordEmp: [
            v => !!v || 'Password enterprise is required',
            v => (v && v.length <= 10) || 'Password must be less than 8 characters',
        ],
        confirmPasswordEmp: '',
        ruleConfirmPassEmp: [
            v => !!v || 'Confirm password is required',
            v => (v && v.length <= 10) || 'Confirm password enterprise is required',
        ],
    }),
    methods: {
        async validate() {
            const { valid } = await this.$refs.form.validate();

            if (this.password != this.confirmPassword) {
                alert('Os campos senha e confirmação de senha devem ser iguais');
                return false;
            }
            if (!valid) {

                alert('Os campos devem ser preenchidos corretamente')
                return false;
            }

            else return this.save();
        },
        async validateEmp() {
            const { valid } = await this.$refs.formEmp.validate();

            if (this.passwordEmp != this.confirmPasswordEmp) {
                alert('Os Campos senha e confirmação de senha devem ser iguais');
                return false;
            }
            if (!valid) {
                alert('Os campos devem ser preenchidos corretamente');
                return false;
            }
            else return this.saveEmp();
        },
        reset() {
            this.$refs.form.reset();
        },
        save() {
            axios.post('/create/' + this.email + '/' + this.name + '/' + this.password)
                .then((response) => {
                    //  window.location = '/dashboard';
                    //  this.dialogForm = false;
                    this.success = response.data;

                    return setTimeout(() => {
                        window.location = '/dashboard';
                        this.dialogForm = false;
                    }, 1000)
                })
                .catch((response) => {
                    this.error = response;
                    return false;
                });
        },
        saveEmp() {
            let data = {
                nameEmp: this.nameEmp,
                emailEmp: this.emailEmp,
                passwordEmp: this.passwordEmp,
                confirmPasswordEmp: this.confirmPasswordEmp,
            }
            axios.post('/enterprise/create', data)
                .then((response) => {
                    this.success = response.data;
                    return true;
                })
                .catch((response) => {
                    return this.error = response;
                });
            return this.redirect();
        },
        redirect() {
            return setTimeout(() => {
                window.location = '/dashboardEnt';
                this.dialogForm = false;
            }, 1000)
        }
    }
}
</script>