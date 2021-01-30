<template>
    <div>
        <div>
            <h3>{{ card.title }}</h3>
            <p>{{ card.description }}</p>
        </div>
        <div>
            <a @click="editCard">Edit</a>
            <a @click="$emit('close')">Close</a>
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
