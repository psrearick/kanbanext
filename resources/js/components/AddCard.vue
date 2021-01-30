<template>
    <div class="modal">
        <div class="modal__title">
            <h3>Add Card</h3>
        </div>
        <div>
            <form @submit.prevent="addCard">
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
                    <button class="btn btn--primary" type="submit">Add</button>
                </div>
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
