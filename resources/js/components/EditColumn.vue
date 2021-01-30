<template>
    <div class="modal">
        <div class="modal__title">
            <h3>Edit Column</h3>
        </div>
        <form @submit.prevent="updateColumn">
            <div>
                <label for="name">Name</label>
                <input id="name" type="text" v-model="column.name" placeholder="Column Name">
            </div>
            <div class="grid grid--justify-between modal__buttons">
                <button class="btn btn--secondary" @click="$emit('close')">Cancel</button>
                <button class="btn btn--primary" type="submit">Update Column</button>
            </div>
        </form>
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
    props: ['column_id'],
    async created() {
        let response = await this.axios.get(`/api/column/edit/${this.column_id}`);
        this.column = response.data;
    },
    methods: {
        async updateColumn() {
            await this.axios.post(`/api/column/update/${this.column_id}`, this.column);
            this.bus.$emit('columnUpdated', this.column);
            this.$emit('close');
        }
    }
}
</script>

<style scoped>

</style>
