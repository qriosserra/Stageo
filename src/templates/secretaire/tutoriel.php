<?php

?>

<main class="container mx-auto p-8 mt-[6rem]">

    <div class="flex flex-col-reverse  md:flex-row">
        <div class="md:w-1/3  rounded-lg p-4">
            <h6 class="mb-4 text-lg font-bold">Sommaire des tutos</h6>
            <ul class="space-y-2">
                <li><a href="#etudiant" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Gérer les étudiants</a></li>
                <li><a href="#entreprise" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Gérer les entreprises</a></li>
                <li><a href="#admin" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">Gérer les admins</a></li>
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
                <h10 class="text-2xl font-bold mb-4">Tutoriel Secretaire/Admin</h10>
            </section>
            <p class="text-lg  text-gray-700 mb-4">Vous êtes désormais connecté en tant que Secretaire ou Admin. Votre but est de gérer différents aspects logistiques du site tel que, les étudiants, les entreprises, les offres, et les autres comptes admins. Ici, vous pourrez suivre le processus étape par étape.</p>
        </div>
    </div>
    <div id="etudiant" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Gérer les étudiants</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour gérer les étudiants, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Gestion etudiants"</span>.</p>
                <br>
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de gestion des étudiants. Vous pourrez y voir la liste des étudiants inscrits sur le site.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_GestionEtudiant.png" alt="Emplacement du bouton Gestion Etudiant">
            </div>
        </div>
    </div>
    <div id="entreprise" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Gérer les entreprises</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour valider les entreprises, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Entreprises à valider"</span>.</p>
                <br>
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de gestion des entreprises. Vous pourrez y voir la liste des entreprises inscrites sur le site.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_ListeEntreprises.png" alt="Emplacement du bouton Liste Entreprises">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour valider une entreprise, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Valider"</span> de l'entreprise que vous souhaitez valider.Si vous souhaitez au contraire supprimer l'entreprise, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Supprimer"</span> en indiquant une raison de refus.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_ValiderEntreprise.png" alt="Emplacement du bouton Valider Entreprise">
            </div>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Ceci nous redirige ensuite vers la page de validation des offres de l'entreprise.</p>
            <p class="text-lg  text-gray-700 mb-4">La gestion des offres se fait de la même manière que pour les entreprises, à ceci près qu'il n'est possible de commencer à gérer les offres d'une entreprise qu'après avoir validé cette dernière.</p>
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Si vous avez décidé de supprimer l'entreprise, un mail lui sera envoyé pour l'informer du refus, et elle sera placée en archive. Vous pouvez accéder à la liste des entreprises archivées en cliquant sur le bouton <span style="font-weight: bold; color: #000000;">"Entreprises archivées"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_EntreprisesArchive.png" alt="Emplacement du bouton Entreprises Archive">
            </div>
        </div>
    </div>
    <div id="admin" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-2xl font-bold text-gray-700">Gérer les admins</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Si vous souhaitez ajouter un admin, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Ajouter des Admin"</span>.</p>
        </div>
    </div>
    <div class="md:w-1/2 flex justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="assets/img/indication_AjouterAdmin.png" alt="Emplacement du bouton Ajouter Admin">
        </div>
    </div>
</div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page d'ajout d'admin. Remplissez le formulaire et cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"S'inscrire"</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/indication_FormulaireAdmin.png" alt="Formulaire d'ajout d'admin">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Si vous souhaitez supprimer un admin, cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Supprimer des Admin"</span>.</p>
        </div>
    </div>
    <div class="md:w-1/2 flex justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="assets/img/indication_SupprimerAdmin.png" alt="Emplacement du bouton Supprimer Admin">
        </div>
    </div>
</div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de suppression d'admin avec la liste de tous les admins. Cliquez sur <span style="font-weight: bold; color: #000000;">"Révoquer"</span> pour supprimer le compte administrateur de la liste.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/indication_SupprimerAdminListe.png" alt="Liste des admins">
        </div>
    </div>
</main>





