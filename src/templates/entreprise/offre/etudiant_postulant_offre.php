<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;
use \Stageo\Model\Object\Postuler;
use \Stageo\Model\Repository\EtudiantRepository;
use \Stageo\Model\Repository\OffreRepository;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
/**
 * @var Postuler[] $postuler
 */
?>
<style>
    /* Style pour la boîte modale */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-contenu {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        max-width: 80%;
        max-height: 80%;
        overflow: auto;
        /* Ajout des styles pour .modal-contenu */
        position: relative;
        text-align: center;
    }

    .fermer {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 20px;
        color: #333;
    }

    .borders {
        border-top: 1px solid rgb(233, 233, 233);
        border-bottom: 1px solid rgb(233, 233, 233);
        border-left: 1px solid rgb(233, 233, 233);
    }

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
        }

        .table tr {
            margin-bottom: 15px;
        }

        .table td {
            padding-left: 50%;
            text-align: left;
            position: relative;
            background-color: #f3f3f3;
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
        }

        .borders {
            border-top: 1px solid rgb(233, 233, 233);
            border-bottom: 1px solid rgb(233, 233, 233);
            border-left: 1px solid rgb(233, 233, 233);
            border-right: 1px solid rgb(233, 233, 233);
        }
    }
</style>
<body class="p-2 font-base ">
<main class="h-screen flex flex-col items-center justify-center">
    <div class="relative overflow-x-auto sm:rounded-lg">
        <?php foreach ($postuler as $liste_offre): ?>
        <a href="<?=Action::AFFICHER_OFFRE->value?>&id=<?=$liste_offre[0]->getIdOffre()?>"><h2><?=(new OffreRepository())->getById($liste_offre[0]->getIdOffre())->getThematique() ?></h2></a>
        <table class="table border-collapse block sm:table shadow-lg  rounded-xl mb-5">
            <thead class="hidden sm:table-header-group">
            <tr class="border-gray-600 ">
                <th class="py-2 px-4 border text-left text-black bg-slate-100 font-medium rounded-tl-xl">Nom</th>
                <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium">CV</th>
                <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium">Lettre de Motivation</th>
                <th class="py-3 px-4 border text-left text-black bg-slate-100 font-medium rounded-tr-xl">Complement</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($liste_offre as $p): ?>
                <tr class="">
                    <th scope="row" class="py-3 px-4  borders text-center text-base" data-label="Nom">
                        <?= ((new EtudiantRepository())->getByLogin($p->getLogin()))->getNom() ?> <?= ((new EtudiantRepository())->getByLogin($p->getLogin()))->getPrenom()?>
                    </th>
                    <td class="borders" data-label="CV">
                        <?php if (!empty($p->getCv())): ?>
                            <a href="assets/document/cv/<?= $p->getCv() ?>" class="text-blue-600 text-blue-400 hover:text-red-400 py-3 px-4   text-center text-base">Télécharger le CV</a></td>
                        <?php else: ?>
                            <p>Aucun CV disponible</p>
                        <?php endif; ?>
                    </td>
                    <td data-label="Lettre de Motivation" class="borders">
                        <?php if (!empty($p->getLettreMotivation())): ?>
                            <a href="assets/document/lm/<?= $p->getLettreMotivation() ?>" id=" " class="text-blue-600 text-blue-400 hover:text-red-400  my-6 px-4   text-center text-base" >Télécharger la lettre de Motivation</a>
                        <?php else: ?>
                            <p>Aucune lettre de motivation disponible</p>
                        <?php endif; ?>
                    </td>
                    <td data-label="Complement" class="borders border-r" id="complement<?= $p->getId() ?>">
                        <a class="text-blue-600 text-blue-400 hover:text-red-400 py-3 px-4 text-center text-base complement-link" texte="<?= htmlspecialchars($p->getComplement()) ?>">
                            <?= substr($p->getComplement(), 0, 50) . (strlen($p->getComplement()) > 50 ? '...' : '') ?>
                        </a>
                    </td>
                    <?php if (!((new \Stageo\Model\Repository\OffreRepository())->getById($p->getIdOffre()))->getLogin()): ?>
                    <td class="text-green-600  items-center text-center text-base borders border-r ">
                        <a href="<?=Action::ENTREPRISE_ACCEPTE_ETUDIANT_OFFRE->value."&login=".$p->getLogin()."&id=".$p->getIdOffre()?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Accepter</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <!-- Pop Up -->
                <div class="modal" id="modal<?= $p->getId() ?>">
                    <div class="modal-contenu">
                        <span class="fermer" onclick="fermerModal('modal<?= $p->getId() ?>')">&times;</span>
                        <p class="contenu-modal" id="modalTexte<?= $p->getId() ?>"></p>
                    </div>
                </div>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endforeach; ?>

    </div>
</main>

<script>
    var modals = document.querySelectorAll('.modal');
    var textLinks = document.querySelectorAll('.complement-link');
    var closeButtons = document.querySelectorAll('.fermer');
    var contenu_modal = document.querySelectorAll('.contenu-modal');

    textLinks.forEach(function(link, i) {
        link.onclick = function() {
            var fullText = link.getAttribute('texte');
            contenu_modal[i].innerText = fullText;
            modals[i].style.display = "flex";
        };
    });

    closeButtons.forEach(function(button, i) {
        button.onclick = function() {
            modals[i].style.display = "none";
        };
    });

    window.onclick = function(event) {
        modals.forEach(function(modal, i) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    };

    function fermerModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = "none";
        }
    }
</script>