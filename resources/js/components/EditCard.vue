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
    async created() {
        let response = await this.axios.get(`/api/card/edit/${this.$route.params.id}`);
        this.card = response.data;
    },
    methods: {
        async updateCard() {
            await this.axios.post(`/api/card/update/${this.$route.params.id}`, this.card);
            await this.$router.push({name: 'home'});
        }
}
}
</script>

<style scoped>

</style>
