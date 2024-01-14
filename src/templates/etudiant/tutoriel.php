<?php

?>

<main class="container mx-auto p-8">
    <div class="bg-gray-100 p-8 rounded-md mb-8 mt-4">
        <h6 class="text-xl font-bold mb-2">Sommaire</h6>
        <ul>
            <li class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-1/4  sm:invisible"><a href="#connexion-etudiant-enseignant">Connexion Étudiant ou Enseignant</a></li>
            <li class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-1/4  sm:invisible"><a href="#connexion-entreprise">Connexion Entreprise</a></li>
            <li class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 w-1/4  sm:invisible"><a href="#inscription-entreprise">Inscription Entreprise</a></li>
        </ul>
    </div>

    <div  class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <section class="mb-8">
                <h10 class="text-2xl font-bold mb-4">Tutoriel Etudiant</h10>
            </section>
            <p class="text-lg  text-gray-700 mb-4">Vous êtes désormais connecté en tant qu'étudiant, sur Stageo votre but sera de candidater pour des offres de stage ou d'alternance, de poster une convention, et de gérer vos candidatures et vos conventions. Ici, vous pourrez suivre le processus étape par étape.</p>
        </div>
    </div>

    <div id="candidature" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Candidater à une offre</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour candidater à une offre, rendez-vous sur la page d'accueil du site et cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Offres"</span> en <span style="font-weight: bold; color: #000000;">haut de la page</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_offre.png" alt="Emplacement du bouton">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page des offres. Vous y trouverez différentes options pour filtrer votre recherche d'offre. Une fois vos préférences entrées, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Recherche"</span> puis sélectionnez l'offre qui vous intéresse.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/bouton_recherche.png" alt="Bouton de lancement de la recherche">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Vous pouvez également voir un bouton <span style="font-weight: bold; color: #000000;">"Entreprises"</span> vous menant à une page vous permettant de rechercher des entreprises proposant des offres.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/indication_entreprise.png" alt="Bouton menant à la recherche d'entreprises">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Une fois que vous avez trouvé une offre sur laquelle vous souhaitez postuler, cliquez sur le bouton<span style="font-weight: bold; color: #000000;"> "POSTULER"</span> en bas de l'offre.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/bouton_postuler.png" alt="Bouton pour postuler">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Vous serez alors redirigé sur un formulaire vous demandant de fournir un CV et une lettre de motivation ainsi qu'un éventuel commentaire. Une fois celà fait, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Postuler"</span>.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/formulaire_postuler.png" alt="Formulaire de postulation">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Vous avez désormais réussi à postuler pour une offre, mais rien ne vous empêche de postuler pour une autre.</p>
        </div>
    </div>

    <div id="consulterCandidature" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Consulter ses candidatures</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour consulter vos candidatures, cliquez sur le bouton de votre profil, puis sur  <span style="font-weight: bold; color: #000000;">"Mes Candidatures"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_candidature.png" alt="Emplacement du bouton">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-lg  text-gray-700 text-left">Vous pouvez alors consulter vos candidatures, et voir leur statut. Vous pouvez également cliquer directement sur une de vos candidatures pour voir les détails liés à l'offre</p>
        </div>
    <div class="md:w-1/2 flex justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="assets/img/liste_candidatures.png" alt="Liste des candidatures">
        </div>
    </div>
    </div>

    <div id="creerConvention" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Créer et déposer une convention</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
    <div class="md:w-1/2 md:mr-8">
        <div class="space-y-4">
            <p class="text-lg  text-gray-700 text-left">Pour créer une convention, cliquez sur le bouton de votre profil, puis sur <span style="font-weight: bold; color: #000000;">"Déposer ou modifier une convention"</span>.</p>
        </div>
    </div>
    <div class="md:w-1/2 flex justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="assets/img/indication_convention_enregistrer.png" alt="Emplacement du bouton pour les conventions">
        </div>
    </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4 text-lg text-gray-700 text-left">
                <p>Vous pouvez alors voir le formulaire de création de convention, il se sépare en quatre étapes avec différents champs à remplir. Une fois une partie terminée, cliquez sur <span style="font-weight: bold; color: #000000;">"Suivant"</span> pour passer à la suite.</p>
                <br>
                <p>Sachez que si vous quittez la page, mais que vous n'avez pas terminé, vous pouvez revenir plus tard pour continuer. Notez également que chaque champ possédant une "*" est <span style="font-weight: bold; color: #000000;">obligatoire</span>.</p>
                <br>
                <p>Une fois toutes les étapes terminées, cliquez sur <span style="font-weight: bold; color: #000000;">"Enregistrer comme brouillon"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
        <table>
            <tr>
                <td>
                    <img src="assets/img/formulaire_convention_1.png" alt="Formulaire page 1">
                </td>
                <td>
                    <img src="assets/img/formulaire_convention_2.png" alt="Formulaire page 2">
                </td>
            </tr>
            <tr>
                <td>
                    <img src="assets/img/formulaire_convention_3.png" alt="Formulaire page 3">
                </td>
                <td>
                    <img src="assets/img/formulaire_convention_4.png" alt="Formulaire page 4">
                </td>
            </tr>
        </table>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-lg text-gray-700 text-left">Vous allez être ensuite redirigé vers l'accueil. Pour déposer votre convention, cliquez sur le bouton de votre profil, puis sur <span style="font-weight: bold; color: #000000;">"Soumettre ma convention"</span>.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_convention_soumettre.png" alt="Emplacement du bouton pour soumettre la convention">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Vous avez désormais réussi à créer et déposer une convention, mais rien ne vous empêche d'en créer une autre.</p>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Si vous avez un soucis, n'hésitez pas à nous contacter sur notre page "Contact".</p>
        </div>
    </div>
</main>
