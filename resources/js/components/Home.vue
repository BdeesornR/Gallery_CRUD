<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Disk Usage Overview
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="title">Total Size:</div>
                    <div>0.00MB (0B)</div>
                </div>
                <div class="row">
                    <div class="title">No. of Files:</div>
                    <div>0</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Disk Usage Compositions
            </div>
            <div class="card-body">
                {{ true === false ? 'Have Data' : 'No Data' }}
            </div>
        </div>
    </div>
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
        axios.get('/api/get-data')
            .then(res => {
                console.log(res.data);
            })
            .catch(err => {
                console.log('Error', err);
            })
    }
}
</script>
