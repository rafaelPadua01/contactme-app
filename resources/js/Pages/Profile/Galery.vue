<template>
    <v-container>
        <v-card>
            <v-tabs bg-color="pink-accent-3" centered stacked>
                <v-tab @click="(tabUpload = true)">
                    <v-icon>mdi-phone</v-icon>
                    Upload Images e videos
                </v-tab>
                <v-tab @click="(tabAlbuns = true, tabUpload = false, tabMidias = false)">
                    <v-icon>mdi-heart</v-icon>
                    albuns
                </v-tab>
                <v-tab @click="this.getMidias();">
                    <v-icon>
                        mdi-account-box
                    </v-icon>
                    midias
                </v-tab>
            </v-tabs>

            <v-window v-model="tabUpload" v-if="tabUpload">

                <v-card>
                    <v-card-title>Galeria</v-card-title>
                    <v-card-text>
                        <v-form ref="form">
                            Faça upload de imagens e videos e matenha seu perfil sempre atualizado
                            <v-text-field v-model="galery_name" type="text" color="pink-accent-3"
                                placeholder="Name of Galery" label="Name of Galery:" required>
                            </v-text-field>
                            <v-file-input v-model="files" color="pink-accent-4" label="files"
                                placeholder="Load Files here" multiple chips counter variant="outlined"
                                :show-size="1000" v-on:change="handleFiles()">
                                <template v-slot:selection="{ fileNames }">
                                    <template v-for="(fileName, index) in fileNames" :key="fileName">
                                        <v-chip v-if="(index < 2)" color="pink-accent-4" label size="small"
                                            class="mr-2">
                                            {{ fileName }}
                                        </v-chip>

                                        <span v-else-if="(index === 2)" class="text-over text-white-darken-3 mx-2">
                                            + {{ (files.length - 2) }} file(s)
                                        </span>
                                    </template>
                                </template>
                            </v-file-input>
                        </v-form>
                    </v-card-text>

                    <v-divider></v-divider>
                    <v-spacer></v-spacer>
                    <v-card-actions>
                        <v-btn color="primary" class="mb-4" @click="save()">
                            Save
                        </v-btn>
                        <v-btn color="error" class="mb-4" @click="reset()">
                            Reset
                        </v-btn>
                    </v-card-actions>
                </v-card>

            </v-window>

            <v-window v-model="tabAlbuns" v-if="(tabAlbuns && tabUpload == false && tabMidias == false)">
                <v-container class="mb-6">
                    <v-row align="start" no-gutters>
                        <v-col v-for="album in albuns" :key="album.id">
                            <v-sheet class="pa-2">
                                <v-card>
                                    <v-toolbar color="pink-accent-3" dark>
                                        <v-toolbar-title>{{ album.name_galery }}</v-toolbar-title>
                                        <v-menu>
                                            <template v-slot:activator="{ props }">
                                                <v-btn icon v-bind="props"><v-icon>mdi-dots-vertical</v-icon></v-btn>
                                            </template>

                                            <v-list>
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

                                    <v-card-subtitle>
                                        {{ album.created_at }}
                                    </v-card-subtitle>

                                    <v-card-text>
                                        <v-btn class="mb-4" :to="`/galery/selected/${album.id}`" color="pink-accent-3">
                                            <v-icon>mdi-phone</v-icon>
                                        </v-btn>

                                    </v-card-text>

                                <!--    <v-card-actions>
                                        <v-btn class="mb-4" color="error" @click="deleteAlbum(album)">Remover</v-btn>
                                    </v-card-actions> -->
                                </v-card>
                                <div class="text-center">
                                    <v-dialog v-model="editAlbumDialog" max-width="750">
                                        <v-card>
                                            <v-toolbar dark color="pink-accent-3">
                                                <v-btn @click="editAlbumDialog = false">
                                                    <v-icon append>mdi-close</v-icon>
                                                </v-btn>
                                                <v-toolbar-title>Rename {{albumItem.name_galery}} </v-toolbar-title>
                                            </v-toolbar>
                                            <v-card-text>
                                            <v-form ref="form">
                                                <v-text-field
                                                    label="New Name"
                                                    type="text"
                                                    v-model="rename"
                                                    :placeholder="albumItem.name_galery"
                                                >
                                                    
                                                </v-text-field>
                                             <b> Nome antigo: {{albumItem.name_galery}}</b> - Novo Nome:   {{rename}}
                                            </v-form>

                                          </v-card-text>

                                          <v-card-actions>
                                            <v-btn color="success" @click="renameAlbum">Rename</v-btn>
                                            <v-btn color="error" @click="editAlbumDialog = false">Close</v-btn>
                                          </v-card-actions>
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
                                                Você tem <i>certeza</i> que deseja <b> remover</b> permanentemente essa
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
                                    <v-toolbar color="pink-accent-3">
                                        <v-toolbar-title>Capas</v-toolbar-title>
                                    </v-toolbar>

                                    <v-card-title></v-card-title>
                                    <v-card-text>
                                        <v-btn icon color="pink-accent-3" :to="`/cloaks/${this.$route.params.id}`">
                                            <v-icon>mdi-phone</v-icon>
                                        </v-btn>
                                    </v-card-text>
                                </v-card>
                            </v-sheet>
                        </v-col>
                    </v-row>
                </v-container>


            </v-window>

            <v-window v-model="tabMidias" v-if="(tabMidias == true && tabUpload == false && tabAlbuns == false)">
                <v-container class="fill-height mb-6" fluid>
                    <v-row align="start" no-gutters>
                        <v-col v-for="midia in midias" :key="midia.id">
                            <v-sheet class="pa-2">
                                <v-card>
                                   
                                    <v-img :src="`/storage/galery/${midia.name_galery}/${midia.name_image}`"
                                        :alt="`/storage/galery/${midia.name_galery}/${midia.name_image}`" cover
                                        max-heigth="500" class="bg-grey-lighten-2">

                                        <v-hover>
                                            <template v-slot:default="{ isHovering, props }">
                                                <v-card-title class="text-2 bg-pink-darken-1" v-bind="props"
                                                    :class="{ 'on-hover': isHovering }">
                                                    <p :class="{ 'show-txt': !isHovering }">
                                                        {{ midia.name_image }}
                                                    </p>
                                                    <v-btn-group>
                                                        <v-btn class="mb-4" color="pink-darken-1" icon
                                                            @click="deleteImage(midia)">
                                                            <v-icon>mdi-delete-empty</v-icon>

                                                        </v-btn>
                                                    </v-btn-group>
                                                </v-card-title>
                                            </template>

                                        </v-hover>
                                    </v-img>
                                </v-card>
                                <div class="text-center">
                                    
                                    <v-dialog v-model="deleteDialog" max-width="750">

                                        <v-card>
                                            <v-toolbar dark color="pink-accent-4">
                                                <v-btn @click="(deleteDialog = false)">
                                                    <v-icon append>mdi-close</v-icon>
                                                </v-btn>
                                                <v-toolbar-title>Remove {{
                                                        editedItem.name_image
                                                }}</v-toolbar-title>
                                            </v-toolbar>
                                            <v-card-title></v-card-title>

                                            <v-card-text>
                                                Você tem <i>certeza</i> que deseja <b> remover</b> permanentemente essa
                                                imagem ?
                                            </v-card-text>

                                            <v-card-actions>
                                                <v-btn color="pink-accent-4" icon block @click="removeImage">
                                                    <v-icon>mdi-delete</v-icon>
                                                </v-btn>

                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </div>

                            </v-sheet>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window>
        </v-card>

    </v-container>

