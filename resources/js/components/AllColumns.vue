<template>
    <div class="grid grid--full">
        <main class="grid__cell">
            <div class="columns__wrapper grid grid--gutters grid--full">
                <div v-for="column in columns" :key="column.id" class="column grid__cell grid__cell--25">
                    <div>
                        <strong>{{ column.name }}</strong>
                    </div>
                    <div>
                        <router-link :to="{name: 'edit-column', params: { id: column.id }}">Edit
                        </router-link>
                        <button @click="deleteColumn(column.id)">Delete</button>
                    </div>
                    <div class="grid grid--column column__cards" v-if="cardInColumn(column.id).length">
                        <Card v-for="(card, index) in cardInColumn(column.id)"
                              :key="card.id"
                              :card="card"
                              :index="index"
                              v-on:delete="removeCard(card.id)">
                        </Card>
                    </div>
                    <div>
                        <router-link :to="'/card/add/' + column.id">Add Card</router-link>
                    </div>
                </div>
            </div>
        </main>
        <aside class="grid__cell grid__cell--25">
            <router-link to="/column/add">Add Column</router-link>
        </aside>
    </div>
</template>

<script>
import Card from "./Card";
export default {
    name: "AllColumns",
    components: {Card},
    data() {
        return {
            columns: [],
            cards: []
        }
    },
    async created() {
        let cards = this.cards;
        this.columns = (await this.axios.get('/api/columns')).data;
        let cardsResponse = (await this.axios.get('/api/cards')).data;
        cardsResponse.forEach(card => {
            this.cards.push(card);
        });
    },
    methods: {
        async deleteColumn(id) {
            await this.axios.delete(`/api/column/delete/${id}`);
            let i = this.columns.map(item => item.id).indexOf(id);
            this.columns.splice(i, 1);
        },
        cardInColumn(column_id) {
            return this.cards.filter(card => {
                return card.column_id === column_id;
            });
        },
        removeCard(id) {
            let i = this.cards.map(item => item.id).indexOf(id);
            this.cards.splice(i, 1);
        }
    }
}
</script>

<style scoped>

</style>
