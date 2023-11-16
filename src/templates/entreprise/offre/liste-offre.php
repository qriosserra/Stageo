<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";
/**
 * @var Categorie[] $categories
 * @var Etudiant $etudiant
 * @var Offre[] $offres
 * @var string $selA
 * @var string $selB
 * @var string $selC
 * @var string $search
 * @var Categorie $Categories
 */
?>

<style>
    /* Toggle A */
    #toggleA:checked~.dot {
      transform: translateX(100%);
      background-color: #48bb78;
    }

    /* Toggle B */
    #toggleB:checked~.dot {
      transform: translateX(100%);
      background-color: #48bb78;
    }

    .text-shadow {
      text-shadow: -0.5px -0.5px 0 #000, 0.5px -0.5px 0 #000, -0.5px 0.5px 0 #000, 0.5px 0.5px 0 #000;
    }


  </style>
</head>

<body class="bg-slate-50">


  <nav class="bg-white border-b border-gray-200  ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="assets/img/logo.png" class="h-8" alt="Stageo logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
      </a>
      <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <button type="button"
          class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
          id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
          data-dropdown-placement="bottom">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-3.jpg" alt="user photo"> 
          <!-- //TODO : Photo -->
        </button>
        <!-- Dropdown menu -->
        <div
          class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
          id="user-dropdown">
          <div class="px-4 py-3">
            <span class="block text-sm text-gray-900 dark:text-white">Bonnie Green</span>
            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span> 
            <!-- //TODO : email du mec et tout -->
          </div>
          <ul class="py-2" aria-labelledby="user-menu-button">
            <li>
              <a href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Tableau de bord</a>
            </li>
            <li>
              <a href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Paramètres</a>
            </li>
            <li>
              <a href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Mes Candidatures</a>
            </li>
            <li>
              <a href="#"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Déconnexion</a>
            </li>
          </ul>
        </div>
        <button data-collapse-toggle="navbar-user" type="button"
          class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          aria-controls="navbar-user" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15" />
          </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 lg:mr-32" id="navbar-user">
        <ul
          class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white  dark:border-gray-700">
          <li>
            <a href="#"
              class="block py-2 px-3  bg-blue-700 rounded md:bg-transparent  md:p-0 "
              aria-current="page">Home</a>
          </li>
          <li>
            <a href="#"
              class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0  md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Fonctionnement</a>
          </li>
          <li>
            <a href="#"
              class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0  md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="h-40 flex justify-center items-center"
    style="background: linear-gradient(120deg, rgba(21, 129, 230, 0.75) 0%, rgba(0, 45, 141, 0.75) 50%, rgba(1, 7, 68, 0.75) 100%)">
    <h1 class="text-center font-medium text-white text-3xl text-shadow">
      Des Offres allant du stage à l'Alternance validées par l'IUT !
    </h1>
  </div>
  <div class="container mx-auto px-4 mb-8 mt-12">

    <!-- Search area with two sets of inputs stacked -->
    <form class="flex flex-wrap justify-center gap-6 "  action="<?=Action::LISTE_OFFRE->value?>"  method="post">

      <div class="w-full md:w-1/2 lg:w-2/6">
        <div class="mb-6">
          <label for="job-field" class="block text-sm font-medium text-gray-700">Postes, mots clés, ...</label>
          <input id="job-field" name="job-field"
            class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3"
            type="text" placeholder="Exemples : Développeur web, Devops...">
        </div>

        <div>
          <label for="location-field" class="block text-sm font-medium text-gray-700">Localisation</label>
          <input id="location-field" 
            class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3 transition duration-1000 ease-in-out"
            type="text" placeholder="Exemples : Montpellier, Sète...">

        </div>
      </div>

      <!-- Second column for domain and duration fields -->
      <div class="w-full md:w-1/2 lg:w-2/6">
        <div class="mb-6">
          <label for="domain-field" class="block text-sm font-medium text-gray-700">Secteur</label>
          <select id="domain-field"
            class="mt-1 block w-full rounded-full border-gray-700 border-[1px] shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-lg p-3">
            <option>Sélectionnez vos choix</option>
            <!-- Add other options here -->
          </select>
        </div>
        <h1 class="text-center text-xl font-medium underline-offset-1 ">Afficher les offres :</h1>

        <div class="flex flex-col lg:flex-row items-center justify-center space-x-4 w-full mb-12 ">

          <label for="toggleA" class="flex items-center cursor-pointer mt-4">
            <!-- toggle -->
            <div class="relative">
              <!-- input -->
              <input name="toggleA" id="toggleA" type="checkbox" class="sr-only" />
              <!-- line -->
              <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
              <!-- dot -->
              <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
            </div>
            <!-- label -->
            <div class="ml-0 lg:ml-3 text-gray-700 font-medium">
              Alternances
            </div>
          </label>
          <label for="toggleB" class="flex items-center cursor-pointer mt-4">
            <!-- toggle -->
            <div class="relative">
              <!-- input -->
              <input name="toggleB" id="toggleB" type="checkbox" class="sr-only" />
              <!-- line -->
              <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
              <!-- dot -->
              <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
            </div>
            <!-- label -->
            <div class="ml-0 lg:ml-3 text-gray-700 font-medium mr-4">
              Stages
            </div>
          </label>
        </div>
      </div>
      <div class="w-full flex justify-center">
        <button
            id="search-button"
            class="rounded-lg px-8 py-2 text-xl border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-blue-100 duration-300">
            Recherche
        </button>
      </div>
    </form>


    <!-- Internship offers -->
 
    <div class="text-lg font-semibold mb-4">37550 offres de stage*</div>

    <!-- Offer Cards in a single column -->
    <div class="space-y-4">
      <!-- Card 1 with reserved area for image -->
      <div class="flex border rounded-lg">
        <div class="flex-none w-24 h-24 bg-gray-200" aria-hidden="true"> <!-- Placeholder for image --> </div>
        <div class="p-4 flex-grow">
          <div class="mb-2 font-bold">Assistant communication et événementiel H/F</div>
          <div class="mb-2 text-sm text-gray-600">Klaxit</div>
          <div class="mb-2 text-xs bg-blue-100 text-blue-800 py-1 px-2 rounded">Communication</div>
          <div class="text-xs">6 mois</div>
          <div class="text-xs">Débute le : 01/01/2023</div>
          <a href="#" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">En savoir plus</a>
        </div>
      </div>

      <!-- Card 2 with reserved area for image -->
      <div class="flex border rounded-lg">
        <div class="flex-none w-24 h-24 bg-gray-200" aria-hidden="true"> <!-- Placeholder for image --> </div>
        <div class="p-4 flex-grow">
          <div class="mb-2 font-bold">Stage de pré-embauche - Ingénieur Etudes et Développement Java</div>
          <div class="mb-2 text-sm text-gray-600">Axelor</div>
          <div class="mb-2 text-xs bg-blue-100 text-blue-800 py-1 px-2 rounded">6 mois</div>
          <div class="text-xs">Débute le : 11/11/2023</div>
          <a href="#" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">En savoir plus</a>
        </div>
      </div>
    </div>
  </div>

</body>