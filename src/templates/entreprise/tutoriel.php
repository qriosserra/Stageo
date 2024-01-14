<?php

?>

<main class="container mx-auto p-8 mt-[6rem]">

    <div class="flex flex-col-reverse  md:flex-row">
        <div class="md:w-1/3  rounded-lg p-4">
            <h6 class="mb-4 text-lg font-bold">Sommaire des tutos</h6>
            <ul class="space-y-2">
                <li><a href="#offre" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Créer une offre</a></li>
                <li><a href="#candidature" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Consulter les candidatures</a></li>
            </ul>
        </div>
        <div class="md:w-2/3 p-4">
            <h2 class="mb-4 text-2xl font-bold">Sections</h2>
            <p class="text-gray-600">Cliquez sur n'importe quelle section pour être redirigé vers cette dernière. </p>
        </div>
    </div>

    <div  class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <section class="mb-8">
                <h10 class="text-2xl font-bold mb-4">Tutoriel Entreprise</h10>
            </section>
            <p class="text-lg  text-gray-700 mb-4">Vous êtes désormais connecté en tant qu'Entreprise. Votre but est de créer des offres de stage ou d'alternance pour les étudiants. Vous pouvez également consulter les candidatures faites sur vos offres.  Ici, vous pourrez suivre le processus étape par étape.</p>
        </div>
    </div>
    <div id="offre" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Créer une offre</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour créer une offre, rendez-vous sur la page d'accueil du site et cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Espace Offre"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_EspaceOffre.png" alt="Emplacement du bouton Espace Offre">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de recherche d'offres, vous trouverez tout en bas un bouton <span style="font-weight: bold; color: #000000;">"Ajouter une Offre"</span>. Cliquez dessus.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/indication_AjouterOffre.png" alt="Emplacement du bouton pour ajouter une offre">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de création d'offre. Remplissez le formulaire et cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Publier"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/indication_FormulaireOffre.png" alt="Formulaire de création d'offre">
        </div>
    </div>
    <div id="candidature" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Consulter les candidatures</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour consulter les candidatures, cliquez sur votre profil puis sur <span style="font-weight: bold; color: #000000;">"Candidats Offres"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_Candidatures.png" alt="Emplacement du bouton Espace Offre">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de consultation des candidatures. Vous pouvez accepter les candidatures en cliquant sur le bouton <span style="font-weight: bold; color: #000000;">"Accepter"</span>.</p>
                <br>
                <p class="text-lg  text-gray-700 text-left">Vous pouvez également télécharger le CV de l'étudiant en cliquant sur le bouton <span style="font-weight: bold; color: #000000;">"Télécharger le CV"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
                <img src="assets/img/indication_ConsultationCandidatures.png" alt="liste des offres">
        </div>
    </div>
</main>