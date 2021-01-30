<template>
    <div class="grid__cell card">
        <div>
            <strong>{{card.title}}</strong>
        </div>
        <div>
            <p>{{card.description}}</p>
        </div>
        <div>

        </div>
        <div>
            <router-link :to="{name: 'edit-card', params: { id:card.id }}">Edit</router-link>
            <a @click="deleteCard(card.id)" href="#">Delete</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",
    props: ['card', 'index', 'colIndex'],
    methods: {
        async deleteCard(id) {
            await this.axios.delete(`/api/card/delete/${id}`);
            this.$emit('delete', id);
        },
    }
}
</script>

<style scoped>

</style>
