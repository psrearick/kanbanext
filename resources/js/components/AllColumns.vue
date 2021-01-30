<template>
<!--    <div class="grid grid&#45;&#45;full">-->
        <div class="container">
        <!--        <aside class="grid__cell grid__cell&#45;&#45;25">-->
<!--        <nav class="grid__cell grid__cell&#45;&#45;25" role="navigation">-->
            <nav role="navigation">
            <div id="menuToggle">
                <input type="checkbox" />
                <span></span>
                <span></span>
                <span></span>
                <ul id="menu">
                    <a @click="addColumn"><li>Add Column</li></a>
                    <a @click="exportDatabase"><li>Export Database</li></a>
                    <a @click="deleteBoard"><li>Delete Board</li></a>
                </ul>
            </div>
        </nav>
        <!--        </aside>-->
<!--        <main class="grid__cell">-->
        <main>
            <div class="title">
                <h2>Kanban Board</h2>
            </div>
            <div class="columns__wrapper grid grid--gutters grid--full">
                <div v-for="(column, columnIndex) in columns" :key="column.id" class="column grid__cell grid__cell--25">
                    <div class="column__name">
                        <strong>{{ column.name }}</strong>
                    </div>

                    <div class="column__container">
                        <div class="column__navigation grid grid--overflow grid--justify-between">
                            <div>
                                <div class="arrow arrow--left arrow--75" v-if="columnIndex > 0" @click="moveColumn(column, 'left')"></div>
                            </div>
                            <div>
                                <div class="arrow arrow-right arrow--75" v-if="columnIndex < columns.length - 1" @click="moveColumn(column, 'right')"></div>
                            </div>
                        </div>
                        <div class="grid grid--justify-between column__buttons">
                            <button class="btn btn--sm" @click="editColumn(column.id)">Edit</button>
                            <button class="btn btn--sm btn--secondary" @click="deleteColumn(column.id)">Delete</button>
                        </div>
                        <div class="grid grid--column column__cards" v-if="cardsInColumn(column.id).length">
                            <Card v-for="(card, index) in cardsInColumn(column.id)"
                                  :key="card.id"
                                  :cardData="card"
                                  :index="index"
                                  :cardCount="cardsInColumn(column.id).length"
                                  :column="columnIndex"
                                  :columnCount="columns.length"
                                  v-on:delete="removeCard(card.id)"
                                  v-on:move="move(card, $event)">
                            </Card>
                        </div>
<!--                        <div class="column__add-card">-->
                            <button class="column__add-card" @click="addCard(column.id)">Add Card</button>
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import Card from "./Card";
import AddColumn from "./AddColumn";
import AddCard from "./AddCard";
import EditColumn from "./EditColumn";
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
        await this.fetchColumns();
        await this.fetchCards();
        this.bus.$on('columnAdded', this.fetchColumns);
        this.bus.$on('cardAdded', this.fetchCards);
        this.bus.$on('columnUpdated', this.columnUpdated);
        this.bus.$on('cardUpdated', this.updateCard);
    },
    beforeDestroy() {
        this.bus.$off('columnAdded');
        this.bus.$off('cardAdded');
        this.bus.$off('columnUpdated');
        this.bus.$off('cardUpdated');
    },
    methods: {
        async fetchColumns() {
            this.columns = (await this.axios.get('/api/columns')).data
                .sort((a, b) => a.rank - b.rank);
            return true;
        },
        async fetchCards() {
            let cards = [];
            let cardsResponse = (await this.axios.get('/api/cards')).data;
            cardsResponse.forEach(card => {
                cards.push(card);
            });
            this.cards = cards;
            return true;
        },
        async deleteColumn(id) {
            await this.axios.delete(`/api/column/delete/${id}`);
            let i = this.columns.map(item => item.id).indexOf(id);
            this.columns.splice(i, 1);
            return true;
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
        addColumn() {
            this.$modal.show(
                AddColumn,
                {},
                {
                    height: 'auto'
                },
            );
        },
        addCard(column) {
            this.$modal.show(
                AddCard,
                {
                    'column_id': column
                },
                {
                    height: 'auto'
                },
            )
        },
        editColumn(column_id) {
            this.$modal.show(
                EditColumn,
                {
                    'column_id': column_id
                },
                {
                    height: 'auto'
                }
            );
        },
        columnUpdated(column) {
            let columnIndex = this.columns.map(column => column.id).indexOf(column.id);
            this.columns.splice(columnIndex, 1, column);
        },
        async exportDatabase() {
            let response = await this.axios.get('/api/download', {
                responseType: 'blob'
            });
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'db-dump.sql');
            document.body.appendChild(link);
            link.click();
        },
        updateCard(card) {
            let i = this.cards.map(item => item.id).indexOf(card.id);
            this.cards.splice(i, 1, card);
        },
        async deleteBoard() {
            let promises = this.columns.map(column => {
                return this.deleteColumn(column.id);
            });
            await Promise.all(promises);
            await this.fetchColumns();
            await this.fetchCards();
            return true;
        }
    }
}
</script>

<style scoped>

</style>
