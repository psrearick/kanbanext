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
    methods: {
        addCard() {
            this.card.column_id = this.$route.params.id;
            this.axios
            .post('api/card/add', this.card)
            .then(response => {
                this.$router.push({name: 'home'})
            })
            .catch(error => console.log(error))
            .finally(() => this.loading = false);
        }
    }
}
</script>

<style scoped>

</style>
