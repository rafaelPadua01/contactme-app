<template>
    <v-app style="margin-top: -1%">
        <v-main>
            <v-card>
                <v-container class="py-8" fluid>
                    <p><strong>Informações Pessoais:</strong></p>
                    <v-form ref="form" enctype="multipart/form-data">
                        <v-expansion-panels>
                            <v-expansion-panel>
                                <v-expansion-panel-title>Pessoal</v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-card>
                                                <v-avatar color="grey" size="150" rounded="0">
                                                    <v-img cover :src="'storage/avatars/' + profile_img.image_name">

                                                    </v-img>
                                                    <v-file-input v-model="file" accept="image/*"
                                                        prepend-icon="mdi-paperclip" v-on:change="handleFileUpload()">
                                                    </v-file-input>
                                                </v-avatar>

                                                <v-card-actions>
                                                    <v-btn color="secondary" @click="uploadImg()">upload</v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-col>
                                    </v-row>

                                    <v-divider></v-divider>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-text-field v-model="auth_user.name" label="name"
                                                :placeholder="auth_user.name" color="pink-accent-1">

                                            </v-text-field>
                                        </v-col>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-text-field v-model="profile_user.lastname" label="Sobrenome"
                                                :placeholder="profile_user.lastname" color="pink-accent-1">

                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-text-field v-model="auth_user.email" label="email"
                                                :placeholder="auth_user.email" color="pink-accent-1">
                                            </v-text-field>
                                        </v-col>

                                    </v-row>

                                    <v-row>
                                        <v-col>
                                            <p><label>Sexo: </label>{{ profile_user.sexo }}</p>
                                        </v-col>
                                        <v-col class="d-flex" cols="12" sm="6">


                                            <v-radio-group v-model="profile_user.sexo" inline>
                                                <v-radio label="Feminino" value="feminino"></v-radio>
                                                <v-radio label="Masculino" value="masculino"> </v-radio>
                                                <v-radio label="Outro" value="outro">
                                                </v-radio>
                                            </v-radio-group>
                                        </v-col>
                                    </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>
                        <v-expansion-panels>
                           
                            <v-expansion-panel>
                                <v-expansion-panel-title> 
                                    Endereço
                                </v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-select v-model="uf" :hint="`${uf.state}, ${uf.abbr}`" label="UF"
                                                prepend-icon="mdi-map-marker" color="pink-accent-1" filled
                                                :items="ufItems" item-title="state" item-value="abbr" persistent-hint
                                                return-object single-line required>

                                            </v-select>
                                        </v-col>

                                        <v-col>
                                            <v-text-field type="text" v-model="profile_user.cidade" label="Cidade"
                                                prepend-icon="mdi-map-marker" color="pink-accent-1"
                                                :placeholder="profile_user.cidade">

                                            </v-text-field>
                                        </v-col>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-text-field type="text" v-model="profile_user.bairro" label="bairro"
                                                color="pink-accent-1" :placeholder="profile_user.bairro">
                                            </v-text-field>
                                        </v-col>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-text-field type="text" v-model="profile_user.endereco" label="Endereço"
                                                prepend-icon="mdi-map-marker" color="pink-accent-1"
                                                :placeholder="profile_user.endereco">
                                            </v-text-field>
                                        </v-col>

                                    </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                        </v-expansion-panels>
                        <v-expansion-panels>
                            <v-expansion-panel>
                                <v-expansion-panel-title>Contatos</v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row>
                                        <v-col>
                                            <v-text-field type="telefone" v-model="profile_user.t_residencial"
                                                label="Telefone Residêncial" v-mask="'(##) ####-####'"
                                                color="pink-accent-1" :placeholder="profile_user.t_residencial">

                                            </v-text-field>
                                        </v-col>

                                        <v-col>
                                            <v-text-field type="telefone" v-model="profile_user.t_celular"
                                                label="celular" v-mask="'55+ (##) ####-#####'" color="pink-accent-1"
                                                required :placeholder="profile_user.t_celular">

                                            </v-text-field>

                                        </v-col>
                                    </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-row>
                                <v-col>
                                    <div>
                                        <v-btn class="mb-4" color="primary" link @click="update">Salvar</v-btn>
                                        <v-btn class="mb-4" color="error" link @click="reset">Limpar</v-btn>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-expansion-panels>
                        <v-divider></v-divider>


                    </v-form>

                    <p><strong>Informações Profissionais:</strong></p>
                    <v-form ref="formProf">
                        <v-expansion-panels>
                            <v-expansion-panel>
                                <v-expansion-panel-title>Profissão</v-expansion-panel-title>
                                <v-expansion-panel-text>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-select v-model="professional_profile.profissao" label="Profissão"
                                                :items="['Trancista', 'Manicure', 'Cabeleleira']" color="pink-accent-4">
                                            </v-select>
                                        </v-col>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-select v-model="professional_profile.tempo_experiencia"
                                                label="tempo de experiencia Ex: (1 = ano)" color="pink-accent-4"
                                                :items="['Iniciante', '1 ano', '2 anos', '3 anos', '4 anos', '+ de 5 anos']">
                                            </v-select>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col class="d-flex" cols="12" sm="6">
                                            <v-text-field v-model="professional_profile.lastjob" type="text" label="Ultimo emprego"
                                                placeholder="Entre com o nome da ultima empresa em que trabalhou"
                                                color="pink-accent-4">

                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-expansion-panel-text>
                            </v-expansion-panel>
                            <v-expansion-panel>
                                <v-row>
                                    <v-col>
                                        <v-expansion-panel-title>Epecialidades</v-expansion-panel-title>
                                        <v-expansion-panel-text>
                                            <v-row>
                                                <v-col class="d-flex" cols="12" sm="6">
                                                    <v-select  v-model="professional_profile.especialidades"
                                                        :items="['Tranças Nagô', 'Box-Braids', 'Twister-Braids', 'Pintura e decoração de unhas', 'Cortes']"
                                                        label="especialidades" color="pink-accent-4" multiple
                                                        hint="Escolha suas especialidades" persistent-hint></v-select>
                                                </v-col>
                                            </v-row>
                                            <v-row>
                                                <v-col
                                                    class="d-flex"
                                                    cols="12"
                                                    sm="6"
                                                >
                                                    <v-chip
                                                        class="ma-2"
                                                        color="pink-accent-4"
                                                        outlined
                                                        v-for="(p_pr_especialidade, index) in professional_profile.especialidades"
                                                        close
                                                        @click="removeChip(p_pr_especialidade, index)"
                                                       
                                                    >   
                                                        <v-icon left>
                                                            mdi-fire
                                                        </v-icon>
                                                        {{p_pr_especialidade}}
                                                    </v-chip>
                                                    
                                                   
                                                </v-col>
                                            </v-row>

                                            <v-row>
                                                <v-col class="d-flex" cols="12" sm="6">
                                                    <v-textarea v-model="professional_profile.descricao" label="descricao"
                                                        color="pink-accent-4"
                                                        placeholder="Descreva sobre suas experiencias..."></v-textarea>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-text>
                                    </v-col>
                                </v-row>
                            </v-expansion-panel>
                           
                        </v-expansion-panels>
                        <v-row>
                            <v-col>
                                <div>
                                    <v-btn class="mb-4" color="primary" link @click="professionalProfile()">Salvar
                                    </v-btn>
                                    <v-btn class="mb-4" color="error" link @click="resetProf">Limpar</v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-form>

                </v-container>

            </v-card>
        </v-main>
    </v-app>
