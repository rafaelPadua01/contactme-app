<template>
    <v-parallax src="storage/images/smille.jpeg" width="100%" height="1500px" max-height="1500"
            gradient="to top right, rgba(19, 84, 122, .4), rgba(128, 208, 199, .4) ">
            <v-row aling="left" justify="center">
                <v-col class="text-center text-white" cols="12">
                    <v-hover>
                        <template v-slot:default="{ isHovering, props }">
                            <v-card v-bind="props" :class="{ 'on-hover': isHovering }" color="#517c91">
                                <v-card-text>
                                    <h3 class="text-h3 text-white font-weight-thin mb-4"
                                        style="text-decoration: underline; margin-left: 3%">
                                        Bem Vindo ao ContactMe
                                    </h3>

                                    <h4 style="margin-left: 4%; color: white;" :class="{ 'show-txt': !isHovering }"
                                        :color="transparent">
                                        <p>Encontre Serviços de <strong>Beleza</strong> próximo a você, agende horarios,
                                            verifique disponibilidade,</p>
                                        <p>marque um local com seu prestador de serviço ou seja atendido em sua casa.
                                        </p>
                                    </h4>
                                    <div class="my-6" style="">
                                        <RegisterDialog />
                                    </div>


                                    <v-spacer></v-spacer>

                                </v-card-text>

                            </v-card>
                        </template>
                    </v-hover>
                </v-col>
            </v-row>
        </v-parallax>

   



    <Footer></Footer>
</template>

<script>
import RegisterDialog from '../Components/RegisterDialog.vue';
import Footer from '../Components/Footer.vue';

export default {
    components: {
        RegisterDialog,
        Footer,
    },
    data: () => ({
        transparent: 'rgba(255, 255, 255, 0)',
    }),
}
</script>

<style scoped>
.v-card {
    transition: opacity .4s ease-in-out;
    opacity: 0.6;
}

.v-card:not(.on-hover) {
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