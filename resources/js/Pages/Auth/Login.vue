<template>
    <v-parallax 
                    src="storage/images/box-braids.jpg"
                    width="100%" 
                    height="1500px"
                    max-width="100%"
                    max-height="1000" 
                    gradient="to top right, rgba(19, 84, 122, .4), rgba(128, 208, 199, .4)">
                    <v-container>
                        <v-card 
                            max-width="550"
                            max-height="600"
                            class="float-right"
                            style="margin-top: 10%"
                            elevation="12"
                        >

                            <v-form ref="form">
                                <v-toolbar class="bg-light-blue darken-4 text-white dark" >
                                    <p justify="justify-center">
                                       <strong>Selecione uma das opções de login</strong>
                                    </p>
                                </v-toolbar>
                                <hr>
                                <v-container>
                                    
                                    <v-card-text>
                                        <div cols="auto">
                                            <v-tabs>
                                                <v-tab @click="tabCliente = true">
                                                    Cliente
                                                </v-tab>
                                                <v-tab @click="tabEmpresa = true, tabCliente = false">
                                                    Empresa
                                                </v-tab>
                                            </v-tabs>
                                            <v-window v-model="tabCliente" v-if="tabCliente">
                                                <v-row>
                                                    <v-col>
                                                        <v-text-field v-model="email" :rules="emailRules" label="E-mail"
                                                            type="email" required>
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>

                                                <v-row>
                                                    <v-col>

                                                        <v-text-field 
                                                            v-model="password"
                                                            :rules="passwordRules"
                                                            :counter="8"
                                                            label="Senha"
                                                            type="password"
                                                            @keyup.enter="login"
                                                            required
                                                        >

                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>

                                                <v-row>
                                                    <v-col>
                                                        <v-btn size="x-small" color="primary" variant="plain"
                                                            class="float-right">
                                                            Esqueci a Senha
                                                        </v-btn>
                                                    </v-col>
                                                </v-row>
                                                <br>

                                                <v-row>
                                                    <v-col>
                                                        <v-card-actions class="justify-center">
                                                            <v-btn 
                                                                v-model="send"
                                                                color="success"
                                                                @click="login"
                                                                elevation="3">
                                                                Login
                                                            </v-btn>
                                                            <v-btn color="error" @click="reset" elevation="3">
                                                                Limpar
                                                            </v-btn>
                                                        </v-card-actions>
                                                    </v-col>
                                                </v-row>
                                            </v-window>

                                            <v-window v-model="tabEmpresa" v-if="tabEmpresa && tabCliente == false">
                                                Formulário de login da empresa
                                            </v-window>
                                        </div>
                                    </v-card-text>

                                </v-container>
                            </v-form>
                        </v-card>
                    </v-container>
                </v-parallax>
           
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        tabCliente: false,
        tabEmpresa: false,
        email: '',
        emailRules: [
            v => !!v || 'Email is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ],
        password: '',
        passwordRules: [
            v => !!v || 'Password is required',
            v => (v && v.length <= 10) || 'Password must be less than 8 characters',
        ],
    }),
    methods: {
        login() {
            axios.post('/login/' + this.email + '/' + this.password)
                .then((response) => {
                    window.location = '/dashboard';
                }).catch((response) => {
                    alert('Error' + response);
                });

        },
        reset() {
            this.$refs.form.reset();
        }
    }
}
</script>