<?php

use Stageo\Lib\enums\Action;

?>
<main class="w-[64rem]">
    <div class=" !  bg-gray-100 !p-10 space-y-8 flex-col justify-center items-center">
        <section class=" py-8  flex justify-center items-center ">
            <h5 class="align-center text-justify">Importer des conventions</h5>
        </section>
        <section>
            <form class="flex-col py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7" action="<?=Action::IMPORT_CSV->value?>" method="post" enctype="multipart/form-data">
            <div>
                    <label for="name">Fichier d'importation CSV: </label>
                    <input type="file" name="CHEMINCSV" id="CHEMINCSV" accept=".csv">
                </div>
                <div>
                <input type="submit" value="Importer" />
                </div>
            </form>
        </section>
    </div>
</main>