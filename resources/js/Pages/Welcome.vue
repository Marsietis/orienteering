<script setup>
import {Head, Link} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome"/>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-200 text-gray-800">
        <div class="container mx-auto max-w-full sm:max-w-7xl px-4 sm:px-6 py-6 sm:py-10 lg:py-20">
            <header class="flex flex-col items-center justify-center mb-6 sm:mb-10">
                <!-- Apply responsive max-width and max-height -->
                <ApplicationLogo class="max-w-xs sm:max-w-sm lg:max-w-md max-h-40"/>
            </header>

            <main class="bg-white rounded-lg p-6 sm:p-8 shadow-lg">
                <h1 class="text-2xl sm:text-3xl font-bold mb-4">VU SA KnF Orientacinės varžybos / VU SR KnF Orienteering competition</h1>
                <p class="text-base sm:text-lg mb-4 sm:mb-6">rugsėjo 5 d. 17:00 - 19:30 / 5 September 17:00 - 19:30</p>

                <div class="space-y-4">
                    <p>[EN Below]</p>

                    <p>Labas, dalyvi (-e)!</p>
                    <p>Prieš pradėdami žaisti, susipažinkite su sąlygomis, kurias privalote įgyvendinti visose užduotyse. Užduotys, kurių
                        atsakymuose šios sąlygos nebus įgyvendintos, žaidimo vertintojai vertins 0 taškų.</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Kiekvienoje nuotraukoje <b>privaloma laikyti batoną</b>. (Pavyzdys pateiktas žemiau esančioje
                            nuotraukoje.) Batonas privalo būti tikras, batonų, rodomų telefone, neužskaitysime
                        </li>
                        <li>Visose įkeltose nuotraukose privalo būti matomas <b>TAS PATS KOMANDOS NARYS</b>. Nuotraukose,
                            kuriose yra kitas žmogus - neužskaitysime. Pastebėjus sukčiavimą komanda bus diskvalifikuota.
                        </li>
                    </ul>
                </div>
                <p class="mt-4">Atsakymai priimami iki 19:30</p>
                <p class="mt-2">Sėkmės!</p>

                <div class="space-y-4">
                    <p>--</p>
                    <p>Hello, participant!</p>
                    <p>Before you start playing, please read the conditions that you must meet in all the tasks. Any task that does not meet these conditions will be scored 0 points by the evaluators.</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>You must <b>hold a baguette</b> in each photo. (An example is shown in the photo below.) The baguette must be real, baguettes shown on the phone will not be counted.</li>
                        <li>All uploaded photos must feature <b>THE SAME TEAM MEMBER</b>. We will not credit photos that include another person. If cheating is detected the team will be disqualified.</li>
                    </ul>
                </div>
                <p class="mt-4">Submissions will be accepted until 19:30</p>
                <p class="mt-2">Good luck!</p>
                <img src="/storage/example.png" alt="Batonas" class="mx-auto mt-4 max-w-full"/>

                <div class="flex justify-center mt-6">
                    <a :href="route('register')">
                        <button
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-xl text-sm sm:text-base">
                            Spausk čia ir pradėk / Click here to start
                        </button>
                    </a>
                </div>
            </main>

            <footer class="mt-6 sm:mt-10 text-center text-sm text-gray-500">
                2024 VUSA KnF
            </footer>
        </div>
    </div>
</template>

<style>
.link {
    @apply rounded-md px-3 py-2 text-gray-800 ring-1 ring-transparent transition hover:text-red-500 focus:outline-none focus-visible:ring-red-500;
}
</style>