</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        files: [],
        galery_name: '',
        data: [],
        albuns: [],
        midias: [],
        cloaks: [],
        tabUpload: false,
        tabAlbuns: false,
        tabMidias: false,
        deleteAlbumDialog: false,
        deleteDialog: false,
        editAlbumDialog: false,
        editDialog: false,
        rename: [],
        text: 'qualquer coisa por aqui'
    }),
    methods: {
        handleFiles() {
            this.$refs.files[0];
        },
        save() {
            let datas = { files: this.files, galery_name: this.galery_name };

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
                    return this.albuns.push(response.data);
                })
                .catch((response) => {
                    alert('Error ' + response);
                });
        },
        getMidias() {
            axios.get(`/imageGalery/selectedAll/${this.$route.params.id}`)
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
        getCloaks(){
            axios.get('/cloak')
            .then((response) => {
                this.cloaks = response.data;
                return this.cloaks;
            })
            .catch((response) => {
                return alert('Error: ' + response);
            })
        },
        editAlbum(album){
            this.albumIndex = this.albuns.indexOf(album);
            this.albumItem = Object.assign({}, album);
            this.editAlbumDialog = true;
        },
        deleteAlbum(album) {
            this.albumIndex = this.albuns.indexOf(album);
            this.albumItem = Object.assign({}, album);
            this.deleteAlbumDialog = true;
        },
        renameAlbum(){
            let data = {rename: this.rename};
            axios.post(`/galery/edit/${this.albumItem.id}`, data)
            .then((response) => {
                this.editAlbumDialog = false;
                Object.assign(this.albuns[this.albumIndex], this.albumItem);
                window.location = '/dashboard';
                
            })
            .catch((response) => {
                return alert('Error: ' . response);
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
        //this.getMidias();
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