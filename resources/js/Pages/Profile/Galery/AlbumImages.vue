<template>
    <v-container class="fill-height mb-6" fluid style="min-height: 450px;">
        <v-row align="start" no-gutters>
            <v-col v-for="img in images" :key="img.id">
                <v-sheet class="pa-2">
                    <v-card>
                        <v-img :lazy-src="(`/storage/galery/${img.name_galery}/${img.name_image}`)"
                            :src="(`/storage/galery/${img.name_galery}/${img.name_image}`)" max-height="500" cover
                            class="bg-grey-lighten-2">

                            <v-hover>
                                <template v-slot:default="{ isHovering, props }">
                                    <v-card-title class="text-2 bg-pink-darken-1" v-bind="props"
                                        :class="{ 'on-hover': isHovering }">
                                        <p :class="{ 'show-txt': !isHovering }"> {{ img.name_image }} </p>


                                        <v-btn-group>
                                            <v-btn color="pink-darken-1" class="mb-2" icon @click="removeImage()">
                                                <v-icon>mdi-delete-empty</v-icon>
                                            </v-btn>
                                            <v-btn color="pink-darken-1" class="mb-1" icon @click="editImage()">
                                                <v-icon>mdi-update</v-icon>

                                            </v-btn>
                                        </v-btn-group>

                                    </v-card-title>
                                </template>
                            </v-hover>
                        </v-img>

                        <v-divider></v-divider>


                    </v-card>
                </v-sheet>
            </v-col>
        </v-row>

    </v-container>

</template>

<script>
import axios from 'axios';

export default {
    data: () => ({
        images: [],
    }),
    methods: {
        getImages() {
            axios.get(`/imageGalery/selected/${this.$route.params.id}`)
                .then((response) => {
                    this.images = response.data;
                })
                .catch((response) => {
                    alert('Error: '.response);
                });
        },
        removeImage(){
            alert('Estamos Trabalhando aqui...');
        },
        editImage(){
            alert('Estamos trabalhando aqui...');
        }
    },
    created() {
        this.getImages();
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