<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <p>Disk Usage Overview</p>
            </div>
            <div class="content-body">
                <div class="usage-overview">
                    <div class="div-left">
                        <div class="title">Total Size:</div>
                        <div class="title">No. of Files:</div>
                    </div>
                    <div class="div-right">
                        <div v-if="!this.file_usage" class="row">
                            <div class="title">0.00 MB (0 B)</div>
                            <div class="title">0</div>
                        </div>
                        <div v-if="this.file_usage" class="row">
                            <div class="title">{{ this.file_usage.all_files_size_mb }} MB ({{ this.file_usage.all_files_size }} B)</div>
                            <div class="title">{{ this.file_usage.all_files_num }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <p>Disk Usage Compositions</p>
            </div>
            <div class="content-body">
                <div v-if="this.file_usage.all_files_num === 0" class="usage-compositions">
                    <div class="title">No Data</div>
                </div>
                <table v-if="this.file_usage.all_files_num !== 0" class="table">
                    <tr class="table-header">
                        <th class="column-type">Type</th>
                        <th class="column-num">No. of files</th>
                        <th class="column-size">Size</th>
                    </tr>
                    <tr v-if="this.file_usage.jpeg_num !== 0" class="table-row">
                        <td class="column-type">image/jpeg</td>
                        <td class="column-num">{{ this.file_usage.jpeg_num }}</td>
                        <td class="column-size">{{ this.file_usage.jpeg_size_mb }} MB ({{ this.file_usage.jpeg_size }} B)</td>
                    </tr>
                    <tr v-if="this.file_usage.png_num !== 0" class="table-row">
                        <td class="column-type">image/png</td>
                        <td class="column-num">{{ this.file_usage.png_num }}</td>
                        <td class="column-size">{{ this.file_usage.png_size_mb }} MB ({{ this.file_usage.png_size }} B)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: 'GetData',
    data: () => ({
        file_usage: null,
    }),
    mounted() {
        axios.get('/api/get-data')
            .then(res => {
                this.file_usage = res.data;
                this.file_usage['all_files_size_mb'] = (res.data.all_files_size/1000000).toFixed(2);
                this.file_usage['jpeg_size_mb'] = (res.data.jpeg_size/1000000).toFixed(2);
                this.file_usage['png_size_mb'] = (res.data.png_size/1000000).toFixed(2);
            })
            .catch(err => {
                //
            })
    }
}
</script>
