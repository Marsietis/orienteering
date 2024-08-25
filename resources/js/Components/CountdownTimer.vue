<template>
    <div>
        <p v-if="!eventEnded && !eventStarted">
            Competition starts in:
            <span class="block"> {{ days }}d {{ hours }}h {{ minutes }}m {{ seconds }}s</span>
        </p>
        <p v-if="!eventEnded && eventStarted">
            Event ends in:
            <span class="block"> {{ days }}d {{ hours }}h {{ minutes }}m {{ seconds }}s</span>
        </p>
        <p v-if="eventEnded" class="ended-message">Varžybos baigėsi / Competition ended</p>
    </div>
</template>

<script>
export default {
    props: {
        eventEndDateTime: {
            type: Object,
            required: true,
            default: () => ({start_date: new Date(), end_date: new Date()}) // Default start and end dates
        },
    },
    data() {
        return {
            startTime: this.eventEndDateTime ? new Date(this.eventEndDateTime.start_date).getTime() : new Date().getTime(),
            endTime: this.eventEndDateTime ? new Date(this.eventEndDateTime.end_date).getTime() : new Date().getTime(),
            currentTime: new Date().getTime(),
            intervalId: null,
            days: 0,
            hours: 0,
            minutes: 0,
            seconds: 0,
            eventStarted: false,
            eventEnded: false,
        };
    },
    methods: {
        updateCountdown() {
            this.currentTime = new Date().getTime();

            // Check if the event has started
            if (this.currentTime < this.startTime) {
                // Event hasn't started yet, countdown to start time
                this.eventStarted = false;
                const timeLeft = this.startTime - this.currentTime;

                if (timeLeft < 0) {
                    this.eventStarted = true; // Event has started
                } else {
                    this.days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                }
            } else if (this.currentTime < this.endTime) {
                // Event has started but not ended yet, countdown to end time
                this.eventStarted = true;
                const timeLeft = this.endTime - this.currentTime;

                if (timeLeft < 0) {
                    clearInterval(this.intervalId);
                    this.eventEnded = true;
                } else {
                    this.days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
                }
            } else {
                // Event has ended
                clearInterval(this.intervalId);
                this.eventEnded = true;
            }
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
