<template>
    <div class="countdown-container">
        <p v-if="!eventEnded && !eventStarted" :class="{ 'countdown-starting-soon': isStartingSoon }">
            COMPETITION STARTS IN:
            <span class="countdown-time">
                <span v-if="days > 0">{{ days }}d </span>
                {{ hours }}h {{ minutes }}m {{ seconds }}s
            </span>
        </p>
        <p v-if="!eventEnded && eventStarted" :class="{ 'countdown-ending-soon': isEndingSoon }">
            COMPETITION ENDS IN:
            <span class="countdown-time">
                <span v-if="days > 0">{{ days }}d </span>
                {{ hours }}h {{ minutes }}m {{ seconds }}s
            </span>
        </p>
        <p v-if="eventEnded" class="ended-message">VARŽYBOS BAIGĖSI / COMPETITION ENDED</p>
    </div>
</template>


<script>
export default {
    props: {
        eventEndDateTime: {
            type: Object,
            required: true,
            default: () => ({start_date: new Date(), end_date: new Date()})
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
            isStartingSoon: false,
            isEndingSoon: false,
        };
    },
    methods: {
        updateCountdown() {
            this.currentTime = new Date().getTime();

            if (this.currentTime < this.startTime) {
                this.eventStarted = false;
                const timeLeft = this.startTime - this.currentTime;

                this.isStartingSoon = timeLeft <= 1000 * 60 * 10;

                if (timeLeft < 0) {
                    this.eventStarted = true;
                } else {
                    this.updateTimeValues(timeLeft);
                }
            } else if (this.currentTime < this.endTime) {
                this.eventStarted = true;
                const timeLeft = this.endTime - this.currentTime;

                this.isEndingSoon = timeLeft <= 1000 * 60 * 10;

                if (timeLeft < 0) {
                    clearInterval(this.intervalId);
                    this.eventEnded = true;
                } else {
                    this.updateTimeValues(timeLeft);
                }
            } else {
                clearInterval(this.intervalId);
                this.eventEnded = true;
            }
        },
        updateTimeValues(timeLeft) {
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
.countdown-container {
    text-align: center;
    padding: 20px;
}

p {
    font-size: 1.5em;
    margin: 0;
    transition: color 0.5s ease, transform 0.5s ease;
    line-height: 1.4;
}

.countdown-time {
    display: block;
    font-size: 2em;
    font-weight: bold;
}

.countdown-starting-soon {
    color: #4caf50; /* Green */
    animation: pulse 1s infinite;
}

.countdown-ending-soon {
    color: #f44336; /* Red */
    animation: pulse 1s infinite;
}

.ended-message {
    font-size: 1.5em;
    color: #f44336; /* Red */
    font-weight: bold;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}
</style>
