<template>
    <div>
        <h3>Edit Column</h3>
        <div class="row">
            <div>
                <form @submit.prevent="updateColumn">
                    <div>
                        <label for="name">Name</label>
                        <input id="name" type="text" v-model="column.name">
                    </div>
                    <button type="submit">Update Column</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditColumn",
    data() {
        return {
            column: {}
        }
    },
    created() {
        this.axios
            .get(`/api/column/edit/${this.$route.params.id}`)
            .then((response) => {
                this.column = response.data;
            });
    },
    methods: {
        updateColumn() {
            this.axios
                .post(`/api/column/update/${this.$route.params.id}`, this.column)
                .then((response) => {
                    this.$router.push({name: 'home'});
                })
        }
    }
}
</script>

<style scoped>

</style>
