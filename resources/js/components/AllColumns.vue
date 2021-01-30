<template>
    <div class="grid grid--full">
        <main class="grid__cell">
            <div class="columns__wrapper grid grid--gutters grid--full">
                <div v-for="(column, columnIndex) in columns" :key="column.id" class="column grid__cell grid__cell--25">
                    <div>
                        <strong>{{ column.name }}</strong>
                        <div>
                            <a v-if="columnIndex > 0" @click="moveColumn(column, 'left')">Left</a>
                            <a v-if="columnIndex < columns.length - 1" @click="moveColumn(column, 'right')">Right</a>
                        </div>
                    </div>
                    <div>
                        <router-link :to="{name: 'edit-column', params: { id: column.id }}">Edit
                        </router-link>
                        <button @click="deleteColumn(column.id)">Delete</button>
                    </div>
                    <div class="grid grid--column column__cards" v-if="cardsInColumn(column.id).length">
                        <Card v-for="(card, index) in cardsInColumn(column.id)"
                              :key="card.id"
                              :card="card"
                              :index="index"
                              :cardCount="cardsInColumn(column.id).length"
                              :column="columnIndex"
                              :columnCount="columns.length"
                              v-on:delete="removeCard(card.id)"
                              v-on:move="move(card, $event)">
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
            <br>
            <h3>EXPORT</h3>
            <br>
            <h3>DELETE BOARD</h3>
        </aside>
    </div>
</template>

<script>
import Card from "./Card";
import AddColumn from "./AddColumn";
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
        this.columns = (await this.axios.get('/api/columns')).data
            .sort((a, b) => a.rank - b.rank);
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
        cardsInColumn(column_id) {
            return this.cards.filter(card => {
                return card.column_id === column_id;
            }).sort((a, b) => a.rank - b.rank);
        },
        removeCard(id) {
            let i = this.cards.map(item => item.id).indexOf(id);
            this.cards.splice(i, 1);
        },
        async moveColumn(column, direction) {
            let columnIndex = this.columns.map(column => column.id).indexOf(column.id);
            if (direction === 'left') {
                let afterIndex = columnIndex - 1;
                let beforeIndex = afterIndex > 0 ? afterIndex - 1 : null;
                let after = this.columns[afterIndex];
                let before = beforeIndex ? this.columns[beforeIndex] : null;
                column.rank = before ? (after.rank - before.rank) / 2 : after.rank / 2;
            }
            if (direction === 'right') {
                let beforeIndex = columnIndex + 1;
                let afterIndex = beforeIndex < (this.columns.length - 1) ? beforeIndex + 1 : null;
                let before = this.columns[beforeIndex];
                let after = afterIndex ? this.columns[afterIndex] : null;
                column.rank = after ? (after.rank + before.rank) / 2 : before.rank + 100;
            }
            await this.axios.post(`/api/column/update/${column.id}`, column);
            this.columns[columnIndex] = column;
            this.columns.sort((a, b) => a.rank - b.rank);
        },
        async move(card, direction) {
            let updated = card;
            if (direction === 'up' || direction === 'down') {
                updated = this.moveVertical(card, direction);
            }
            if (direction === 'left' || direction === 'right') {
                updated = this.moveHorizontal(card, direction);
            }
            console.log(updated);
            await this.axios.post(`/api/card/update/${card.id}`, updated);
            let i = this.cards.map(item => item.id).indexOf(card.id);
            this.cards[i] = updated;
        },
        moveVertical(card, direction) {
            let columnCards = this.cardsInColumn(card.column_id);
            let cardIndex = columnCards.map(card => card.id).indexOf(card.id);
            if (direction === 'up') {
                let previousIndex = cardIndex - 1;
                let afterRank = columnCards[previousIndex].rank;
                let before = previousIndex === 0 ? null  : columnCards[previousIndex - 1];
                let beforeRank = before ? before.rank : 0;
                card.rank = (afterRank + beforeRank) / 2;
            }
            if (direction === 'down') {
                let nextIndex = cardIndex + 1;
                let beforeRank = columnCards[nextIndex].rank;
                let afterIndex = nextIndex + 1;
                let after = afterIndex < columnCards.length ? columnCards[afterIndex] : null;
                card.rank = after ? (beforeRank + after.rank) / 2 : beforeRank + 100;
            }
            return card;
        },
        moveHorizontal(card, direction) {
            let columnIndex = this.columns.map(column => column.id).indexOf(card.column_id);
            if (direction === 'left') {
                let previousIndex = columnIndex - 1;
                let previous = this.columns[previousIndex];
                card.column_id = previous.id;
            }
            if (direction === 'right') {
                let nextIndex = columnIndex + 1;
                let next = this.columns[nextIndex];
                card.column_id = next.id;
            }
            let columnCards = this.cardsInColumn(card.column_id);
            let highestRank = columnCards[columnCards.length - 1].rank;
            card.rank = highestRank + 100;
            return card;
        },
    }
}
</script>

<style scoped>

</style>
