<template>
    <div v-if="dashboardData !== null">
        <div class="bg-gray-100 w-full h-64 absolute top-0 rounded-b-lg" style="z-index: -1"></div>

        <div class="flex flex-wrap p-4 pl-10">
            <h3 class="text-3xl text-gray-800 font-bold py-1 pr-8">Business Intelligence</h3>
        </div>

        <div class="mx-10 my-3 space-y-5 shadow-xl p-5 bg-white">

            <!-- Dashboard Quick Links -->
            <div class="flex flex-wrap bg-gray-50 p-4 rounded">
                Dashboard items
            </div>

            <hr class="mb-5"/>

            <div class="h-full">
                Dashboard tiles and items
            </div>
        </div>
    </div>
</template>

<script>

    import {axiosCalls} from "../../mixins/axiosCallsMixin";
    import vSelect from "vue-select";
    import Avatar from "../global/Avatar.vue";

    export default {

        inject: ["eventHub"],

        components: {
            vSelect,
            Avatar,
        },
        mixins: [axiosCalls],

        data() {
            return {
                dashboardData: []
            };
        },

        methods: {
            // getDashboardData() {
            //     this.eventHub.$emit("set-loading-state", true);
            //     this.asyncGetDashboardData().then((data) => {
            //         this.dashboardData = data.data.dashboardData;
            //         this.eventHub.$emit("set-loading-state", false);
            //     });
            // },
        },
    };
</script>

<style scoped>

</style>
