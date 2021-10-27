<template>
    <p>Home</p>
</template>

<script>
import axios from "axios";

export default {
    name: 'GetData',
    data: () => ({
            totalSize: 0,
            numFiles: 0,
            filesComposition: [],
    }),
    mounted() {
        axios.get('http://127.0.0.1/get-data')
            .then(res => {
                // this.$router.replace({ name: 'home' });
                console.log(res);
            })
            .catch(err => {
                console.log(err);
            })
    }
}
</script>
