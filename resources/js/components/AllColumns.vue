<template>
    <div>
        <div class="column-container">
            <div v-for="column in columns" :key="column.id">
                <div class="column-header">
                    <div>
                        <strong>{{ column.name }}</strong>
                    </div>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: column.id }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteColumn(column.id)">Delete</button>
                    </div>
                </div>
                <div class="column-cards"></div>
                <div class="delete-column"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AllColumns",
    data() {
        return {
            columns: []
        }
    },
    created() {
        this.axios
            .get('/api/columns')
            // .get('http://kanban.test/api/columns')
            .then(response => {
                this.columns = response.data;
            });
    },
    methods: {
        deleteColumn(id) {
            this.axios
                .delete(`/api/column/delete/${id}`)
                .then(response => {
                    let i = this.columns.map(item => item.id).indexOf(id);
                    this.columns.splice(i, 1);
                });
        }
    }
}
</script>

<style scoped>

</style>