</template>

<script>

import axios from 'axios';

export default {
    data: () => ({

        auth_user: '',
        profile_user: [],
        profile_img: [],
        name: '',
        lastname: '',
        email: '',
        file: [],
        uf: { state: 'Distrito Federal', abbr: 'DF' },
        ufItems: [
            { state: 'Acre', abbr: 'AC' },
            { state: 'Alagoas', abbr: 'Al' },
            { state: 'Amazonas', abbr: 'AM' },
            { state: 'Amapá', abbr: 'AP' },
            /*    
                'BA',
                'CE',
                'DF',
                'ES',
                'GO',
                'MA',
                'MG',
                'MS',
                'MT',
                'PA',
                'PB',
                'PI',
                'PR',
            */
        ],
        estado: '',
        cidade: '',
        bairro: '',
        endereco: '',
        residencial: '',
        celular: '',
        data: '',

        //profissional
        professional_profile: [],
        profissao: '',
        tempo_experiencia: '',
        especialidades: [],
        lastjob: '',
        descricao: '',
    }),
    methods: {
        user() {
            axios.get('/user')
                .then((response) => {
                    this.auth_user = response.data;
                    return this.auth_user;
                })
                .catch((response) => {
                    return 'Error: ' + response;
                })
        },
        profile() {
            axios.get('/profile')
                .then((response) => {
                    this.profile_user = response.data;
                    return this.profile_user;
                })
                .catch((response) => {
                    return 'Error :' + response;
                })
        },
        profileImg() {
            axios.get('/profileImg')
                .then((response) => {
                    this.profile_img = response.data;
                    return this.profile_img;
                })
                .catch((response) => {
                    alert('Error: ' + response);
                });
        },
        profileProfessional() {
            axios.get('/professionalProfile')
                .then((response) => {
                    this.professional_profile = response.data;
                    return this.professional_profile;
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                });
        },
        beforeMounted() {
            this.user();
        },
        handleFileUpload() {
            this.$refs.file;
        },
        uploadImg() {
            let data = { image_profile: this.file, }
            axios.post('/profileImg/upload/' + this.auth_user.id, data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
                .then((response) => {
                    this.profile_img = response.data;
                    alert('Clique "OK" para atualizar a imagem');
                    window.location = '/dashboard';
                    return this.profile_img;
                })
                .catch((response) => {
                    alert('Error : ' + response.error);
                });
        },
        update() {
            let data = {
                name: this.auth_user.name,
                lastname: this.profile_user.lastname,
                email: this.auth_user.email,
                image_profile: this.file,
                uf: this.uf,
                cidade: this.profile_user.cidade,
                bairro: this.profile_user.bairro,
                endereco: this.profile_user.endereco,
                t_residencial: this.profile_user.residencial,
                t_celular: this.profile_user.celular,
                sexo: this.profile_use,
            }
            axios.post('/createProfile/' + this.auth_user.id, data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    window.location = '/dashboard';
                    return this.profile_user = response.data;

                })
                .catch((response) => {
                    alert('error: ' + response);
                })
        },
        professionalProfile() {
            let data = {
                profissao: this.professional_profile.profissao,
                tempo_experiencia: this.professional_profile.tempo_experiencia,
                especialidades: this.professional_profile.especialidades,
                lastjob: this.professional_profile.lastjob,
                descricao: this.professional_profile.descricao,
            }

            axios.post('/professionalProfile/' + this.auth_user.id, data)
                .then((response) => {
                    //window.location = '/dashboard';
                    return this.professinonal_profile = response.data;
                })
                .catch((response) => {
                    alert('Error: ' + response);
                });
        },
        reset() {
            this.$refs.form.reset();
        },
        resetProf() {
            this.$refs.formProf.reset();
        },
        removeChip(p_pr_especialidade, index){
            this.professional_profile.especialidades.splice(index, 1);
            
        },
        logout() {
            axios.post('/logout')
                .then((response) => {
                    window.location = '/login';
                    return true;
                })
                .catch((response) => {
                    alert('Erro' + response);
                    return false;
                });
        }
    },
    created() {
        this.user();
        this.profile();
        this.profileImg();
        this.profileProfessional();
    }
}
</script>