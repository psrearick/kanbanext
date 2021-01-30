<template>
    <div>
        <h3>Edit Card</h3>
        <div>
            <form @submit.prevent="updateCard">
                <div>
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="card.title">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" v-model="card.description"></textarea>
                </div>
                <button type="submit">Edit Card</button>
                <a @click="$emit('close')">Cancel</a>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditCard",
    data() {
        return {
            card: {}
        }
    },
    props: ['card_id'],
    async created() {
        let response = await this.axios.get(`/api/card/edit/${this.card_id}`);
        this.card = response.data;
    },
    methods: {
        async updateCard() {
            await this.axios.post(`/api/card/update/${this.card_id}`, this.card);
            this.bus.$emit('cardUpdated', this.card);
            this.$emit('close');
        }
}
}
</script>

<style scoped>

</style>
