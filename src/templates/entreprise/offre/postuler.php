<?php

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Offre;
use Stageo\Lib\UserConnection;
use \Stageo\Model\Object\Etudiant;
use \Stageo\Model\Repository\PostulerRepository;
use \Stageo\Model\Object\Entreprise;

include __DIR__ . "/../../macros/button.php";
include __DIR__ . "/../../macros/input.php";
include __DIR__ . "/../../macros/offre.php";
/**
 * @var Offre $offre
 * @var string $token
 */
?>

<main class="h-screen flex flex-col items-center justify-center">
    <form enctype="multipart/form-data" class="bg-white h-screen lg:h-auto w-screen lg:w-[64rem] overflow-scroll p-12 text-gray-600 rounded-lg shadow-lg grid gap-8" action="<?=Action::ETUDIANT_POSTULER_OFFRE->value . '&id=' . $offre->getIdOffre() . '&login='.UserConnection::getSignedInUser()->getLogin()?>" method="post">
        <label for="cv">CV :</label>
        <input type="file" name="cv" id="cv" accept=".pdf, .doc, .docx">
        <label for="lm">Lettre de motivation :</label>
        <input type="file" name="lm" id="lm" accept=".pdf, .doc, .docx">
        <?=textarea("complement", "Complement", "Entrez des information complémentaire", 4, false, null, "lg:col-span-2")?>
        <?=token($token)?>
        <?=submit("Postuler")?>
    </form>
</main>
