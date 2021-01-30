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
                    <a @click="$emit('close')">Cancel</a>
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
    props: ['column_id'],
    async created() {
        let response = await this.axios.get(`/api/column/edit/${this.column_id}`);
        this.column = response.data;
    },
    methods: {
        async updateColumn() {
            // await this.axios.post(`/api/column/update/${this.column_id}`, this.column);
            this.bus.$emit('columnUpdated', this.column);
            this.$emit('close');
        }
    }
}
</script>

<style scoped>

</style>
