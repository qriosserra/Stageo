<?php
use Stageo\Lib\enums\Action;
/**
 * @var string $login
 * @var string $nom
 * @var string $prenom
 * @var string $email
 * @var string $annee
 * @var string $tel
 * @var string $fix
 * @var string $civiliter
 * @var string $voie
 * @var \Stageo\Model\Object\DistributionCommune $commune
 * @var \Stageo\Model\Object\DistributionCommune [] $communes
 * @var \Stageo\Model\Object\Offre [] $offres
 * @var \Stageo\Model\Object\Offre $offre
 * @var \Stageo\Model\Object\Entreprise $entreprise
 */
?>
<body>
<section class="bg-slate-50 flex-col justify-center items-center">
    <!-- <div class="flex justify-center lg:justify-start lg:px-4 lg:py-2">
        <div class="flex items-center gap-4">
            <img class="h-10 w-10 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="" />
            <div class="font-medium dark:text-white">
                <div><?= ucfirst($prenom) ?> <?= ucwords($nom) ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Année <?= $annee ?></div>
            </div>
        </div>
    </div> -->
    
    <form action="<?=Action::PROFILE_METTRE_A_JOUR_ETUDIANT->value?> " method="post" class="m-32">
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
                                <svg class="h-6 w-6 text-gray-800 dark:text-white" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <!-- ... Icone SVG ... -->
                                </svg>
                            </div>
                            <input id="Nom" class="flex h-10 w-full items-center rounded border border-gray-300 bg-slate-100 pl-16 text-sm font-normal text-gray-600 focus:outline-none" value="<?= $nom?>" readonly />
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Prénom</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600">
                                <i class="fi fi-rr-user"></i>
                            </div>
                            <input id="Prenom" class="flex h-10 w-full items-center rounded border border-gray-300 bg-slate-100 pl-16 text-sm font-normal text-gray-600 focus:outline-none" value="<?= $prenom?>" readonly />
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Email</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M5 4a4 4 0 0 1 4 4v6M5 4a4 4 0 0 0-4 4v6h8M5 4h9M9 14h10V8a3.999 3.999 0 0 0-2.066-3.5M9 14v5m0-5h4v5m-9-8h2m8-4V1h2"/>
  </svg>
                            </div>
                            <input id="Email" class="flex h-10 w-full items-center rounded border border-gray-300 bg-slate-100 pl-16 text-sm font-normal text-gray-600 focus:outline-none" value="<?= $email?>" readonly />
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Téléphone</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="m16.344 12.168-1.4-1.4a1.98 1.98 0 0 0-2.8 0l-.7.7a1.98 1.98 0 0 1-2.8 0l-2.1-2.1a1.98 1.98 0 0 1 0-2.8l.7-.7a1.981 1.981 0 0 0 0-2.8l-1.4-1.4a1.828 1.828 0 0 0-2.8 0C-.638 5.323 1.1 9.542 4.78 13.22c3.68 3.678 7.9 5.418 11.564 1.752a1.828 1.828 0 0 0 0-2.804Z"/>
  </svg>
                            </div>
                            <input id="Tel" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" name="Tel" value="<?= $tel?>" />
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
                            <input id="Fixe" name="Fixe" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" value="<?= $fix?>" />
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Civiliter</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 18">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M7 8a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-2 3h4a4 4 0 0 1 4 4v2H1v-2a4 4 0 0 1 4-4Z"/>
  </svg>
                            </div>
                            <select id="Civiliter" name="Civiliter" class="flex h-10 w-full items-center rounded border border-gray-300 bg-white pl-16 text-sm font-normal text-gray-600 focus:border focus:outline-none">
                                <option value="M" <?php if ("M" == $civiliter) echo 'selected'; ?>>HOMME</option>
                                <option value="F"  <?php if ("F" == $civiliter) echo 'selected'; ?>>FEMME</option>
                                <option value="A"  <?php if ("A" == $civiliter) echo 'selected'; ?>>AUTRE</option>
                            </select>
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Commune</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M5 5h9M5 9h5m8-8H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4l3.5 4 3.5-4h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
  </svg>
                            </div>
                            <select id="Commune" name="Commune" class="flex h-10 w-full items-center rounded border border-gray-300 bg-white pl-16 text-sm font-normal text-gray-600 focus:border focus:outline-none">
                                <?php foreach ($communes as $commun): ?>
                                    <option value="<?= $commun->getIdDistributionCommune() ?>"  <?php if ($commun->getIdDistributionCommune() == $commune) echo 'selected'; ?>><?= $commun->getCommune() ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Numéro de Voie</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600">
                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M5 5h9M5 9h5m8-8H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h4l3.5 4 3.5-4h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
  </svg>
                            </div>
                            <input id="Voie" name="Voie" class="flex h-10 w-full items-center rounded border border-gray-300 pl-16 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none" value="<?= $voie?>" />
                        </div>
                    </div>
                    <div class="px-4 py-2">
                        <span class="font-semibold tracking-wide">Description</span>
                        <div class="flex items-center">
                            <div class="absolute flex items-center border-r px-4 text-gray-600"></div>
                            <textarea id="bio" class="flex h-20 w-full resize-y items-center rounded border border-gray-300 p-2 text-sm font-normal text-gray-600 focus:border focus:border-indigo-700 focus:outline-none min-h-[50px]" placeholder="Écrivez votre bio ici..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="border-t px-4 py-4">
                    <div class="mt-2 flex justify-center">
                        <button type="submit"
                                class="focus:shadow-outline-green mr-2 rounded-lg bg-gradient-to-tr from-green-500 to-green-400 px-4 py-2 font-bold text-white hover:bg-green-600 focus:outline-none transition-all hover:scale-[1.02] hover:shadow-lg hover:shadow-green-500"
                                id="saveButton">Sauvegarder</button>
                        <button type="button"
                                class="focus:shadow-outline-gray rounded-lg bg-gradient-to-tr from-slate-500 to-slate-400 px-4 py-2 font-bold text-white hover:bg-gray-500 focus:outline-none transition-all hover:scale-[1.02] hover:shadow-lg hover:shadow-gray-500"
                                id="cancelButton" onclick="window.location.href='?c=etudiant&a=afficherProfile'">Annuler</button>
                    </div>
                </div>
            </div>

        </div>
        </div>
    </form>
    </div>
    <div class="auto-cols-auto rounded-lg border border-gray-300 bg-white">
        <div class="flex justify-center border-b">
            <span class="tracking-wide">Offres postulé</span>
        </div>
        <div class="grid grid-cols-1 gap-2 px-4 py-4 lg:grid lg:grid-cols-4 lg:space-x-3 lg:space-y-0">
            <?php foreach ($offres as $offrecouple): ?>
                <?php
                $offre = $offrecouple["offre"];
                $entreprise = $offrecouple["entreprise"];
                ?>
                <div class=" flex flex-col items-center rounded-xl border border-slate-200 p-4 shadow-2xl">
                    <span class="font-bold"> <?= $entreprise->getRaisonSociale() ?> </span>
                    <span class="font-bold"> <?= $offre->getThematique() ?> </span>
                    <p class="text-justify m-3"><?= $offre->getDescription()?></p>
                    <p> <?php echo ($offre->getLogin() == null) ? "En cours de validation" : (($offre->getLogin() == $login) ? (!$offre->getValiderParEtudiant() ? "En Attente de Validation" : "Accepter" ) : (!$offre->getValiderParEtudiant() ? "En Liste d'attente" : "Refuser" )); ?> </p>
                    <button onclick="<?php echo ("window.location.href='".Action::AFFICHER_OFFRE->value."&id=".$offre->getIdOffre()) ?>'" class="rounded-xl bg-gradient-to-tr from-blue-600 to-blue-400 bg-clip-border px-4 py-2 text-white shadow-md shadow-blue-500/40 transition-all hover:scale-[1.02] hover:shadow-lg hover:shadow-blue-500">
                        <span class="font-bold">En savoir plus</span>
                    </button>
                </div>
            <?php endforeach;?>
            <!--  <div class="flex flex-col items-center rounded-xl border border-slate-200 py-4 shadow-2xl">
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
              </div>-->
        </div>
    </div>
    </div>
</section>
</body>