<template>
    <v-app-bar color="grey-lighten-2 text-white" name="app-bar" class="justify-center"
                image="https://picsum.photos/1920/1080?random">
                <template v-slot:image>
                    <v-img gradient="to top right, rgba(19, 84, 122, .8), rgba(128, 208, 199, .8) ">
                    </v-img>
                </template>

                <template v-slot:prepend>
                    <v-app-bar-nav-icon icon="mdi-home" to="/">
                        Home
                    </v-app-bar-nav-icon>

                </template>

                <v-app-bar-title>TiTulo</v-app-bar-title>

                <v-spacer></v-spacer>

                <v-btn icon to="/login">
                    <v-icon>mdi-magnify</v-icon>
                    Login
                </v-btn>

                <v-btn icon>
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>

                <div class="d-flex justify-center align-center w-100">
                    <v-btn @click="print('app-bar')">ContactMe</v-btn>
                </div>


            </v-app-bar>
</template>

//<script>
//    export default{
//        data: () => ({
//            layout: null,
//        }),methods: {
//        print(key) {
//            alert(JSON.stringify(this.$refs.app.getLayoutItem((key), null, 2)))
//        },
//    },
//
//    }
//</script>