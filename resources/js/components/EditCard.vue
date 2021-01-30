<template>
    <div class="modal">
        <div class="modal__title">
            <h3>Edit Card</h3>
        </div>
        <div>
            <form @submit.prevent="updateCard">
                <div>
                    <label for="title">Title</label>
                    <input type="text" id="title" v-model="card.title" placeholder="Card Title">
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea name="description" id="description" v-model="card.description" placeholder="Description"></textarea>
                </div>
                <div class="grid grid--justify-between modal__buttons">
                    <button class="btn btn--secondary" @click="$emit('close')">Cancel</button>
                    <button class="btn btn--primary" type="submit">Edit</button>
                </div>
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
