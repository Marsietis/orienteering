<template>
    <div>
        <p v-if="!eventEnded">{{ hours }}h {{ minutes }}m {{ seconds }}s</p>
        <p v-else class="ended-message">Varžybos baigėsi / Event ended</p>
    </div>
</template>

<script>
export default {
    props: {
        eventEndDateTime: {
            type: Object,
            required: true,
            default: () => ({ end_date: new Date() }) // Provide a default object to avoid null issues
        },
    },
    data() {
        return {
            targetTime: this.eventEndDateTime ? new Date(this.eventEndDateTime.end_date).getTime() : new Date().getTime(),
            currentTime: new Date().getTime(),
            intervalId: null,
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
            eventEnded: false,
        };
    },
    methods: {
        updateCountdown() {
            if (!this.eventEndDateTime || !this.eventEndDateTime.end_date) {
                // Handle case where eventEndDateTime or end_date is not properly provided
                this.eventEnded = true; // Set to true to avoid infinite loop
                return;
            }

            this.currentTime = new Date().getTime();
            const timeLeft = this.targetTime - this.currentTime;

            if (timeLeft < 0) {
                clearInterval(this.intervalId);
                this.eventEnded = true;
                return;
            }

            this.eventEnded = false; // Ensure the event is not marked as ended when there's still time
            this.days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
        },
    },
    mounted() {
        this.updateCountdown();
        this.intervalId = setInterval(this.updateCountdown, 1000);
    },
    beforeUnmount() {
        clearInterval(this.intervalId);
    },
};
</script>

<style scoped>
p {
    font-size: 2em;
    text-align: center;
    margin: 0;
}

.ended-message {
    font-size: 2em;
    color: red;
    text-align: center;
    margin: 0;
    font-weight: bold;
}
</style>
