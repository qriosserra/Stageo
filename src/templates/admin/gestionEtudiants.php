<?php
/**
 * @var ArrayObject $etudiants
 * @var Etudiant $etu
 * @var int[] $nbcandidature
 * @var int[] $nbaccepter
 * @var ArrayObject $conventions
 * @var Convention $conventions
 * @var ArrayObject $suivies
 * @var Suivi $suivie
 */

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Suivi;

?>
<div class="bg-gray-100 h-screen flex justify-center items-center p-12">

    <div class="w-full max-w-4xl">
        <table class="min-w-full table-auto bg-white rounded-lg shadow-md overflow-hidden">
            <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Login</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nom</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Prenom</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nombre de candidature</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">candidatures acceptées</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">convention</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            <?php foreach ($etudiants as $etu) : ?>
                <tr>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700"><?= $etu->getLogin() ?></td>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700"><?= $etu->getNom() ?></td>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700"><?= $etu->getPrenom() ?></td>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700"><?= $nbcandidature[$etu->getlogin()] ?></td>
                    <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700"><?= $nbaccepter[$etu->getlogin()] ?></td>
                    <?php if ($conventions[$etu->getlogin()]!=null):?>
                        <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700">
                            <a href="<?= Action::ADMIN_VALIDECONV_FROM->value."&etulogin=".$etu->getLogin() ?>"
                               class="text-white bg-red-500 hover:bg-red-700 rounded px-4 py-1">
                                Voir la convention [ en construction ]
                            </a>
                        </td>
                    <?php else :?>
                        <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700">Pas de convention!</td>
                    <?php endif;?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>