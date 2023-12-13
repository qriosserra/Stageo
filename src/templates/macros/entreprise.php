<?php

function entreprise(string $raison_sociale,
                    string $siret,
                    string $numero_voie,
                    string $code_naf,
                    string $telephone,
                    string $fax,
                    string $site,
                    string $taille_entreprise,
                    string $type_structure,
                    string $statut_juridique,
                    string $commune,
                    string $code_postal,
                    string $pays,
                    string $id_entreprise): string
{
    $action = Action::AFFICHER_ENTREPRISE->value . "&id=$id_entreprise";
    return <<<HTML
    <div class="items-center bg-white border border-blue-500 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 $class">
        <a href="$action" class="h-full flex flex-row">
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h7>
                    <p class="mb-3 font-normal text-black dark:text-gray-400">$raison_sociale</p>
                </h7>
            </div>
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-black dark:text-white">$siret</h5>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$numero_voie</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$code_naf</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$telephone</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$fax</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$site</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$taille_entreprise</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$type_structure</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$statut_juridique</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$commune</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$code_postal</p>
                <p class="flex flex-wrap mb-3 font-normal text-black dark:text-gray-400 title">$pays</p>
            </div>
        </a>
    </div>
HTML;
}

