<template>
    <div
        :class="`w-${size} h-${size} border-${borderSize} border-${borderColor}-600 ${borderSize=== 0 ? 'border' : ''}`"
        class="rounded-full inline relative flex flex-col items-center group"
        :style="`background-color:#${backgroundColor}`">
        <div :class="`mt-${size}`"
             class="absolute top-0 flex flex-col items-center hidden mb-6 group-hover:flex"
             v-if="tooltip">
            <div class="w-3 h-3 -mb-2 bg-gray-800"></div>
            <p class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-gray-800 rounded shadow-lg">
                {{ name }}
            </p>
        </div>
        <p class="text-white m-auto " :style="`font-size: ${size*2-1}px`">{{ initials }}</p>
    </div>
</template>
<script>
import {helperFunctions} from "../../mixins/helperFunctionsMixin";

export default {
    mixins: [helperFunctions],

    watch: {
        name: function () {
            this.setInitialsAndBackgroundColor();
        }
    },

    data() {
        return {
            backgroundColor: 'fff',
            initials: 'XX'
        }
    },

    props: {
        name: {
            type: String, default: "john Doe",
        },
        user_id: {
            type: Number, default: null,
        },
        size: {
            type: Number, default: 10,
        },
        tooltip: {
            type: Boolean, default: false,
        },
        borderSize: {
            type: Number, default: 0,
        },
        borderColor: {
            type: String, default: "white",
        },
    },

    mounted() {
        this.setInitialsAndBackgroundColor();
    },

    methods: {

        setInitialsAndBackgroundColor() {
            this.initials = this.getInitials()
            this.backgroundColor = this.generateHexColorWithText(this.name);
        },

        getInitials() {
            let names = this.name.split(' '),
                initials = names[0].substring(0, 1).toUpperCase();

            if (names.length > 1) {
                initials += names[names.length - 1].substring(0, 1).toUpperCase();
            } else {
                initials += names[names.length - 1].substring(1, 2).toUpperCase();
            }
            return initials;
        },
    },
};
</script>

<style scoped>

.group:hover .group-hover\:flex {
    display: flex;
}
</style>
