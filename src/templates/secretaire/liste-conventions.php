<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Convention;

include __DIR__ . "/../macros/button.php";
include __DIR__ . "/../macros/input.php";

/**
 * @var string $token
 * @var Convention $convention
 * @var array $conventions
 */
?>

<main  class="mt-24">
    <?php if (empty($conventions)):?>
        <p class="text-center text-gray-500">Aucune convention n'a été trouvée.</p>
    <?php else:?>
        <?php foreach ($conventions as $convention):?>
            <a href="<?=Action::SECRETAIRE_CONVENTION_DETAILS->value . "{$convention->getIdConvention()}"?>" class="flex flex-col justify-between items-center bg-white p-4 rounded-lg shadow-lg">
                <div class="inline-flex">
                    <h3 class="text-lg font-semibold"><?=$convention->getLogin()?></h3>
                    <p class="text-sm text-gray-500"><?=$convention->getSujet()?></p>
                </div>
                <div class="inline-flex">
                    <p class="text-sm text-gray-500"><?=$convention->getDateDebut()?></p>
                    <p class="text-sm text-gray-500"><?=$convention->getGratification()?></p>
                </div>
            </a>
        <?php endforeach?>
    <?php endif?>
</main>