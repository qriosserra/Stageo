<?php use Stageo\Lib\enums\Action;
include __DIR__."/../macros/button.php";
//
?>
<main id="dashboard" class="flex justify-between m-10 w-[75%] mx-auto h-[60vh] mt-[8rem]">
<div id="colonne1" class="flex flex-col justify-between">
    <a href="<?= Action::ADMIN_SIGN_UP_FORM->value ?>" class="button-ghost ">
        <i class="fi fi-rr-user"></i>
        <span>Crée un compte d'admin</span>
    </a>
    <a href="" class="button-ghost ">
        <i class="fi fi-rr-user"></i>
        <span>Crée un compte secretaire [work in progress]</span>
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
<div id="colonne4">
    <a href=<?= Action::SECRETAIRE_LISTE_CONVENTIONS->value?> class="button-ghost">
        <i class="fi fi-rr-document"></i>
        <span>Accéder la liste des conventions [work in progress]</span>
    </a>
</main>