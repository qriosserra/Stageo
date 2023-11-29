<?php

/**
 * @var string $nom
 * @var string $prenom
 * @var string $email
 * @var string $annee
 * @var string $tel
 * @var string $fix
 * @var string $Civiliter
 */
?>
<section class="bg-slate-50">
    <div class="flex justify-center lg:justify-start lg:px-4 lg:py-2">
        <div class="flex items-center gap-4">
            <img class="h-10 w-10 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="" />
            <div class="font-medium dark:text-white">
                <div><?= ucfirst($prenom) ?> <?= ucwords($nom) ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Année <?= $annee ?></div>
            </div>
        </div>
    </div>
    <div class="grid w-full grid-cols-1 gap-2 space-y-3 px-4 py-2 lg:space-x-3 lg:space-y-0">
        <div class="auto-cols-auto rounded-lg border border-gray-300 bg-white">
            <div class="flex justify-center border-b">
                <span class="tracking-wide">Profil</span>
            </div>
            <div class="grid grid-cols-1 xl:grid xl:grid-cols-2">
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Nom</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4H1m3 4H1m3 4H1m3 4H1m6.071.286a3.429 3.429 0 1 1 6.858 0M4 1h12a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1Zm9 6.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                            </svg>
                        </div>
                        <input id="email2" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" placeholder="<?= $nom?>" />
                    </div>
                </div>
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Prenom</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z" />
                            </svg>
                        </div>
                        <input id="email2" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" placeholder="<?= $prenom?>" />
                    </div>
                </div>
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Email</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z" />
                            </svg>
                        </div>
                        <input id="Email" class="flex h-10 w-full items-center rounded border border-gray-300 bg-slate-100 pl-16 text-sm font-normal text-gray-600 focus:outline-none" placeholder="<?= $email?>" readonly />
                    </div>
                </div>
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Téléphone</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z" />
                            </svg>
                        </div>
                        <input id="email2" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" placeholder="<?= $tel?>" />
                    </div>
                </div>
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Téléphone Fixe</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z" />
                            </svg>
                        </div>
                        <input id="email2" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" placeholder="<?= $fix?>" />
                    </div>
                </div>
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Civiliter</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M19 0H1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1ZM2 6v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6H2Zm11 3a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8a1 1 0 0 1 2 0h2a1 1 0 0 1 2 0v1Z" />
                            </svg>
                        </div>
                        <select id="prenom" class="flex h-10 w-full items-center rounded border border-gray-300 bg-white pl-16 text-sm font-normal text-gray-600 focus:border focus:outline-none">
                            <option value="M">HOMME</option>
                            <option value="F">FEMME</option>
                            <option value="F">GAY</option>
                        </select>
                    </div>
                </div>
                <div class="px-4 py-2">
                    <span class="font-semibold tracking-wide">Description</span>
                    <div class="flex items-center">
                        <div class="absolute flex items-center border-r px-4 text-gray-600"></div>
                        <textarea id="bio" class="flex h-20 w-full resize-y items-center rounded border border-gray-300 p-2 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" placeholder="Écrivez votre bio ici..."></textarea>
                    </div>
                </div>
            </div>
            <div class="border-t px-4 py-4">
                <div class="mt-2 flex justify-center">
                    <button class="focus:shadow-outline-green mr-2 rounded-lg bg-gradient-to-tr from-green-500 to-green-400 px-4 py-2 font-bold text-white hover:bg-green-600 focus:outline-none" id="saveButton">Sauvegarder</button>
                    <button class="focus:shadow-outline-gray rounded-lg bg-gradient-to-tr from-slate-500 to-slate-400 px-4 py-2 font-bold text-white hover:bg-gray-500 focus:outline-none" id="cancelButton">Annuler</button>
                </div>
            </div>
        </div>
        <div class="auto-cols-auto rounded-lg border border-gray-300 bg-white">
            <div class="flex justify-center border-b">
                <span class="tracking-wide">offres postuler</span>
            </div>
            <div class="grid grid-cols-1 gap-2 px-4 py-4 lg:grid lg:grid-cols-4 lg:space-x-3 lg:space-y-0">
                <div class="flex flex-col items-center rounded-xl border border-slate-200 py-4">
                    <span class="font-bold"> Nom Offre </span>
                    <p>description de l'offre</p>
                    <p>Valider</p>
                    <button class="rounded-xl bg-gradient-to-tr from-blue-600 to-blue-400 bg-clip-border px-4 py-2 text-white shadow-md shadow-blue-500/40 transition-all hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-500">
                        <span class="font-bold">En savoir plus</span>
                    </button>
                </div>
                <div class="flex flex-col items-center rounded-xl border border-slate-200 py-4">
                    <span class="font-bold"> Nom Offre </span>
                    <p>description de l'offre</p>
                    <p>En cours de validation</p>
                    <button class="rounded-xl bg-gradient-to-tr from-blue-600 to-blue-400 bg-clip-border px-4 py-2 text-white shadow-md shadow-blue-500/40 transition-all hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-500">
                        <span class="font-bold">En savoir plus</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
