<template>
    <v-flex>
        <v-parallax :src="randomImage" height="700">
            <v-layout align-center column justify-center>
                <h1 class="display-4 font-weight-thin mb-3">Real SPA</h1>
                <h4 class="headline">Real Time Single page Forum</h4>
            </v-layout>
        </v-parallax>
    </v-flex>
</template>

<script>
    export default {
        data() {
            return {
                images: [
                    'https://cdn.vuetifyjs.com/images/parallax/material.jpg',
                    'https://cdn.vuetifyjs.com/images/parallax/material2.jpg',
                    'https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg'
                ]
            }
        },
        computed: {
            randomImage() {
                return this.images[Math.floor(Math.random() * this.images.length)]
            }
        }
    }
</script>
