<template>
    <div class="grid__cell card">
        <div>
            <strong><a @click="viewCard">{{card.title}}</a></strong>
        </div>
        <div>
            <a v-if="index > 0 && cardCount > 1" @click="$emit('move', 'up')">Up</a>
            <a v-if="(index + 1) < cardCount && cardCount > 1" @click="$emit('move', 'down')">Down</a>
            <a v-if="column > 0 && columnCount > 1" @click="$emit('move', 'left')">Left</a>
            <a v-if="(column + 1) < columnCount && columnCount > 1" @click="$emit('move', 'right')">Right</a>
        </div>
        <div>
            <a @click="viewCard">View</a>
            <a @click="deleteCard" href="#">Delete</a>
        </div>
    </div>
</template>

<script>
import EditCard from "./EditCard";
import ViewCard from "./ViewCard";

export default {
    name: "Card",
    props: ['cardData', 'index', 'column', 'cardCount', 'columnCount'],
    data() {
        return {
            card: this.cardData
        }
    },
    created() {
        this.bus.$on('cardUpdated', this.updateCard);
    },
    beforeDestroy() {
        this.bus.$off('cardUpdated');
    },
    methods: {
        async deleteCard(id) {
            await this.axios.delete(`/api/card/delete/${this.card.id}`);
            this.$emit('delete');
        },
        viewCard() {
            this.$modal.show(
                ViewCard,
                {
                    'cardData': this.card
                },
                {
                    height: 'auto'
                }
            );
        },
        updateCard(card) {
            if (this.card.id === card.id) {
                this.card = card;
            }
        }
    }
}
</script>

<style scoped>

</style>
