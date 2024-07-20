<template>
    <div>
        <p>{{ hours }}h {{ minutes }}m {{ seconds }}s</p>
    </div>
</template>

<script>
export default {
    props: {
        eventEndDateTime: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            targetTime: new Date(this.eventEndDateTime).getTime(),
            currentTime: new Date().getTime(),
            intervalId: null,
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
        };
    },
    methods: {
        updateCountdown() {
            this.currentTime = new Date().getTime();
            const timeLeft = this.targetTime - this.currentTime;

            if (timeLeft < 0) {
                clearInterval(this.intervalId);
                return;
            }

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
}
</style>
