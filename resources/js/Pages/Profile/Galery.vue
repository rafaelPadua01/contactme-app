<template>
    <v-container>
        <v-sheet>
          
            
            <v-card>
                <v-toolbar color="pink-accent-4">
                <v-toolbar-title >
                    Faça upload de imagens e videos e matenha seu perfil sempre atualizado
                </v-toolbar-title>
            </v-toolbar>
                <v-tabs bg-color="pink-accent-4" centered stacked grow>
                    <v-tab @click="(tabUpload = true)">
                        <v-icon>mdi-phone</v-icon>
                        Upload Images e videos
                    </v-tab>
                    <v-tab @click="(tabAlbuns = true, tabUpload = false, tabMidias = false)">
                        <v-icon>mdi-heart</v-icon>
                        albuns
                    </v-tab>
                </v-tabs>

                <v-window v-model="tabUpload" v-if="tabUpload">
                    <v-card>
                        <v-card-title>Galeria</v-card-title>
                        <v-card-text>
                            <v-form ref="form" v-model="valid" lazy-validation>
                                <v-row class="justify-center">
                                    <v-col class="d-flex" cols="12" sm="12">
                                        <v-text-field v-model="galery_name" type="text" placeholder="Name of Galery"
                                            label="Name of Galery:" required variant="solo" elevation="30" :rules="galeryNameRules">
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="12">
                                        <v-file-input v-model="files" color="pink-accent-4" label="files"
                                            placeholder="Load Files here" multiple counter variant="solo" elevation="20"
                                            :show-size="1000" show-size="1000" v-on:change="handleFiles()">
                                            <template v-slot:selection="{ fileNames }">

                                                <template v-for="(fileName, index) in fileNames" :key="fileName">
                                                    <v-chip v-if="(index < 2)" color="pink-accent-4" label size="small"
                                                        class="mr-2" append-inner-icon="mdi-fire">

                                                        <v-icon>mdi-fire</v-icon>
                                                        {{ fileName }}

                                                    </v-chip>

                                                    <span v-else-if="(index === 2)"
                                                        class="text-over text-white-darken-3 mx-2">
                                                        + {{ (files.length - 2) }} file(s)
                                                    </span>


                                                </template>
                                            </template>
                                        </v-file-input>
                                    </v-col>
                                </v-row>



                                <v-textarea v-model="galery_desc"
                                    label="fale sobre os trabalhos e passos para a conclusão do mesmo."
                                    class="primary" color="pink-accent-4" variant="solo" 
                                    elevation="10"
                                >
                                    <template v-slot:prepend-inner>
                                        <v-icon color="pink-lighten-1">mdi-comment</v-icon>
                                    </template>
                                </v-textarea>
                            </v-form>
                        </v-card-text>

                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-card-actions class="justify-center">
                            <v-btn-group>
                                <v-btn color="pink-accent-4" class="mb-4" @click="validate" variant="tonal">
                                    Save
                                </v-btn>
                                <v-btn color="pink-accent-4" class="mb-4" @click="reset()" variant="tonal">
                                    Reset
                                </v-btn>
                            </v-btn-group>

                        </v-card-actions>
                    </v-card>

                </v-window>

                <v-window v-model="tabAlbuns" v-if="(tabAlbuns && tabUpload == false && tabMidias == false)">
                    <v-container class="mb-6">
                        <v-row align="start" no-gutters>
                            <v-col v-for="album in albuns" :key="album.id">
                                <v-sheet class="pa-2">
                                    <v-card>
                                        <v-toolbar color="pink-accent-4" dark>
                                            <v-toolbar-title>{{ album.name_galery }}</v-toolbar-title>
                                            <v-menu>
                                                <template v-slot:activator="{ props }">
                                                    <v-btn v-bind="props">
                                                        <v-icon>mdi-dots-vertical</v-icon>
                                                    </v-btn>
                                                </template>

                                                <v-list v-bind="props">
                                                    <v-list-item>
                                                        <v-list-item-title @click="editAlbum(album)">
                                                            <v-icon>mdi-rename-box</v-icon>
                                                            Renomear
                                                        </v-list-item-title>
                                                        <v-list-item-title @click="deleteAlbum(album)">
                                                            <v-icon>mdi-delete-empty</v-icon>
                                                            Delete
                                                        </v-list-item-title>
                                                    </v-list-item>
                                                </v-list>
                                            </v-menu>

                                        </v-toolbar>
                                        <v-card-title>{{ album.name_galery }}</v-card-title>
                                        <v-divider></v-divider>
                                        <v-spacer></v-spacer>
                                        <v-card-text>
                                            <v-row>
                                                <v-col v-for="img in midias" :key="img.id" class="d-flex child-flex"
                                                    cols="4">
                                                    <v-img :src="`/storage/galery/${album.name_galery}/${img.name_image}`"
                                                        :lazy-src="`/storage/galery/${album.name_galery}/${img.name_image}`"
                                                        :alt="`${img.name_image}`" @click="dialogOpenImage(img)">
                                                    </v-img>

                                                </v-col>
                                            </v-row>
                                        </v-card-text>
                                        <v-card-actions class="justify-center">
                                            <v-btn class="mb-4" color="error" :to="`/galery/selected/${album.id}`">
                                                <v-icon>mdi-eye</v-icon>
                                                Ver
                                                tudo</v-btn>
                                        </v-card-actions>
                                        <v-card-text class="text-h6 text-white"
                                            style="background-color: #000; opacity: 0.9;">
                                            <div>
                                                <p>{{ album.description }}</p>
                                            </div>
                                            <hr>
                                            <div class="text-right">
                                                {{ album.created_at.slice(0, 10) }}
                                            </div>

                                        </v-card-text>

                                        <v-divider></v-divider>
                                        <v-spacer></v-spacer>


                                    </v-card>


                                    <div class="text-center">
                                        <v-dialog v-model="editAlbumDialog" max-width="750">
                                            <v-card>
                                                <v-toolbar dark color="pink-accent-4">
                                                    <v-btn @click="editAlbumDialog = false">
                                                        <v-icon append>mdi-close</v-icon>
                                                    </v-btn>
                                                    <v-toolbar-title>Rename {{ albumItem.name_galery }} </v-toolbar-title>
                                                </v-toolbar>
                                                <v-card-text>
                                                    <v-form ref="form">
                                                        <v-text-field label="New Name" type="text" v-model="rename"
                                                            :placeholder="albumItem.name_galery">

                                                        </v-text-field>
                                                        <b> Nome antigo: {{ albumItem.name_galery }}</b> - Novo Nome:
                                                        {{ rename }}
                                                    </v-form>

                                                </v-card-text>

                                                <v-card-actions>
                                                    <v-btn color="success" @click="renameAlbum">Rename</v-btn>
                                                    <v-btn color="error" @click="editAlbumDialog = false">Close</v-btn>
                                                </v-card-actions>
                                            </v-card>


                                        </v-dialog>

                                        <v-dialog v-model="OpenImage">

                                            <v-card>
                                                <v-img
                                                    :src="`/storage/galery/${album.name_galery}/${this.selectedImg.name_image}`"
                                                    :lazy-src="`/storage/galery/${album.name_galery}/${this.selectedImg.name_image}`"
                                                    :alt="`${this.selectedImg.name_image}`">

                                                    <div class="text-white text-right">
                                                        <v-btn icon variant="plain" @click="OpenImage = false">
                                                            <v-icon>mdi-close</v-icon>
                                                        </v-btn>

                                                    </div>
                                                </v-img>
                                            </v-card>
                                        </v-dialog>

                                    </div>

                                    <v-card v-if="tabMidias == true">
                                        <v-card-text>
                                            {{ album }}
                                        </v-card-text>
                                    </v-card>
                                    <div class="text-center">
                                        <v-dialog v-model="deleteAlbumDialog" max-width="750">
                                            <v-card>
                                                <v-toolbar dark color="pink-accent-4">
                                                    <v-btn @click="(deleteAlbumDialog = false)">
                                                        <v-icon append>mdi-close</v-icon>
                                                    </v-btn>
                                                    <v-toolbar-title>Remove {{
                                                        albumItem.name_galery
                                                    }}</v-toolbar-title>
                                                </v-toolbar>
                                                <v-card-title></v-card-title>

                                                <v-card-text>
                                                    Você tem <i>certeza</i> que deseja <b> remover</b> permanentemente
                                                    essa
                                                    Galeria ?
                                                </v-card-text>

                                                <v-card-actions>
                                                    <v-btn color="pink-accent-4" icon block @click="removeAlbum">
                                                        <v-icon>mdi-delete</v-icon>
                                                    </v-btn>

                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                    </div>
                                </v-sheet>
                            </v-col>

                            <v-col v-if="cloaks">
                                <v-sheet>
                                    <v-card>
                                        <v-toolbar color="pink-accent-4">
                                            <v-toolbar-title>Capas</v-toolbar-title>
                                        </v-toolbar>

                                        <v-card-title></v-card-title>
                                        <v-card-text>
                                            <v-row>
                                                <v-col v-for="cloak in cloaks" :key="cloak.id" class="d-flex child-flex"
                                                    cols="4">
                                                    <v-img :lazy-src="`/storage/cloak/${cloak.image_name}`"
                                                        :src="`/storage/cloak/${cloak.image_name}`" :alt="cloak.image_name"
                                                        @click="openCloakDialog(cloak)"></v-img>
                                                </v-col>
                                            </v-row>

                                        </v-card-text>

                                        <v-card-actions class="justify-center">
                                            <v-btn class="mb-4" icon color="error" :to="`/cloaks/${this.$route.params.id}`">
                                                <v-icon>mdi-eye</v-icon>
                                                ver tudo
                                            </v-btn>
                                        </v-card-actions>
                                    </v-card>
                                    <div class="text-center">
                                        <v-dialog v-model="openCloak">

                                            <v-img :lazy-src="`/storage/cloak/${this.selectedCloak.image_name}`"
                                                :src="`/storage/cloak/${this.selectedCloak.image_name}`"
                                                :alt="this.selectedCloak.image_name">

                                                <div class="text-white text-right">
                                                    <v-btn class="mb-4" icon variant="plain" @click="openCloak = false">
                                                        <v-icon>mdi-close</v-icon>
                                                    </v-btn>
                                                </div>
                                            </v-img>
                                        </v-dialog>
                                    </div>
                                </v-sheet>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-window>
            </v-card>
        </v-sheet>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        valid: false,
        files: [],
        galery_name: '',
        galeryNameRules: [
            v => !!v || 'Name galery is required',
            v => (v && v.length < 10) || 'Name galery is required',
        ],
        galery_desc: '',
        data: [],
        albuns: [],
        midias: [],
        cloaks: [],
        tabUpload: false,
        tabAlbuns: false,
        tabMidias: false,
        OpenImage: false,
        selectedImg: false,
        selectedCloak: false,
        openCloak: false,
        deleteAlbumDialog: false,
        deleteDialog: false,
        editAlbumDialog: false,
        editDialog: false,
        rename: [],
        text: 'qualquer coisa por aqui'
    }),
    methods: {
        handleFiles() {
            this.$refs.files;
        },
        async validate() {
            const { valid } = await this.$refs.form.validate();
            if (valid) return this.save();
        },
        save() {
            let datas = { files: this.files, galery_name: this.galery_name, description: this.galery_desc };
            
            axios.post(`/galery/create/${this.$route.params.id}`, datas, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then((response) => {
                    //this.data = response.data;
                    this.tabMidias = false;
                    this.tabAlbuns = true;
                    this.tabUpload = false
                    this.getAlbuns();
                    return this.albuns.push(response.data);
                })
                .catch((response) => {
                    alert('Error ' + response);
                });
        },
        getAlbuns() {
            axios.get(`/galery/${this.$route.params.id}`)
                .then((response) => {
                    this.albuns = response.data;
                    //return this.albuns.push(response.data);
                })
                .catch((response) => {
                    alert('Error ' + response);
                });
        },
        getMidias() {
            axios.get(`/imageGalery/selected/${this.$route.params.id}`)
                .then((response) => {
                    this.tabMidias = true;
                    this.tabAlbuns = false;
                    this.tabUpload = false
                    this.midias = response.data;
                    return this.midias;
                    //this.midias.push(response.data);
                })
                .catch((response) => {
                    alert('Error: ' + response);
                })
        },
        getCloaks() {
            axios.get('/cloak')
                .then((response) => {
                    this.cloaks = response.data;
                   return this.cloaks;
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                });
        },
        dialogOpenImage(img) {
            this.OpenImage = true;
            this.selectedImg = Object.assign({}, img);
            return this.selectedImg;

        },
        openCloakDialog(cloak) {
            this.openCloak = true;
            this.selectedCloak = Object.assign({}, cloak);
            return this.selectedCloak;
        },
        editAlbum(album) {
            this.albumIndex = this.albuns.indexOf(album);
            this.albumItem = Object.assign({}, album);
            this.editAlbumDialog = true;
        },
        deleteAlbum(album) {
            this.albumIndex = this.albuns.indexOf(album);
            this.albumItem = Object.assign({}, album);
            this.deleteAlbumDialog = true;
        },
        renameAlbum() {
            let data = { rename: this.rename };
            axios.post(`/galery/edit/${this.albumItem.id}`, data)
                .then((response) => {
                    this.editAlbumDialog = false;
                    return this.albuns.push(response.data);

                })
                .catch((response) => {
                    return alert('Error: '.response);
                });

        },
        removeAlbum() {
            axios.post(`/galery/delete/${this.albumItem.id}`)
                .then((response) => {
                    this.albuns.splice(this.albumIndex, 1);
                    for (const element of response.data) {
                        this.midias.splice(element, 1);
                    }
                    this.deleteAlbumDialog = false;
                    this.$forceUpdate();
                })
                .catch((response) => {
                    alert('Error :' + response);
                })
        },
        deleteImage(midia) {
            this.editedIndex = this.midias.indexOf(midia);
            this.editedItem = Object.assign({}, midia);
            this.deleteDialog = true;
        },
        removeImage() {
            axios.post(`/imageGalery/delete/${this.editedItem.id}`)
                .then((response) => {
                    this.midias.splice(this.editedIndex, 1);
                    this.deleteDialog = false;
                })
                .catch((response) => {
                    alert('Error: ' + response);
                });


        },
        reset() {
            this.$refs.form.reset();
            this.$refs.files[0].reset();
        }
    },
    created() {
        this.getAlbuns();
        this.getCloaks();
        this.getMidias();
    }
}
</script>

<style scoped>
.v-card-title {
    opacity: 0.7;
}

.v-card-title:not(.on-hover) {
    opacity: 0.0;
}

.v-hover {
    opacity: 0.0;
    background-color: #000;

}

.show-txt {
    color: rgba(255, 255, 255, 1) !important;
}
</style>