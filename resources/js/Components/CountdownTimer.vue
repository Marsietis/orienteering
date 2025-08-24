<template>
    <div class="countdown-container">
        <!-- Competition Starting Soon -->
        <div v-if="!eventEnded && !eventStarted" class="text-center">
            <h3 class="text-lg font-medium text-gray-700 mb-3">
                Iki varžybų pradžios liko / Competition starts in:
            </h3>
            <div class="text-3xl font-bold text-green-600">
                <span v-if="days > 0">{{ days }}d </span>{{ hours }}h {{ minutes }}m {{ seconds }}s
            </div>
        </div>

        <!-- Competition Active -->
        <div v-if="!eventEnded && eventStarted" class="text-center">
            <h3 class="text-lg font-medium text-gray-700 mb-3">
                Iki varžybų pabaigos liko / Competition ends in:
            </h3>
            <div class="text-3xl font-bold text-orange-600">
                <span v-if="days > 0">{{ days }}d </span>{{ hours }}h {{ minutes }}m {{ seconds }}s
            </div>
        </div>

        <!-- Competition Ended -->
        <div v-if="eventEnded" class="text-center">
            <h3 class="text-xl font-bold text-red-600 mb-2">
                Varžybos baigėsi / Competition ended
            </h3>
            <p class="text-gray-600">Ačiū už dalyvavimą! / Thank you for participating!</p>
        </div>
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
    padding: 20px;
}
</style>
