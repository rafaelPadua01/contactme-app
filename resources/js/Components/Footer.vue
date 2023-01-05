<template>
    <v-footer class="bg-light-blue">
        <v-row justify="center" no-gutters>
            <template v-slot:image>
                <v-img gradient="to top right, rgba(19, 84, 122, .8), rgba(128, 208, 199, .8) ">
                </v-img>
            </template>
            <v-btn v-for="link in links" :key="link" color="white" variant="text" class="mx-2" rounded="xl">
                {{ link }}
            </v-btn>

            <v-col class="text-center mt-4" cols="12">
                {{ new Date().getFullYear() }} - <strong>Vuetify</strong>
            </v-col>
        </v-row>
    </v-footer>
</template>



<script>
export default {

    data: () => ({
        links: [
            'Home',
            'About us',
            'Team',
            'Services',
            'Blog',
            'Contact us',
        ],
    }),

}
</script>