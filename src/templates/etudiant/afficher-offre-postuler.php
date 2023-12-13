<?php

use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Offre;
use \Stageo\Model\Repository\EntrepriseRepository;
use \Stageo\Lib\enums\Action;
/**
 * @var Offre[] $postuler
 * @var Offre[] $accepter
 * @var int $nombre
 * @var Offre $id
 */
?>

<body class="p-2 font-base ">
<main class="h-screen flex flex-col items-center justify-center">
    <h5 class="mb-3">Nombre d'offre auxquelles vous avez candidaté: <?=$nombre?></h5>
    <?php if(!empty($postuler)): ?>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <h4>Postuler:</h4>
            <table class="table border-collapse block sm:table shadow-lg  rounded-xl mb-5">
                <thead class="hidden sm:table-header-group">
                <tr class="border-gray-600 ">
                    <th class="py-2 px-4 border text-left text-black bg-slate-100 font-medium rounded-tl-xl">Thematique</th>
                    <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium">Secteur</th>
                    <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium">Entreprise</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($postuler as $p): ?>
                    <tr>
                        <th scope="row" class="py-3 px-4  borders text-center text-base p-5 sm:w-1/7 md:w-1/5 lg:w-1/5">
                            <a href="<?=Action::AFFICHER_OFFRE->value?>&id=<?=$p->getIdOffre()?>"><?= $p->getThematique()?></a>
                        </th>
                        <td class="borders p-5 sm:w-1/7 md:w-1/5 lg:w-1/5">
                            <?=$p->getSecteur()?>
                        </td>
                        <td class="borders p-5 sm:w-1/7 md:w-1/5 lg:w-1/5">
                            <?=(new EntrepriseRepository())->getById($p->getIdEntreprise())->getRaisonSociale()?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else:?>
        <?php if(!$id):?>
            <h4>Vous n'avez postulé à aucune  offre</h4>
            <?php endif; ?>
        <?php endif; ?>
        <?php if(!empty($accepter)): ?>
        <h4>Accepter:</h4>
        <table class="table border-collapse block sm:table shadow-lg  rounded-xl mb-5">
            <thead class="hidden sm:table-header-group">
            <tr class="border-gray-600 ">
                <th class="py-2 px-4 border text-left text-black bg-slate-100 font-medium rounded-tl-xl">Thematique</th>
                <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium">Secteur</th>
                <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium">Entreprise</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($accepter as $p): ?>
                <tr>
                    <th scope="row" class="borders sm:w-1/5 md:w-1/5 lg:w-1/5">
                        <a href="<?=Action::AFFICHER_OFFRE->value?>&id=<?=$p->getIdOffre()?>"><?= $p->getThematique()?></a>
                    </th>
                    <td class="borders p-5 sm:w-1/5 md:w-1/5 lg:w-1/5">
                        <?=$p->getSecteur()?>
                    </td>
                    <td class="borders p-5 sm:w-1/5 md:w-1/5 lg:w-1/5">
                        <?=(new EntrepriseRepository())->getById($p->getIdEntreprise())->getRaisonSociale()?>
                    </td>
                    <?php if(!$id):?>
                    <td>
                        <button onclick="window.location.href='<?= Action::VALIDER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $p->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="rounded-md bg-blue-500 text-white p-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700 transition-all duration-150">
                            Accepter
                        </button>
                        <button onclick="window.location.href='<?= Action::REFUSER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $p->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="rounded-md bg-red-500 text-white p-2 ml-2 hover:bg-red-600 focus:outline-none focus:shadow-outline-red active:bg-red-700 transition-all duration-150">
                            Refuser
                        </button>
                    </td>
                    <?php else:?>
                        <td>
                            <button onclick="window.location.href='<?= Action::VALIDER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $p->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'" class="rounded-md bg-blue-500 text-white p-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700 transition-all duration-150">
                                Créer convention
                            </button>
                        </td>
                    <?php endif;?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else:?>
        <h4>Vous n'avez été accepté à aucune  offre</h4>
        <?php endif; ?>
    </div>
</main>
