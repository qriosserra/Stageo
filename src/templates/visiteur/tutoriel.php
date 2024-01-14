<?php
// ...
?>
<style>
    html {
    scroll-behavior: smooth;
}
</style>
<main class="container mx-auto p-8 mt-[6rem]">
    <!-- Table of Contents -->



    <div class="flex flex-col-reverse  md:flex-row">
        <div class="md:w-1/3  rounded-lg p-4">
            <h6 class="mb-4 text-lg font-bold">Sommaire des tutos</h2>
            <ul class="space-y-2">
                <li><a href="#connexion-etudiant-enseignant" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">1) Connexion Étudiant ou Enseignant</a></li>
                <li><a href="#connexion-entreprise" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">2) Connexion Entreprise</a></li>
                <li><a  href="#inscription-entreprise" class="bg-gray-200 border-2 ring-offset-background focus-visible:ring-ring border-input bg-background hover:bg-accent hover:text-accent-foreground inline-flex h-10 w-full items-center justify-center rounded-md  px-4 py-2 text-left text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">3) Inscription Entreprise</a></li>
            </ul>
        </div>
        <div class="md:w-2/3 p-4">
            <h2 class="mb-4 text-2xl font-bold">Sections</h2>
            <p class="text-gray-600">Cliquez sur n'importe qu'elle section pour être rediriger vers cette dernière. </p>
        </div>
    </div>


    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <section class="mb-8">
                <h10 class="text-2xl font-bold mb-4">Tutoriel de connexion</h10>
            </section>
            <p class="text-lg  text-gray-700 mb-4">Vous êtes un étudiant, un enseignant ou une entreprise et vous ne savez pas comment vous connecter à votre compte ? Suivez ce tutoriel.</p>
        </div>
    </div>

    <div id="connexion-etudiant-enseignant" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-3xl font-bold text-gray-700 underline mt-[4rem]">1) Connexion Étudiant ou Enseignant</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour vous connecter à votre compte LDAP, rendez-vous sur la page d'accueil du site et cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Connexion"</span> en <span style="font-weight: bold; color: #000000;">haut à droite de la page</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/indication_connexion.png" alt="Emplacement du bouton">
                <img src="assets/img/bouton_connexion.png" alt="Bouton de connexion">
            </div>
        </div>
    </div>

    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de connexion. Entrez votre identifiant et votre mot de passe LDAP puis cliquez sur le bouton <span style="font-weight: bold; color: #000000;">"Connexion"</span>.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/formulaire_connexion.png" alt="Page de connexion">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Si vous avez perdu vos identifiants LDAP, veuillez contacter le secrétariat de votre établissement.</p>
        </div>
    </div>
    <div id="connexion-entreprise" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-3xl font-bold text-gray-700 underline mt-[4rem] ">2) Connexion Entreprise</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour vous connecter à votre compte entreprise, rendez-vous sur la page d'accueil du site et cliquez sur <span style="font-weight: bold; color: #000000;">"Connexion Entreprise"</span> en bas de la page.</p>
                <br>
                <p class="text-lg text-gray-700 text-left"> <span style="font-weight: bold; color: #000000;">Si vous n'avez pas encore de compte allez dans la section dédiée.</span></p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/connexion_entreprise.png" alt="Emplacement du lien">
            </div>
        </div>
    </div>

    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page de connexion. Entrez vos identifiants et <span style="font-weight: bold; color: #000000;">cliquez sur le bouton connexion</span>.
                Vous pouvez cocher la case <span style="font-weight: bold; color: #000000;">"Rester connecté ?"</span> si vous voulez être connecté d'office à votre prochaine visite du site, ou cliquez sur <span style="font-weight: bold; color: #000000;">"Mot de passe oublié ?"</span> pour réinitialiser votre mot de passe.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/formulaire_connexion_entreprise.png" alt="Page de connexion">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Si vous n'avez pas encore de compte entreprise, suivez les étapes suivantes :</p>
        </div>
    </div>
    <div id="inscription-entreprise" class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <h4 class="text-3xl font-bold text-gray-700 underline mt-[4rem] ">3) Inscription Entreprise</h4>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center mb-8">
        <div class="md:w-1/2 md:mr-8">
            <div class="space-y-4">
                <p class="text-lg  text-gray-700 text-left">Pour inscrire un compte pour votre entreprise, rendez-vous sur la page d'accueil du site et cliquez sur<span style="font-weight: bold; color: #000000;"> "Créer son compte Entreprise"</span> en <span style="font-weight: bold; color: #000000;">bas de la page</span>.</p>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img src="assets/img/inscription_entreprise.png" alt="Emplacement du lien">
            </div>
        </div>
    </div>

    <div class="bg-gray-100 p-8 rounded-md flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 md:mr-8">
            <p class="text-lg  text-gray-700 text-left">Vous serez redirigé vers la page d'inscription. Entrez toutes les informations nécessaires dans les quatres pages présentes. Cliquez sur <span style="font-weight: bold; color: #000000;">"Suivant"</span> lorsque toutes les informations obligatoires d'une page auront été entrées. Une fois toutes les pages remplies, cliquez sur <span style="font-weight: bold; color: #000000;">"S'inscrire"</span>. </p>
            <br>
            <p class="text-lg  text-gray-700 text-left"> Vous allez normalement recevoir un <span style="font-weight: bold; color: #000000;">mail</span> vous permettant de valider la création du compte.</p>
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/formulaire_inscription_entreprise.png" alt="Page d'inscription entreprise">
        </div>
        <div class="md:w-1/2 flex justify-center items-center">
            <img src="assets/img/inscription_etape4_entreprise.png" alt="Dernière page d'inscription">
        </div>
    </div>
    <div class="bg-gray-100 p-8 rounded-md flex flex-col items-center mb-8">
        <div class="md:w-1/2 md:mr-8 text-center">
            <p class="text-gray-800 font-bold">Vous voilà désormais connecté à votre compte Entreprise.</p>
        </div>
    </div>
</main>