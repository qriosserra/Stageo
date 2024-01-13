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
<style>
    @media (max-width: 639px) {
        .table thead {
            display: none;
        }

        .table,
        .table tbody,
        .table tr,
        .table td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .table tr {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .table td {
            text-align: left;
            position: relative;
            background-color: #f3f3f3;
            padding: 8px;
            box-sizing: border-box;
        }

        .table td::before {
            content: attr(data-label);
            position: absolute;
            left: 0;
            width: 50%;
            padding-left: 15px;
            font-size: 15px;
            font-weight: bold;
            text-align: left;
            background-color: #f3f3f3;
            box-sizing: border-box;
        }

        .borders {
            border: 1px solid rgb(233, 233, 233);
        }
    }
</style>

<body class="p-2 font-base">
<main class="h-screen flex flex-col items-center justify-center">
    <h5 class="mb-3 text-center">Nombre d'offres auxquelles vous avez candidaté: <?= $nombre ?></h5>
    <?php if (!empty($postuler)): ?>
    <div class="relative overflow-x-auto sm:rounded-lg">
        <h4 class="text-center">Postuler:</h4>
        <table class="table border-collapse block sm:table shadow-lg rounded-xl mb-5">
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
                    <th scope="row" class="py-3 px-4 borders text-center sm:w-full md:w-1/2 lg:w-1/2">
                        <a href="<?= Action::AFFICHER_OFFRE->value ?>&id=<?= $p->getIdOffre() ?>">
                            <?= $p->getThematique() ?>
                        </a>
                    </th>
                    <td class="borders p-2">
                        <?= $p->getSecteur() ?>
                    </td>
                    <td class="borders p-2">
                        <?= (new EntrepriseRepository())->getById($p->getIdEntreprise())->getRaisonSociale() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <?php if (!$id): ?>
                <h4 class="text-center">Vous n'avez postulé à aucune offre</h4>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($accepter)): ?>
            <h4 class="text-center">Accepter:</h4>
            <table class="table border-collapse block sm:table shadow-lg rounded-xl mb-5">
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
                        <th scope="row" class="borders sm:w-full md:w-1/2 lg:w-1/2">
                            <a href="<?= Action::AFFICHER_OFFRE->value ?>&id=<?= $p->getIdOffre() ?>">
                                <?= $p->getThematique() ?>
                            </a>
                        </th>
                        <td class="borders p-2">
                            <?= $p->getSecteur() ?>
                        </td>
                        <td class="borders p-2">
                            <?= (new EntrepriseRepository())->getById($p->getIdEntreprise())->getRaisonSociale() ?>
                        </td>
                        <?php if (!$id): ?>
                            <td class="text-center">
                                <button onclick="window.location.href='<?= Action::VALIDER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $p->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'"
                                        class="rounded-md bg-blue-500 text-white p-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700 transition-all duration-150">
                                    Accepter
                                </button>
                                <button onclick="window.location.href='<?= Action::REFUSER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $p->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'"
                                        class="rounded-md bg-red-500 text-white p-2 ml-2 hover:bg-red-600 focus:outline-none focus:shadow-outline-red active:bg-red-700 transition-all duration-150">
                                    Refuser
                                </button>
                            </td>
                        <?php else: ?>
                            <td class="text-center">
                                <button onclick="window.location.href='<?= Action::VALIDER_DEFINITIVEMENT_OFFRE->value ?>&idOffre=<?= $p->getIdOffre() ?>&login=<?= UserConnection::getSignedInUser()->getLogin() ?>'"
                                        class="rounded-md bg-blue-500 text-white p-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700 transition-all duration-150">
                                    Créer convention
                                </button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h4 class="text-center">Vous n'avez été accepté à aucune offre</h4>
        <?php endif; ?>
    </div>
</main>
