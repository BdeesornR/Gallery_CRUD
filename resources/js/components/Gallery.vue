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
                    @vdropzone-processing="dropzoneChangeUrl"
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
                <div v-for="(imageSrc, index) in images" :key="index">
                    <img
                        :src="imageSrc"
                        alt="img"
                        v-on:click="() => removeImageHandler(index)"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    name: "PostImage",
    components: {
        vueDropzone: vue2Dropzone,
    },
    data: () => ({
        images: [],
        amount: 0,
        modalToggle: false,
        dropzoneOptions: {
            url: "url",
            uploadMultiple: true,
            withCredentials: true,
            addRemoveLinks: true,
            useFontAwesome: true,
            dictDefaultMessage:
                "<i class='fa fa-cloud-upload fa-5x'></i><br> Drop files here or click to choose files ...",
            headers: {
                "X-XSRF-TOKEN": $cookies.get("XSRF-TOKEN"),
            },
        },
    }),
    mounted() {
        axios
            .get("/api/" + this.$store.state.userId + "/get-image")
            .then((res) => {
                res.data.map((elm) => this.images.push(elm));
            })
            .catch((err) => {
                console.log(err);
            });
    },
    methods: {
        dropzoneChangeUrl() {
            this.$refs.myVueDropzone.setOption(
                "url",
                "api/" + this.$store.state.userId + "/post-image"
            );
        },
        onFilesAdded(files) {
            this.num = files.length;
        },
        onUploadSuccess(files, response) {
            this.amount = files.length;
            this.imageRetrieveHandler();
        },
        onUploadError(files, message, xhr) {
            console.log(files, message, xhr);
        },
        imageRetrieveHandler() {
            axios
                .get(
                    "/api/" +
                        this.$store.state.userId +
                        "/update-image/" +
                        this.amount
                )
                .then((res) => {
                    console.log(res);
                    res.data.map((elm) => this.images.push(elm));
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        removeImageHandler(index) {
            axios
                .post("/api/" + this.$store.state.userId + "/remove-image", {
                    path: this.images[index],
                })
                .then((res) => {
                    this.images.splice(index, 1);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
};
</script>
