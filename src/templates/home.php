<?php

use Stageo\Model\Object\Categorie;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Offre;

include "macros/button.php";
include "macros/input.php";
include "macros/offre.php";
/**
 * @var Categorie[] $categories
 * @var Etudiant $etudiant
 * @var Offre[] $offres
 */
?>

<main class="mt-[8rem]">
    <section class="w-full h-[35rem] sm:h-[29rem] border-b">
        <h1 class="mt-16 text-center font-bold leading-[3rem] font-custom text-gray-700 text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-6xl">
            Tout ce dont vous avez besoin pour tracer<span class="block font-custom text-gray-700">Votre Parcours Professionnel</span>
        </h1>
        <h5 class="petit-text text-neutral-900 mt-9 text-center">
            La plateforme parfaite pour gérer vos Stages/Alternances du BUT2 et BUT3 Informatique.
        </h5>
        <div class="flex flex-row justify-center mt-9 mr-10">
            <img id="cfa" class="w-[20%] h-[20%] ml-[7%] md:w-[15%] md:h-[10%] lg:w-[8%] lg:h-[6%] lg:mr-[2%]" src="assets/img/cfa.png" alt="">
            <img id="iut" class="w-[40%] h-[30%] mt-[3%] md:w-[30%] md:h-[20%] lg:mt-[1%] lg:w-[18%] lg:h-[8%] lg:mr-[2%]" src="assets/img/iut_montpellier_sete.png" alt="">
            <img id="um" class="w-[40%] h-[30%] mt-0 md:w-[30%] md:h-[20%] lg:w-[18%] lg:h-[8%] lg:mt-[1%]" src="assets/img/um.png" alt="">
        </div>
        <span class="petit-text text-neutral-900 block mb-10 ml text-center font-thin ">
            Avec la participation du CFA Sud Montpellier, Univerisité de Montpellier et l'IUT Montpellier/Sète
        </span>
    </section>
    <section class="section-2 w-full md:h-[38rem] mt-[5rem] md:mt-auto h-[64rem] border-b flex flex-col justify-center items-center">
        <div>
            <h4 class="second-titre mt-4 text-center font-bold leading-[3rem]  font-custom text-gray-700
            text-1xl sm:text-2xl md:text-1xl lg:text-2xl xl:text-3xl">
                Préparer votre alternance ou votre stage facilement
            </h4>
            <h6 class="text-center mt-4 sm:text-base text-xs" style="font-family: 'Montserrat',serif;">
                Une plateforme conçue par des étudiants, pensée pour les étudiants, pour gérer tout le processus,
                <br> la découverte de l'offre jusqu'à la signature du contrat.
            </h6>
        </div>
        <div class="rectangle flex justify-between  items-center mt-[2.5rem] mx-auto " style="max-width: 1200px;">
            <div class="flex-1"></div>
            <div class="bg-slate-50 max-w-lg rounded-md h-auto lg:h-[350px] xl:h-[322px]">
                <div class="under-card mt-[2rem] border-r flex flex-col items-center border-gray-400 h-3/4 mb-[2rem]">
                    <i class="fi fi-rr-search mb-3 text-5xl text-gray-700"></i>
                    <h2 class="mt-2 font-custom text-2xl font-medium text-gray-700">Trouver une offre</h2>
                    <p class="petit-text text-neutral-900 text-center m-5">
                        Démarrez votre carrière avec précision. Utilisez nos filtres détaillés et trouvez une entreprise qui partage vos valeurs et vos aspirations.
                    </p>
                </div>
            </div>
            <div class="bg-slate-50 max-w-lg h-auto lg:h-[350px] xl:h-[322px]">
                <div class=" under-card mt-[2rem] border-r flex flex-col items-center border-gray-400 h-3/4  mb-[2rem]">
                    <i class="fi fi-rs-comments mb-3 text-5xl text-gray-700"></i>
                    <h2 class="mt-2 font-custom text-2xl font-medium text-gray-700">Discuter avec l'employeur</h2>
                    <p class="petit-text text-neutral-900 text-center m-5">
                        Communiquez directement sur notre plateforme avec les entreprises, le CFA, les services administratifs et nos administrateurs. Tout cela depuis notre site !
                    </p>
                </div>
            </div>
            <div class="bg-slate-50 max-w-lg rounded-md h-auto lg:h-[350px] xl:h-[322px]">
                <div class="under-card mt-[2rem] flex flex-col items-center h-3/4  mb-[2rem]">
                    <i class="fi fi-rr-document-signed mb-3 text-5xl text-gray-700"></i>
                    <h2 class="mt-2 font-custom text-2xl font-medium text-gray-700">Signez le contrat</h2>
                    <p class="petit-text text-neutral-900 text-center m-5 ">
                        Gérez aisément vos contrats/conventions directement ici. Téléchargez, envoyez vos documents pour signature, le tout dans un espace sécurisé.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="mt-[8rem] sm:mt-auto">
        <div class="container px-6 py-12 mx-auto">
            <h1 class="text-2xl font-semibold text-center text-gray-800 lg:text-3xl md ">Les questions récurrentes</h1>
            <div class="mt-8 xl:mt-16 lg:flex lg:-mx-12">
                <div class="faq-section flex-1 mt-8 lg:mx-12 lg:mt-0" id="general">
                    <div>
                        <button class="flex items-center focus:outline-none" onclick="toggleContent('faq1')">
                            <i class="fi fi-br-plus flex-shrink-0 w-6 h-6 text-blue-500"></i>
                            <span class="mx-4 text-xl">Quelles sont les dates du stage/alternance ?</span>
                        </button>
                        <div class="hiddene transition-all duration-500 ease-in-out mt-8 md:mx-10 toggleable-content" id="faq1">
                            <span class="border border-blue-500"></span>
                            <br> BUT2: 10 semaines minimum du 8 avril au 15 juin 2024 (extensible au 5 Juillet voir FAQ) <br>

                            BUT3: 16 semaines minimum du 25 Mars  au 12 juillet 2024 (extensible au 28 Aout).
                            <p class="max-w-3xl px-4">
                                <br>Pour l'alternance : <br>
                                <span class="ml-4">22 à 26 semaines</span>
                            </p>
                            <br>
                            <p class="max-w-3xl px-4">
                                Pour le stage :
                                <br>
                                <span class="ml-4">BUT2: 10 semaines minimum du 8 avril au 15 juin 2024 (extensible au 5 Juillet voir FAQ)</span>
                                <br>
                                <span class="ml-4">BUT3: 16 semaines minimum du 25 Mars  au 12 juillet 2024 (extensible au 28 Aout).</span>
                            </p>
                        </div>
                    </div>
                    <hr class="my-8 border-gray-200 dark:border-gray-700">
                    <div>
                        <button class="flex items-center focus:outline-none" onclick="toggleContent('faq2')">
                            <i class="fi fi-br-plus flex-shrink-0 w-6 h-6 text-blue-500"></i>
                            <span class="mx-4 text-xl ">Quels sont les gratifications ?</span>
                        </button>
                        <div class="hiddene transition-all duration-500 ease-in-out mt-8 md:mx-10 toggleable-content" id="faq2">
                            <span class="border border-blue-500"></span>
                            <p class="max-w-3xl px-4">
                                En première année en alternance, le montant de la rémunération peut varier de 27% à 100% du salaire minimum interprofessionnel de croissance (SMIC), en fonction de l'âge de l'alternant. Ainsi, pour les moins de 18 ans, la rémunération représente 27% du SMIC, pour ceux âgés de 18 à 20 ans, elle est de 43%, pour ceux de 21 à 25 ans, elle s'élève à 53%, et enfin, pour les alternants de 26 ans et plus, la rémunération atteint 100% du SMIC.
                            </p>
                            <br>
                            <p class="max-w-3xl px-4">
                                Pour un stage cette rémunération s'élèvera à 4.05euros par heures en général étant la gratification minimale est exonérée de cotisations sociales
                            </p>
                        </div>
                    </div>
                    <hr class="my-8 border-gray-200 dark:border-gray-700">
                    <div>
                        <button class="flex items-center focus:outline-none" onclick="toggleContent('faq3')">
                            <i class="fi fi-br-plus flex-shrink-0 w-6 h-6 text-blue-500"></i>
                            <span class="mx-4 text-xl ">Quel type de contrat est proposé pour le stage/alternance ?</span>
                        </button>
                        <div class="hiddene transition-all duration-500 ease-in-out mt-8 md:mx-10 toggleable-content" id="faq3">
                            <span class="border border-blue-500"></span>
                            <p class="max-w-3xl px-4  ">
                                Stage:<br>
                                <br>
                                Bien que le contrat de stage ne soit pas juridiquement assimilé à un contrat de travail, contrairement à ce dernier, il implique la participation de trois parties signataires et comporte une rémunération moindre. Cependant, il offre toujours certains avantages, tels que le remboursement des frais de transport.
                            </p>
                            <br>
                            <p class="max-w-3xl px-4 ">
                                Alternance: <br>
                                <br>
                                Le contrat d’apprentissage peut être conclu en CDD (contrat à Durée Déterminée) pour une durée de 1 à 3 ans ou signé en CDI (Contrat à Durée Indéterminée).

                                La durée minimale de la formation en apprentissage est de 1 an à raison de 400 heures de formation minimum. Dans le cadre d’un CDI, la durée de la formation ne peut excéder 3 ans.
                            </p>
                        </div>
                    </div>
                    <hr class="my-8 border-gray-200 dark:border-gray-700">
                    <div>
                        <button class="flex items-center focus:outline-none" onclick="toggleContent('faq4')">
                            <i class="fi fi-br-plus flex-shrink-0 w-6 h-6 text-blue-500"></i>
                            <span class="mx-4 text-xl ">À quelles conditions un employeur peut-il avoir recours à un stagiaire ?</span>
                        </button>
                        <div class="hiddene transition-all duration-500 ease-in-out mt-8 md:mx-10 toggleable-content" id="faq4">
                            <span class="border border-blue-500"></span>
                            <h2 class="mb-2 text-lg">Un stage d'étudiant ne peut pas être proposé pour les missions suivantes :</h2>
                            <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                <li>
                                    Remplacer un salarié en cas d'absence, de suspension de son contrat de travail ou de licenciement
                                </li>
                                <li>
                                    Exécuter une tâche régulière correspondant à un poste de travail permanent (le stagiaire n'a pas d'obligation de production comme un salarié)
                                </li>
                                <li>
                                    Faire face à un accroissement temporaire d'activité
                                </li>
                                <li>
                                    Occuper un emploi saisonnier
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr class="my-8 border-gray-200 dark:border-gray-700">
                    <div>
                        <button class="flex items-center focus:outline-none" onclick="toggleContent('faq5')">
                            <i class="fi fi-br-plus flex-shrink-0 w-6 h-6 text-blue-500"></i>
                            <span class="mx-4 text-xl">
                                Dans quels cas peut-on rompre un contrat d’apprentissage ?
                            </span>
                        </button>
                        <div class="hiddene transition-all duration-500 ease-in-out mt-8 md:mx-10 toggleable-content" id="faq5">
                            <span class="border border-blue-500"></span>
                            <p class="max-w-3xl px-4">
                                En principe, le contrat prend fin à son terme s’il est conclu en CDD pour la durée de la formation. S’il est conclu en CDI, les règles communes de rupture du contrat à durée déterminée s’appliquent.

                                Il existe différents cas de rupture du contrat d’apprentissage :

                                Avant échéance de la période d’essai, employeur ou apprenti peuvent rompre le contrat sans justificatif précis.
                                Après la période d’essai, la rupture peut être conclue d’un commun accord entre l’employeur et l’apprenti ou par décision unilatérale de l’un deux.
                                L’employeur peut rompre le contrat pour faute grave de l’apprenti ou inaptitude à exercer ses fonctions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        @media screen and (min-width: 768px) and (max-width: 784px) {
            .section-2 {
                margin-top: 10rem;
            }
        }
        .hiddene {
            display: none;
            transition: all 0.5s ease-in-out;
        }
    </style>
</main>