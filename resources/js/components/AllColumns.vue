<template>
    <div class="grid grid--full">
        <main class="grid__cell">
            <div class="columns__wrapper grid grid--gutters">
                <div v-for="column in columns" :key="column.id" class="column grid__cell grid__cell--25">
                    <div>
                        <strong>{{ column.name }}</strong>
                    </div>
                    <div>
                        <router-link :to="{name: 'edit-column', params: { id: column.id }}">Edit
                        </router-link>
                        <button @click="deleteColumn(column.id)">Delete</button>
                    </div>
                    <div class="grid grid--column column__cards">
                        <div v-for="card in cardInColumn(column.id)" :key="card.id" class="grid__cell">
                            <div>
                                <strong>{{card.title}}</strong>
                            </div>
                            <div>
                                <p>{{card.description}}</p>
                            </div>
                            <div>
                                <span>Edit</span>
                                <a @click="deleteCard(card.id)">Delete</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <router-link :to="'/card/add/' + column.id">Add Card</router-link>
                    </div>
                </div>
            </div>
        </main>
        <aside class="grid__cell grid__cell--25">
            <p>Sidebar</p>
        </aside>
    </div>
</template>

<script>
export default {
    name: "AllColumns",
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
        async deleteCard(id) {
            await this.axios.delete(`/api/card/delete/${id}`);
            let i = this.cards.map(item => item.id).indexOf(id);
            this.cards.splice(i, 1);
        },
        cardInColumn(column_id) {
            return this.cards.filter(card => {
                return card.column_id === column_id;
            });
        }
    }
}
</script>

<style scoped>

</style>
