<template>
    <v-parallax src="storage/images/box-braids.jpg" width="100%" height="900px" max-width="100%" max-height="900"
        style="margin-top: -25px;">
        <v-container>

            <v-card class="float-right" style="margin-top: 10%" elevation="12" draggable>

                <v-toolbar class="bg-pink-accent-3 darken-4 text-white dark">
                    <v-toolbar-title>
                        Selecione uma das opções de login
                    </v-toolbar-title>

                </v-toolbar>
               
                <v-card-text>
                   
                        <v-tabs class="bg-pink-accent-1" color="pink-accent-4">
                            <v-tab @click="tabCliente = true">
                                Cliente
                            </v-tab>
                            <v-tab @click="tabEmpresa = true, tabCliente = false">
                                Empresa
                            </v-tab>
                        </v-tabs>
                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-window v-model="tabCliente" v-if="tabCliente">
                            <v-form ref="form">
                            <div>
                                <v-alert v-if="error" @click="this.error = false" type="error" color="pink-accent-2">
                                    {{ error }}
                                    
                                </v-alert>
                            </div>
                            <v-row>
                                <v-col>
                                    <v-text-field v-model="email" :rules="emailRules" label="E-mail" type="email"
                                        required>
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col>
                                    <v-text-field v-model="password" :rules="passwordRules" :counter="8" label="Senha"
                                        type="password" @keyup.enter="login" required>
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col>
                                    <v-btn size="x-small" color="pink-accent-4" variant="plain"
                                        class="float-right bg-pink-lighten-3">
                                        Esqueci a Senha
                                    </v-btn>
                                </v-col>
                            </v-row>
                            <br>

                            <v-row>
                                <v-col class="text-center">
                                    <v-btn-group>
                                        <v-btn v-model="send" color="pink-accent-4" @click="login" elevation="3" link>
                                            <v-icon>mdi-login</v-icon>
                                    
                                        </v-btn>
                                        <v-btn color="pink-accent-4" @click="reset" elevation="3" link>
                                            <v-icon>mdi-backspace</v-icon>
                                    
                                        </v-btn>
                                    </v-btn-group>
                                </v-col>
                            </v-row>
                            </v-form>
                        </v-window>

                        <v-window v-model="tabEmpresa" v-if="tabEmpresa && tabCliente == false">
                            <v-spacer></v-spacer>
                           <v-form ref="formEmp">
                                <div>
                                  
                                </div>
                                <v-row>
                                    <v-col>
                                        <v-text-field
                                            v-model="email"
                                            label="Email da Empresa"
                                            :rules="ruleEmailEmp"
                                            type="text"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col>
                                        <v-text-field
                                            v-model="password"
                                            label="Senha da Empresa"
                                            :rules="rulePasswordEmp"
                                            type="password"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col>
                                        <v-btn size="x-small" color="pink-accent-4" variant="plain" class="float-right bg-pink-lighten-3">
                                            Esqueci a Senha
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col class="text-center">
                                        <v-btn-group color="pink-accent-4">
                                            <v-btn link @click="login">Login</v-btn>
                                            <v-btn link @click="resetEmp">Reset</v-btn>
                                        </v-btn-group>
                                    </v-col>
                                </v-row>
                           </v-form>
                        </v-window>
                </v-card-text>
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
        error: false,
    }),
    methods: {
        login() {
            let data = { email: this.email, password: this.password }
            if (!this.email || !this.password) {
                alert('preencha todos os campos');
                return;
            }
            axios.post('/login', data)
                .then((response) => {
                    if (response.data == "Usuario n\u00e3o encontrado") {
                        this.error = response.data;
                        return false;
                    }
                    console.log(response.data.type);
                    if(response.data.type == 'default')
                    {
                        console.log(response.data.type);
                        window.location = '/dashboard';
                        return;
                    }
                    if(response.data.type == 'enterprise'){
                         window.location = '/dashboardEnt';
                         return;
                    }
                   
                  
                })
                .catch((response) => {
                    this.error = response;
                    alert('Error' + response);
                });
        },
        reset() {
            this.$refs.form.reset();
        },
        resetEmp(){
            this.$refs.formEmp.reset();
        }
    }
}
</script>