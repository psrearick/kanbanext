<template>
    <div class="grid__cell card">
        <div class="card__title">
            <strong><a @click="viewCard">{{card.title}}</a></strong>
        </div>
        <div class="grid grid--justify-between card__links">
            <a class="text--light" @click="viewCard">Details</a>
            <a class="text--danger" @click="deleteCard" href="#">Delete</a>
        </div>
        <div class="grid grid--overflow grid--justify-between card__navigation">
            <div>
                <div class="arrow arrow--left arrow--50" v-if="column > 0 && columnCount > 1" @click="$emit('move', 'left')"></div>
            </div>
            <div>
                <div class="arrow arrow--up arrow--50" v-if="index > 0 && cardCount > 1" @click="$emit('move', 'up')"></div>
            </div>
            <div>
                <div class="arrow arrow--down arrow--50" v-if="(index + 1) < cardCount && cardCount > 1" @click="$emit('move', 'down')"></div>
            </div>
            <div>
                <div class="arrow arrow--right arrow--50" v-if="(column + 1) < columnCount && columnCount > 1" @click="$emit('move', 'right')"></div>
            </div>
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
