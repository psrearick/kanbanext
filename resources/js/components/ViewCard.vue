<template>
    <div class="modal">
        <div class="modal__title">
            <h3>{{ card.title }}</h3>
        </div>
        <div>
            <p>{{ card.description }}</p>
        </div>
        <div class="grid grid--justify-between modal__buttons">
            <button class="btn" @click="editCard">Edit Card</button>
            <button class="btn btn--primary" @click="$emit('close')">Close</button>
        </div>
    </div>
</template>

<script>
import EditCard from "./EditCard";

export default {
    name: "ViewCard",
    props: ['cardData'],
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
        editCard() {
            this.$modal.show(
                EditCard,
                {
                    'card_id': this.card.id
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
