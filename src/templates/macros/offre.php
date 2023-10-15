<?php
function offre(
        string $text = null,
        string $title = null,
        string $entreprise = null,
        string $url = null,
        string $src = null,
        string $idDiv = null,
        string $class = null): string

{
if (!empty($class)){
    $class = "";
}
    $title = (is_null($title)) ? "titre" : $title ;
    $entreprise = (is_null($entreprise)) ? "nomEntreprise " : $entreprise;
    $url = (is_null($url)) ? " " : $url;
    $idDiv = (is_null($idDiv)) ? " " : $idDiv;
    $src = (is_null($src)) ? "assets/img/FAQB.jpg" : $src;
return <<<HTML
 <div id="$idDiv">
    <a href="$url " class="flex flex-row items-center bg-white border border-blue-500 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700  $class ">
      <div class="flex flex-col justify-between p-4 leading-normal">
          <img class="object-cover w-1/2 rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg border-blue-500" src="$src" alt="">
          <h7>
              <p class="mb-3 font-normal text-black dark:text-gray-400"> $entreprise </p>
          </h7>
      </div>
        <div class="flex flex-col justify-between p-4 leading-normal">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-black dark:text-white"> $title </h5>
            <p class="mb-3 font-normal text-black dark:text-gray-400 title"> $text </p>
        </div>
    </a>
    </div>
HTML;
}




?>