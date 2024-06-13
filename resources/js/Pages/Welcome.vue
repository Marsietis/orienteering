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
    <nav v-if="canLogin" class="flex space-x-4 justify-end text-lg mt-4 lg:mt-0  bg-gray-200">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="link">Dashboard</Link>
        <template v-else>
            <Link :href="route('login')" class="link">Log in</Link>
            <Link v-if="canRegister" :href="route('register')" class="link">Register</Link>
        </template>
    </nav>
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-gray-200 text-gray-800">
        <div class="container mx-auto max-w-7xl px-6 py-10 lg:py-20">
            <header class="flex flex-col items-center justify-center mb-10">
                <ApplicationLogo class="h-32 lg:h-40"/>
            </header>

            <main class="bg-white rounded-lg p-8 shadow-lg">
                <h1 class="text-3xl font-bold mb-4">Orientacinės varžybos</h1>
                <p class="text-lg mb-6">rugsėjo 4 d. 13:00 - 15:30</p>

                <div class="space-y-4">
                    <p>Labas, dalyvi (-e)!</p>
                    <p>Prieš pradėdami žaisti, šias sąlygas privalote įgyvendinti visose užduotyse. Užduotys, kurių
                        atsakymuose šios sąlygos nebus įgyvendintos, žaidimo vertintojai vertins 0 taškų.</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Kiekvienoje nuotraukoje privaloma laikyti batoną. (Pavyzdys pateiktas žemiau esančioje
                            nuotraukoje.) Batonas privalo būti tikras, batonų, rodomų telefone, neužskaitysime.
                            <img src="/storage/example.png" alt="Batonas" class="mx-auto mt-4"/>
                        </li>
                        <li>Visose įkeltose nuotraukose privalo būti matomas TAS PATS KOMANDOS NARYS. Nuotraukose,
                            kuriose yra kitas žmogus - neužskaitysime. Pastebėjus sukčiavimą, specialiai
                            piktnaudžiaujanti komanda bus diskvalifikuota.
                        </li>
                    </ul>
                </div>

                <p class="mt-4">Atsakymai priimami iki 15:30</p>
                <p class="mt-2">Sėkmės!</p>

                <div class="flex justify-center">
                    <a :href="route('register')">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-xl">
                            Spausk čia ir pradėk
                        </button>
                    </a>
                </div>
            </main>

            <footer class="mt-10 text-center text-sm text-gray-500">
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
