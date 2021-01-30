<template>
    <div>
        <h3>Add Column</h3>
        <div>
            <form @submit.prevent="addColumn">
                <div>
                    <label for="name">Name</label>
                    <input type="text" id="name" v-model="column.name">
                </div>
                <button type="submit">Add Column</button>
                <a @click="$emit('close')">Cancel</a>
            </form>
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
        async addColumn() {
            await this.axios.post('/api/column/add', this.column);
            this.bus.$emit('columnAdded');
            this.$emit('close');
        }
    }
}
</script>

<style scoped>

</style>
