<template>
    <v-container class="mb-6">
        <v-row v-if="cloaks == 0 && cloaks.selected == false">
            <v-col>
                <v-card>
                    <v-card-text class="text-center">Nenhuma imagem carregada</v-card-text>
                </v-card>
            </v-col>

        </v-row>
        <v-row v-else-if="cloaks" align="start">
            <v-col v-for="cloak in cloaks" cols="12" sm="6">
                <v-sheet>
                    <v-card>
                        <v-toolbar color="pink-accent-4" dark>
                            <v-toolbar-title class="text-h6">Usar como capa ? </v-toolbar-title>

                            <template v-slot:append>

                                <v-switch v-model="cloak.selected" hide-details inset
                                    :label="`${cloak.selected.toString()}`" v-on:change="selectedImage(cloak)">
                                </v-switch>
                            </template>

                        </v-toolbar>
                        <v-img :lazy-src="`/storage/cloak/${cloak.image_name}`" :src="`/storage/cloak/${cloak.image_name}`">
                            <div class="text-white">
                                {{ cloak.image_name }}
                            </div>

                        </v-img>

                        <v-divider></v-divider>
                        <v-spacer></v-spacer>

                        <v-card-subtitle class="text-right">{{ cloak.created_at.slice(0, 10) }} </v-card-subtitle>
                        <hr>
                        <v-card-actions class="justify-center">
                            <v-btn color="error" variant="tonal" @click="removeImage(cloak)">
                                <v-icon>mdi-delete</v-icon>
                                Remove
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-sheet>
                <div class="text-center">
                    <v-dialog v-model="remove_dialog">

                        <v-card>
                            <v-toolbar color="pink-accent-4">
                                <v-toolbar-title>Remove {{ imageItem.image_name }}</v-toolbar-title>
                                <template v-slot:append>
                                    <v-btn icon @click="remove_dialog = false">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </template>
                            </v-toolbar>

                            <v-card-text>
                                Você deseja remover permanentemente essa imagem ?
                            </v-card-text>

                            <v-card-actions>
                                <v-btn-group>
                                    <v-btn icon color="error" @click="removeConfirm">
                                        <v-icon>mdi-delete-empty</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="remove_dialog = false">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </v-btn-group>
                            </v-card-actions>
                        </v-card>


                    </v-dialog>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        cloaks: [],
        remove_dialog: false,
        imageIndex: -1,
        imageItem: '',
        selected: false,
    }),
    methods: {
        getCloaks() {
            axios.get(`/cloaks/${this.$route.params.id}`)
                .then((response) => {
                    return this.cloaks = response.data;
                })
                .catch((response) => {
                    return alert('Error :' + response);
                });
        },
        selectedImage(cloak) {
            let img_selected = { selected: cloak.selected }
            axios.post(`/cloak/selected/${cloak.id}`, img_selected)
                .then((response) => {
                    for (let i = 0; i <= this.cloaks.length; i++) {
                        if (cloak.id !== this.cloaks[i].id) {
                            this.cloaks[i].selected = false;
                        }
                    }
                    return;
                })
                .catch((response) => {
                    return false;
                });
        },
        removeImage(cloak) {
            this.imageIndex = this.cloaks.indexOf(cloak);
            this.imageItem = Object.assign({}, cloak);
            this.remove_dialog = true;

        },
        removeConfirm() {
            axios.post(`/cloak/delete/${this.imageItem.id}`)
                .then((response) => {

                    this.remove_dialog = false;
                    return this.cloaks.splice(this.imageIndex, 1);
                })
                .catch((response) => {
                    return alert('Error: ' + response);
                });
        }
    },
    created() {
        this.getCloaks();
    }
}
</script>