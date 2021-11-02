<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <p>Gallery</p>
            </div>
            <div class="gallery-body">
                <vue-dropzone
                    ref="myVueDropzone"
                    id="dropzone"
                    :options="dropzoneOptions"
                    v-on:vdropzone-files-added="onFilesAdded"
                    v-on:vdropzone-success-multiple="onUploadSuccess"
                    v-on:vdropzone-error-multiple="onUploadError"
                ></vue-dropzone>
            </div>
        </div>
        <div class="card">
            <div v-if="images.length === 0" class="gallery-body">
                <div class="title">WOW, Such Empty</div>
            </div>
            <div v-if="images.length !== 0" class="gallery">
                <div v-for="(image, index) in images" :key="index">
                    <img :src="image['url']" alt="img" v-on:click="() => removeImageHandler(index)">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from "vue";
    import axios from "axios";
    import VueCookies from 'vue-cookies';
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
    import { library } from '@fortawesome/fontawesome-svg-core'
    import { faCloudUploadAlt } from '@fortawesome/free-solid-svg-icons'

    Vue.use(VueCookies);
    library.add(faCloudUploadAlt);

    Vue.component('font-awesome-icon', FontAwesomeIcon);

    Vue.config.productionTip = false;

    export default {
        name: 'PostImage',
        components: {
            vueDropzone: vue2Dropzone,
        },
        data: () => ({
            images: [],
            num: 0,
            dropzoneOptions: {
                url: '/api/post-image',
                uploadMultiple: true,
                withCredentials: true,
                addRemoveLinks: true,
                useFontAwesome: true,
                dictDefaultMessage: "<i class='fa fa-cloud-upload fa-5x'></i><br> Drop files here or click to choose files ...",
                headers: {
                    'X-XSRF-TOKEN': $cookies.get("XSRF-TOKEN"),
                },
            },
        }),
        mounted(){
            axios.get('/api/get-image')
                .then(res => {
                    // this.$router.replace({ name: 'home' });
                    // this.$images = res.data.map(image => {
                    //     return <div>{{ image }}</div>
                    // })
                    res.data.map(elm => this.images.push(elm));
                })
                .catch(err => {
                    console.log(err);
                })
        },
        methods: {
            onFilesAdded(files) {
                this.num = files.length;
            },
            onUploadSuccess(files, response) {
                // error when upload error files with validated files
                // this.$refs.myVueDropzone.removeAllFiles();
                this.imageRetrieveHandler();
            },
            onUploadError(files, message, xhr) {
                //
            },
            imageRetrieveHandler() {
                axios.get("/api/update-image/" + this.num)
                    .then(res => {
                        res.data.map(elm => this.images.push(elm));
                    })
                    .catch(err => {
                        console.log(err);
                    })
            },
            removeImageHandler(index) {
                axios.post('/api/remove-image', {path: this.images[index]['url']})
                    .then(res => {
                        this.images.splice(index, 1);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>