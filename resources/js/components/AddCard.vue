<template>
    <div>
        <h3>Add Card</h3>
        <div>
            <form @submit.prevent="addCard">
                <div>
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="card.title">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" v-model="card.description"></textarea>
                </div>
                <button type="submit">Add Card</button>
                <a @click="$emit('close')">Cancel</a>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddCard",
    data() {
        return {
            card: {}
        }
    },
    props: ['column_id'],
    methods: {
        async addCard() {
            this.card.column_id = this.column_id;
            await this.axios.post('api/card/add', this.card);
            this.bus.$emit('cardAdded');
            this.$emit('close');
        }
    }
}
</script>

<style scoped>

</style>
