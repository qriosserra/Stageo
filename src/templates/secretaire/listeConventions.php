<?php

use Stageo\Lib\enums\Action;
use Stageo\Lib\enums\Pattern;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var string $token
 * @var Convention $convention
 * @var array $pattern
 * @var array $distributions_commune
 * @var array $unite_gratifications
 * @var float $gratification
 * @var array $conventions
 */
?>

<!-- Lister toutes les conventions de la base de données : -->
<main  class="mt-24">

    <?php
    $conventions = Convention::getAllConvention();;
    foreach ($conventions as $convention):
        //faire ensuite une liste de chaque conventions avec un lien permettant de voir leur détails dans conventionDetails.php :?>
                <a href="<?= Action::SECRETAIRE_CONVENTION_DETAILS->value . $convention->getIdConvention() ?>" class="flex flex-col justify-between items-center bg-white p-4 rounded-lg shadow-lg">
                    <div class="inline-flex">
                        <h3 class="text-lg font-semibold"><?= $convention->getLogin() ?></h3>
                        <p class="text-sm text-gray-500"><?= $convention->getSujet() ?></p>
                    </div>
                    <div class="inline-flex">
                        <p class="text-sm text-gray-500"><?= $convention->getDateDebut() ?></p>
                        <p class="text-sm text-gray-500"><?= $convention->getGratification() ?></p>
                    </div>
                </a>


    <?php endforeach; ?>

</main>

