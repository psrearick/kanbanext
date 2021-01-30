<template>
    <div class="grid__cell card">
        <div>
            <strong>{{card.title}}</strong>
        </div>
        <div>
            <a v-if="index > 0 && cardCount > 1" @click="$emit('move', 'up')">Up</a>
            <a v-if="(index + 1) < cardCount && cardCount > 1" @click="$emit('move', 'down')">Down</a>
            <a v-if="column > 0 && columnCount > 1" @click="$emit('move', 'left')">Left</a>
            <a v-if="(column + 1) < columnCount && columnCount > 1" @click="$emit('move', 'right')">Right</a>
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
    props: ['card', 'index', 'column', 'cardCount', 'columnCount'],
    methods: {
        async deleteCard(id) {
            await this.axios.delete(`/api/card/delete/${id}`);
            this.$emit('delete');
        },
    }
}
</script>

<style scoped>

</style>
