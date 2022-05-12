<template>
    <div class="btn-group" v-if="paginator.totalPage > 1">
        <button @click.prevent="() => dataFunction(page)" class="btn" v-for="page in paginator.totalPage" :key="page" :class="{'btn-active': page === paginator.currentPage}">{{ page }}</button>
    </div>
</template>

<script>
export default {
    name: "Paginator",
    props: {
        paginator: {
            type: Object,
            required: true,
            default: {
                page: 1,
                totalPage: 0,
                currentPage: 1,
            }
        },
        nextPage: {
            type: Function,
            required: true,
        },
        prevPage: {
            type: Function,
            required: true,
        },
        dataFunction: {
            type: Function,
            required: true,
        }
    },

    setup() {
        const getData = (page) => {
            this.dataFunction(page);
        };

        return {
            getData,
        };
    }
}
</script>

<style scoped>

</style>
