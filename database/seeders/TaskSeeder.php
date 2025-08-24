<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => '1 Užduotis / Task 1',
                'description' => 'Įkelkite VISOS KOMANDOS nuotrauką, visi turi šypsotis taip, tarsi būtumėte ką tik laimėję milijoną! / Upload a photo of the WHOLE TEAM, all smiling as if you\'ve just won a million!',
                'points' => 50,
                'image_path' => 'task-images/1.png',
            ],
            [
                'title' => '2 Užduotis / Task 2',
                'description' => 'Nusifotografuokite prie pastato, kuriame GALIMAI buvo apsistojęs Napoleonas. / Take a photo in front of the building where Napoleon MAY have stayed.',
                'points' => 60,
            ],
            [
                'title' => '3 Užduotis / Task 3',
                'description' => 'Susipažinkite su folkloro ansambliu "Uosinta" ir atlikite jų užduotį. / Meet the folk ensemble "Uosinta" and complete their task.',
                'points' => 70,
            ],
            [
                'title' => '4 Užduotis / Task 4',
                'description' => 'Fakulteto kieme raskite smiginį su atstovu ir atlikite jo skirtą užduotį. / Find the dartboard with the representative in the faculty courtyard and complete the task assigned to you.',
                'points' => 70,
            ],
            [
                'title' => '5 Užduotis / Task 5',
                'description' => 'Raskite paslėptą fakulteto dėstytojo Roberto Kudirkos nuotrauką ir nusifotografuokite. / Find the hidden photo of faculty lecturer Robertas Kudirka and take a picture of yourself with it.',
                'points' => 60,
            ],
            [
                'title' => '6 Užduotis / Task 6',
                'description' => 'Raskite šachmatų atstovus ir atlikite jų skirtą užduoti. / Find the chess representatives and complete the task assigned by them.',
                'points' => 70,
            ],
            [
                'title' => '7 Užduotis / Task 7',
                'description' => 'Susitikite su fakulteto laikraščio "Visažinis" atstovais atlikite jų sugalvotą užduotį. / Meet with representatives of the faculty newspaper Visažinis and complete the task they have set for you.',
                'points' => 70,
            ],
            [
                'title' => '8 Užduotis / Task 8',
                'description' => 'Susitikite su fakulteto debatų klubo atstovais ir atlikite jų skirtą užduotį. / Meet with representatives of the faculty debate club and complete the task they have set for you.',
                'points' => 70,
            ],
            [
                'title' => '9 Užduotis / Task 9',
                'description' => 'Raskite "šviečiančią akį" ir nusifotografuokite. / Find the "shining eye" and take a photo.',
                'points' => 60,
                'image_path' => 'task-images/9.jpg',
            ],
            [
                'title' => '10 Užduotis / Task 10',
                'description' => 'Užduotis, kuri pareikalaus šiek tiek sėkmės. Jūsų užduotis - rasti ir nusifotografuoti su realiu VW Beetle markės automobiliu. / A task that will require some luck. Your task is to find and take a photo with a real VW Beetle.',
                'points' => 150,
                'image_path' => 'task-images/10.png',
            ],
            [
                'title' => '11 Užduotis / Task 11',
                'description' => 'Prisėskite šalia kunigo, rašytojo J. Tumo-Vaižganto ant suoliuko, kurio paminklas stovi šalia bažnyčios, kurioje prieš mirtį dirbo šis lietuvybės puoselėtojas ir pasidarykite nuotrauką. / Sit next to the priest, writer J. Tumas-Vaižgantas on the bench, whose monument stands next to the church where this promoter of Lithuanian identity worked before his death, and take a photo.',
                'points' => 100,
                'image_path' => 'task-images/11.jpg',
            ],
            [
                'title' => '12 Užduotis / Task 12',
                'description' => 'Kaunas garsėja gatvės menu. Raskite šį senolį su pypke ir pasidarykite nuotrauką. / Kaunas is famous for its street art. Find this old man with a pipe and take a photo.',
                'points' => 40,
                'image_path' => 'task-images/12.png',
            ],
            [
                'title' => '13 Užduotis / Task 13',
                'description' => 'Prisiminkime aklųjų raštą! Jūsų užduotis - iššifruoti kas čia parašyta ir nusifotografuoti prie reikalingo objekto. Ši vieta ypatingai mėgstama studentų:)) / Remember the writing of the blind! Your task is to decipher what it says and take a picture of the object. This place is especially popular for students:))',
                'points' => 100,
                'image_path' => 'task-images/13.png',
            ],
            [
                'title' => '14 Užduotis / Task 14',
                'description' => 'Taškus už šį klausimą gaus tik ta komanda, kuri padarys išskirtiniausią selfie prie šio objekto. / Only one team, that makes the most unique selfie near this object (must be visible in the picture), gets the points for this question.',
                'points' => 50,
                'image_path' => 'task-images/14.jpg',
            ],
            [
                'title' => '15 Užduotis / Task 15',
                'description' => 'Santakoje susipažinkite su fakulteto krepšinio komandos atstovais ir atlikite jų skirtą užduotį / Meet the representatives of the faculty basketball team in Santaka and complete the task they have set for you.',
                'points' => 70,
            ],
            [
                'title' => '16 Užduotis / Task 16',
                'description' => 'Jūsų užduotis - nusifotografuoti gulint prekybos centro daržovių skyriuje ant grindų, "starfish" pozoje, kaip pavaizduota nuotraukoje. Tai gali būti bet kokia parduotuvė, turinti daržovių skyrių. Fotografuotojas turi daryti nuotrauką iš viršaus, kur būtų aiškiai matomos daržovės aplinkui bei matytųsi fotografuojamas asmuo visu kūnu. / Your task is to be photographed lying on the floor in the vegetable section of the supermarket, in the starfish pose as shown in the photo. This can be any shop with a vegetable section. The photographer must take the photo from above, with a clear view of the surrounding vegetables and a full body view of the subject.',
                'points' => 150,
                'image_path' => 'task-images/16.png',
            ],
            [
                'title' => '17 Užduotis / Task 17',
                'description' => 'Sena patarlė sako: "Prieš smerkdamas kitų žmonių trūkumus, pasižiūrėk į savo batų pėdsakus." Taigi, pasimatuokite kito batus. Nepamirškite nuotraukos. / An old proverb says: "Before you condemn other people\'s shortcomings, look at your own footprints." So, try on someone else\'s shoes. Don\'t forget to take a photo.',
                'points' => 90,
                'image_path' => 'task-images/17.jpg',
            ],
            [
                'title' => '18 Užduotis / Task 18',
                'description' => 'Suraskite gyvūną (paukštis netinka) ir nusifotografuokite su juo. / Find an animal (bird is not suitable) and take a photo with it.',
                'points' => 100,
            ],
            [
                'title' => '19 Užduotis / Task 19',
                'description' => 'Iššifruokite žemiau esantį tekstą:<br>Vs lbh tvir n zna n svfu, lbh srrq uvz sbe n qnl. Vs lbh grnpu n zna gb svfu, lbh srrq uvz sbe n yvsrgvzr. / Decode the text below:<br>Vs lbh tvir n zna n svfu, lbh srrq uvz sbe n qnl. Vs lbh grnpu n zna gb svfu, lbh srrq uvz sbe n yvsrgvzr.',
                'points' => 90,
                'image_path' => 'task-images/19.jpg',
            ],
            [
                'title' => '20 Užduotis / Task 20',
                'description' => 'Ne vienas fakulteto dėstytojas yra teigiamai atsiliepęs apie šią vietą, raskite šią vietą ir nusifotografuokite prie jos durų! / A number of faculty members have spoken positively about this place, find this place and take a photo at the door!',
                'points' => 80,
                'image_path' => 'task-images/20.png',
            ],
            [
                'title' => '21 Užduotis / Task 21',
                'description' => 'Raskite Rotušės aikštėje Vilniaus universiteto Studentų atstovybės Kauno fakultete narį, pasidabinusį fakulteto atributika ir atlikite jo skirtą užduotį. / Find a member of the Vilnius University Students\' Representation at the Kaunas Faculty in Rotušės Square, dressed in faculty attire, and complete the task assigned to you.',
                'points' => 70,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
