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
 */
?>

<!-- Lister toutes les conventions de la base de données : -->
<main  class="mt-24">
    <table class="table-auto">
        <thead>
        <tr>
            <th class="px-4 py-2">Type de convention</th>
            <th class="px-4 py-2">Année universitaire</th>
            <th class="px-4 py-2">Origine du stage</th>
            <th class="px-4 py-2">Sujet</th>
            <th class="px-4 py-2">Tâches</th>
            <th class="px-4 py-2">Adresse de l'établissement où se déroule la mission</th>
            <th class="px-4 py-2">Commune</th>
            <th class="px-4 py-2">Date de début</th>
            <th class="px-4 py-2">Date de fin</th>
            <th class="px-4 py-2">Heures total</th>
            <th class="px-4 py-2">Jours hebdomadaire</th>
            <th class="px-4 py-2">Heures hebdomadaire</th>
            <th class="px-4 py-2">Gratification</th>
            <th class="px-4 py-2">Unité de gratification</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($conventions as $convention): ?>
            <tr>
                <td class="border px-4 py-2"><?=$convention->getTypeConvention()?></td