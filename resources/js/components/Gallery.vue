<template>
    <div class="card">
        <div class="card-header">
            <p>Gallery</p>
        </div>
        <div class="card-body">
            <form ref="form">
                <label for="imgUpload">Choose a profile picture:</label>
                <input type="file" id="imgUpload" name="imgUpload" v-on:change="formSubmit" multiple accept="image/png, image/jpeg">
            </form>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: 'PostImage',
        data: () => ({
            form: {
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                image: '',
            }
        }),
        methods: {
            formSubmit(event){
                event.preventDefault();
                this.form.image = event.target.files;
                console.log(this.form.image);
                axios.post('http://127.0.0.1/post-image', this.form)
                    .then(res => {
                        // this.$router.replace({ name: 'home' });
                        console.log(res);
                    })
                    .catch(err => {
                        console.log(err);
                    })
            }
        }
    }
</script>