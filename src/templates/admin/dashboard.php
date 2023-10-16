<?php use Stageo\Lib\enums\Action;
include __DIR__."/../macros/button.php";
?>
<div id="dashboard" class="flex justify-between m-10 w-[75%] mx-auto h-[60vh]">

<div id="colonne1">
    <a href="<?= Action::ADMIN_SIGN_UP_FORM->value ?>" class="button-ghost ">
        <i class="fi fi-rr-user"></i>
        <span>Crée un compte d'admin</span>
    </a>
</div>
<div id="colonne2">
    <a href="" class="button-ghost">
        <i class="fi fi-rr-building"></i>
        <span>Accéder aux entreprises à valider [work in progress]</span>
    </a>
</div>
<div id="colonne3">
    <a href="" class="button-ghost">
        <i class="fi fi-rr-document"></i>
        <span>Accéder la liste des offre [work in progress]</span>
    </a>
</div>
</div>

