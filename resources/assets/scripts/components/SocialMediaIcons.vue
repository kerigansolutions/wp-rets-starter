<template>
        <div>
            <a 
                v-for="(icon) in socialData"
                :key="icon.index" 
                v-html="icon['icon']" 
                :href="icon['link']"
                :style="'width:' + size + 'px; margin:' + margin + 'rem;'"
                target="_blank"
            ></a>
        </div>
</template>

<script>
    export default {
        props: {
            size: {
                type: Number,
                default: 30
            },
            margin: {
                type: Number,
                default: 0
            }
        },

        data() {
            return {
                socialData: []
            }
        },

        mounted () {
            http.get("/wp-json/kerigansolutions/v1/social-links/")
                .then(response => {
                    this.socialData = response.data; 
                });
        }
    }
</script>