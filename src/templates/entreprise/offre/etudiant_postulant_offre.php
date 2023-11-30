<?php

use Stageo\Model\Object\Categorie;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Etudiant;
use \Stageo\Model\Object\Offre;
use Stageo\Lib\enums\Action;
use \Stageo\Model\Object\Postuler;
use \Stageo\Model\Repository\EtudiantRepository;

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
    }

    .fermer {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 20px;
        color: #333;
    }
</style>
<main class="h-screen flex flex-col items-center justify-center">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nom de l'étudiant
                </th>
                <th scope="col" class="px-6 py-3">
                    CV
                </th>
                <th scope="col" class="px-6 py-3">
                    Lettre Motivation
                </th>
                <th scope="col" class="px-6 py-3">
                    Complement
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($postuler as $p): ?>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?= ((new EtudiantRepository())->getByLogin($p->getLogin()))->getNom() ?> <?= ((new EtudiantRepository())->getByLogin($p->getLogin()))->getPrenom()?>
                    </th>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <?php if (!empty($p->getCv())): ?>
                            <a href="assets/document/cv/<?= $p->getCv() ?>" download class="text-blue-500 hover:underline">Télécharger CV</a>
                        <?php else: ?>
                            <p>Aucun CV disponible</p>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if (!empty($p->getLettreMotivation())): ?>
                            <a href="assets/document/lm/<?= $p->getLettreMotivation() ?>" download class="text-blue-500 hover:underline">Télécharger Lettre de Motivation</a>
                        <?php else: ?>
                            <p>Aucune lettre de motivation disponible</p>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4" id="complement<?= $p->getId() ?>">
                        <span class="lien-complet" onclick="afficherTexteComplet('<?= htmlspecialchars($p->getComplement()) ?>')"> <?= substr($p->getComplement(), 0, 50) . (strlen($p->getComplement()) > 50 ? '...' : '') ?></span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="<?=Action::ENTREPRISE_ACCEPTE_ETUDIANT_OFFRE->value."&login=".$p->getLogin()."&id=".$p->getIdOffre()?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Accepter</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pop Up -->
    <div class="modal" id="modal">
        <div class="modal-contenu">
            <span class="fermer" onclick="fermerModal()">&times;</span>
            <p id="modalTexte"></p>
        </div>
    </div>
</main>

<script>
    function afficherTexteComplet(texte) {
        var modalTexte = document.getElementById("modalTexte");
        modalTexte.innerHTML = texte;

        var modal = document.getElementById("modal");
        modal.style.display = "flex";

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                fermerModal();
            }
        });
    }

    function fermerModal() {
        var modal = document.getElementById("modal");
        modal.style.display = "none";
    }
</script>