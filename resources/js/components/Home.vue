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
                        <div v-if="!this.fileUsage" class="row">
                            <div class="title">0.00 MB (0 B)</div>
                            <div class="title">0</div>
                        </div>
                        <div v-if="this.fileUsage" class="row">
                            <div class="title">
                                {{ this.fileUsage["all_files_size_mb"] }} MB ({{
                                    this.fileUsage["all_files_size"]
                                }}
                                B)
                            </div>
                            <div class="title">
                                {{ this.fileUsage["all_files_num"] }}
                            </div>
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
                <div
                    v-if="!this.fileUsage['all_files_num']"
                    class="usage-compositions"
                >
                    <div class="title">No Data</div>
                </div>
                <table v-if="this.fileUsage['all_files_num']" class="table">
                    <tr class="table-header">
                        <th class="column-type">Type</th>
                        <th class="column-num">No. of files</th>
                        <th class="column-size">Size</th>
                    </tr>
                    <tr
                        v-if="this.fileUsage['jpeg_num'] !== 0"
                        class="table-row"
                    >
                        <td class="column-type">image/jpeg</td>
                        <td class="column-num">
                            {{ this.fileUsage["jpeg_num"] }}
                        </td>
                        <td class="column-size">
                            {{ this.fileUsage["jpeg_size_mb"] }} MB ({{
                                this.fileUsage["jpeg_size"]
                            }}
                            B)
                        </td>
                    </tr>
                    <tr
                        v-if="this.fileUsage['png_num'] !== 0"
                        class="table-row"
                    >
                        <td class="column-type">image/png</td>
                        <td class="column-num">
                            {{ this.fileUsage["png_num"] }}
                        </td>
                        <td class="column-size">
                            {{ this.fileUsage["png_size_mb"] }} MB ({{
                                this.fileUsage["png_size"]
                            }}
                            B)
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data: () => ({
        fileUsage: [],
    }),
    mounted() {
        axios
            .get("/api/" + this.$store.state.userId + "/get-summary")
            .then((res) => {
                this.fileUsage = res.data;
            })
            .catch((err) => {
                console.log(err);
            });
    },
};
</script>
