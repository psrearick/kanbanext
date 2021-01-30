<template>
    <div class="modal">
        <div class="modal__title">
            <h3>Add Column</h3>
        </div>
        <form @submit.prevent="addColumn">
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" v-model="column.name" placeholder="Column Name">
            </div>
            <div class="grid grid--justify-between modal__buttons">
                <button class="btn btn--secondary" @click="$emit('close')">Cancel</button>
                <button class="btn btn--primary" type="submit">Add</button>
            </div>
        </form>
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
