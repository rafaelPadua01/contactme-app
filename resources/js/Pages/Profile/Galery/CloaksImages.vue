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
                    <v-card  v-if="!cloak.matriz || !cloak.sature || !cloak.sepia || !cloak.opacity">
                        <v-toolbar color="pink-accent-4" dark>
                            <v-toolbar-title class="text-h6">Usar como capa ? </v-toolbar-title>

                            <template v-slot:append>

                                <v-switch v-model="cloak.selected" hide-details inset
                                    :label="`${cloak.selected.toString()}`" v-on:change="selectedImage(cloak)">
                                </v-switch>
                            </template>

                        </v-toolbar>

                        <v-img :lazy-src="`/storage/cloak/${cloak.image_name}`" :src="`/storage/cloak/${cloak.image_name}`"
                            @click="openImage(cloak)"  :style="`filter:sepia(${cloak.sepia}%) hue-rotate(${cloak.matriz}deg) saturate(${cloak.saturate}%) opacity(${cloak.opacity}) blur(${cloak.blur})
                                                                                                            brightness(${cloak.brightness}) contrast(${cloak.contrast}) drop-shadow(${cloak.w_shadow}px ${cloak.h_shadow}px ${cloak.blur_shadow}px ${cloak.color_shadow});`">
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

                    <v-card  v-else-if="cloak.matriz || cloak.sature || cloak.sepia || cloak.opacity">
                        <v-toolbar color="pink-accent-4" dark>
                            <v-toolbar-title class="text-h6">Usar como capa ? </v-toolbar-title>

                            <template v-slot:append>

                                <v-switch v-model="cloak.selected" hide-details inset
                                    :label="`${cloak.selected.toString()}`" v-on:change="selectedImage(cloak)">
                                </v-switch>
                            </template>

                        </v-toolbar>
                        <div>
                            <v-img  :lazy-src="`/storage/cloak/${cloak.image_name}`" :src="`/storage/cloak/${cloak.image_name}`"
                            @click="openImage(cloak)" :style="`filter:sepia(${cloak.sepia}%) hue-rotate(${cloak.matriz}deg) saturate(${cloak.saturate}%) opacity(${cloak.opacity}) blur(${cloak.blur}rem)
                                                                                                            brightness(${cloak.brightness}) contrast(${cloak.contrast}%) drop-shadow(${cloak.w_shadow}px ${cloak.h_shadow}px ${cloak.blur_shadow}px ${cloak.color_shadow});`">
                            <div class="text-white">
                                {{ cloak.image_name }}
                            </div>

                        </v-img>

                        </div>
                      


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
                    <v-dialog v-model="openImageDialog">

                        <v-responsive>
                            <canvas id="myCanvas" width="500" height="500" style="display: none"></canvas>
                            <v-img :src="`/storage/cloak/${objectImg.image_name}`"
                                :style="`filter:sepia(${sepia}%) hue-rotate(${matriz}deg) saturate(${saturate}%) opacity(${opacity}) brightness(${brightness}) contrast(${contrast}%) ;`">
                                {{ h_shadow + 'px' + w_shadow + 'px' + blur_shadow + 'px' + color_shadow + 'px' }}
                                <div class="text-right">
                                    <v-btn-group color="white">
                                        <v-menu location="bottom">
                                            <template v-slot:activator="{ props }">
                                                <v-btn variant="plain" @click="openMenu(objectImg)" v-bind="props">
                                                    <v-icon>mdi-dots-vertical</v-icon>
                                                </v-btn>
                                            </template>

                                            <v-list>
                                                <v-list-item @click="editOptionsOpen">Edit Image</v-list-item>
                                            </v-list>
                                        </v-menu>
                                        <v-btn icon variant="plain" @click="closeOpenImage">
                                            <v-icon>mdi-close</v-icon>
                                        </v-btn>


                                    </v-btn-group>

                                </div>
                                <div v-if="openColorDialog" class="float-top">
                                    <v-bottom-navigation v-model="editOptionsNavigation" class="justify-center"
                                        bg-color="black" color="white"
                                        style="opacity: 0.8; margin-left: -2%; margin-bottom: 3.5rem;" height="100">
                                        <v-slider v-model="matriz" :max="300" :step="0.1" thumb-label="always" label="Matriz" hide-details
                                            class="ma-4">

                                        </v-slider>

                                        <v-slider v-model="saturate" :max="255" :step="1" label="saturate" hide-details
                                            class="ma-4">

                                        </v-slider>

                                        <v-slider v-model="sepia" :max="255" :step="1" label="sepia" hide-details
                                            class="ma-4">

                                        </v-slider>
                                        <v-slider v-model="opacity" thumb-label="always" :max="1" :min="0.6" :step="0.1"
                                            label="opacity" hide-details class="ma-4">

                                        </v-slider>
                                        <div class="text-center">
                                            <v-btn-group>

                                                <v-btn icon variant="plain" class="text-white"
                                                    @click="openColorDialog = false">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </v-btn-group>

                                        </div>
                                    </v-bottom-navigation>

                                </div>

                                <div v-if="openBrightnessDialog">
                                    <v-bottom-navigation v-model="brightnessMenu" class="justify-center" bg-color="black"
                                        color="white" size="10" height="120"
                                        style="opacity: 0.8; margin-left: -2%; margin-bottom: 9.7rem; padding: 1%">

                                        <v-slider v-model="brightness" thumb-label="always" :min="0.6" :max="2" :step="0.1"
                                            label="brightness" hide-details>
                                        </v-slider>

                                        <v-slider v-model="contrast" thumb-label="always" :min="80" :max="100"  :step="0.1"
                                            label="contrast" hide-details>
                                        </v-slider>
                                        <v-spacer></v-spacer>

                                        <div class="text-center">
                                            <v-btn-group>

                                                <v-btn icon variant="plain" class="text-white mb-4"
                                                    @click="openBrightnessDialog = false">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </v-btn-group>

                                        </div>
                                    </v-bottom-navigation>

                                </div>
                                <!--<div v-if="openEfxDialog">
                                    <v-bottom-navigation v-model="efxMenu" class="justify-center" bg-color="black"
                                        color="white" size="10" height="120"
                                        style="opacity: 0.8; margin-left: -2%; margin-bottom: 17.2rem; padding: 1%">
                                        <v-slider v-model="blur" class="ma-4" thumb-label="always" :max="0.1" :step="0"
                                            label="blur" hide-details>
                                        </v-slider>

                                        <v-spacer></v-spacer>
                                        <div class="text-center">
                                            <v-btn-group>

                                                <v-btn icon variant="plain" class="text-white mb-4"
                                                    @click="openEfxDialog = false">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </v-btn-group>

                                        </div>
                                    </v-bottom-navigation>

                                </div>
                            -->
                               <!-- <div v-if="openShadowDialog">
                                    <v-bottom-navigation v-model="shadowMenu" class="justify-center" bg-color="black"
                                        color="white" height="290"
                                        style="opacity: 0.8; margin-left: -2%; margin-bottom: 24.6rem; padding: 1%;">

                                        <v-label>Shadow</v-label>

                                        <v-slider v-model="h_shadow" class="ma-4" :max="255" :step="1" label="height"
                                            hide-details>
                                        </v-slider>

                                        <v-slider v-model="w_shadow" class="ma-4" :max="255" :step="1" label="height"
                                            hide-details>
                                        </v-slider>
                                        <v-slider v-model="blur_shadow" class="ma-4" :min="0" :max="255" :step="0"
                                            label="blur-shadow" hide-details>
                                        </v-slider>

                                        <v-color-picker hide-canvas hide-inputs show-swatches v-model="color_shadow"
                                            size="12"></v-color-picker>








                                        <v-spacer></v-spacer>
                                        <div class="text-center">
                                            <v-btn-group>

                                                <v-btn icon variant="plain" class="text-white mb-4"
                                                    @click="openEfxDialog = false">
                                                    <v-icon>mdi-close</v-icon>
                                                </v-btn>
                                            </v-btn-group>

                                        </div>
                                    </v-bottom-navigation>

                                </div> -->
                            </v-img>

                        </v-responsive>
                        <div v-if="editOptionsNavigation">

                            <v-bottom-navigation v-model="editOptionsNavigation" class="justify-center" bg-color="black"
                                color="white" size="10" style="opacity: 0.8; margin-left: -2%">
                                <v-btn value="palette" @click="openColorMenu">
                                    <v-icon>mdi-palette-outline</v-icon>
                                    color
                                </v-btn>


                                <v-btn value="brightness" @click="openBrightnessMenu">
                                    <v-icon>mdi-brightness-6</v-icon>
                                    brightness/contrast
                                </v-btn>

                                <!-- <v-btn value="efx" @click="openEfxMenu">
                                    <v-icon>mdi-blur</v-icon>
                                    efx
                                </v-btn>-->


                                <!-- <v-btn value="drop_shadow" @click="openshadowMenu">
                                    <v-icon>mdi-box-shadow</v-icon>
                                    drop-shadow
                                </v-btn> -->
                                <v-btn value="drop_shadow" @click="saveEditedFile(objectImg)">
                                    <v-icon>mdi-content-save-check</v-icon>
                                    Save
                                </v-btn>
                                <v-btn value="drop_shadow" @click="undo">
                                    <v-icon>mdi-file-undo</v-icon>
                                    undo
                                </v-btn>
                                <v-btn icon class="mb-4" variant="plain" @click="editOptionsNavigation = false">
                                    <v-icon>mdi-close</v-icon>
                                    close
                                </v-btn>

                            </v-bottom-navigation>

                        </div>
                    </v-dialog>

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
        openImageDialog: false,
        openColorDialog: false,
        openBrightnessDialog: false,
        openEfxDialog: false,
        openShadowDialog: false,
        objectImg: null,
        editImg: null,
        editMenu: false,
        editOptionsNavigation: false,
        brightnessMenu: false,
        efxMenu: false,
        shadowMenu: false,
        matriz: 0,
        saturate: 128,
        sepia: 10,
        opacity: 1,
        brightness: 0.4,
        contrast: '200%',
        blur: '0rem',
        h_shadow: 0,
        w_shadow: 0,
        blur_shadow: 0,
        spread_shadow: 0,
        color_shadow: 'red',

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
        openImage(cloak) {
            this.objectImg = Object.assign({}, cloak);
            return this.openImageDialog = true;
        },
        closeOpenImage() {
            this.openImageDialog = false;
            this.editOptionsNavigation = false;
            return this.openColorDialog = false;
            //return;
        },
        openMenu(objectImg) {
            this.editImg = Object.assign(objectImg);
            return this.editMenu = true;
        },
        editOptionsOpen() {
            return this.editOptionsNavigation = true;
        },
        openColorMenu() {
            return this.openColorDialog = true;
            //alert('Botão de cores');
        },
        closeOpenOptions() {
            this.editOptionsNavigation = false;
        },
        openBrightnessMenu() {
            this.brightnessMenu = true;
            return this.openBrightnessDialog = true;
        },
        //openEfxMenu() {
        //    this.efxMenu = true;
        //    return this.openEfxDialog = true;
        //},
        //openshadowMenu() {
        //    this.shadowMenu = true;
        //    this.openShadowDialog = true;
        //},
        saveEditedFile(objectImg) {
            const canvas = document.getElementById('myCanvas');
            const ctx = canvas.getContext('2d');
            const img = new Image();
            const filter_sepia = this.sepia;
            const filter_hue_rotate = this.matriz;
            const filter_saturate = this.saturate;
            const filter_opacity = this.opacity;
            const filter_brightness = this.brightness;
            const filter_contrast =  this.contrast;
            

            img.onload = function() {
            ctx.filter = 'sepia('+filter_sepia+'%) hue-rotate(' +filter_hue_rotate +'deg) saturate('+ filter_saturate + '%) opacity('+filter_opacity+') brightness('+filter_brightness+')  contrast('+filter_contrast+'%)';
            
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
            img.src = `/storage/cloak/${objectImg.image_name}`;
        
            const dataURL = canvas.toDataURL('image/jpeg');
          //  this.uploadFile(dataURL, objectImg);
            const link = document.createElement('a');
            link.download = 'my-image.jpg';
            link.href = dataURL;
            link.click();
        },
      //  uploadFile(dataURL, objectImg){
      //      const data = {file: dataURL};
      //      axios.post(`/cloak/saveEdited/${objectImg.id}`, data)
      //      .then((response) => {
      //           return this.cloaks.push(response.data);
      //      })
      //      .catch((response) => {
      //         return  alert('Error: ' + response);
      //      })
      //      console.log(dataURL);
      //  },
        undo() {
            return [
            this.matriz = 0,
            this.saturate = 128,
            this.sepia = 10,
            this.opacity = 1,
            this.brightness = 0.4,
            this.contrast = '0%',
            this.blur = '0rem',
            this.h_shadow = 0,
            this.w_shadow = 0,
            this.blur_shadow = 0,
            this.spread_shadow = 0,
            this.color_shadow = 'red',
            ];
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