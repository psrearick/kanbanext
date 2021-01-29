<template>
    <div>
        <h3>Add Column</h3>
        <div class="row">
            <div>
                <form @submit.prevent="addColumn">
                    <div>
                        <label>Name</label>
                        <input type="text" v-model="column.name">
                    </div>
                    <button type="submit">Add Column</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddColumn",
    data() {
        return {
            column: {}
        }
    },
    methods: {
        addColumn() {
            this.axios
                .post('/api/column/add', this.column)
                .then(response => {
                    this.$router.push({name: 'home'})
                })
                .catch(error => console.log(error))
                .finally(() => this.loading = false);
        }
    }
}
</script>

<style scoped>

</style>
