<?php
/**
 * @var Etudiant[] $etudiantsSuivis
 * @var Etudiant[] $etudiants
 * @var Convention[] $conventions
 * @var Entreprise[] $entreprises
 * @var DistributionCommune[] $communes
 */

use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\DistributionCommune;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;

?>

<main class="container mx-auto p-6">
  <h1 class="mb-6 text-center text-3xl font-semibold underline">Assignations de stagiaires à tutorer</h1>
  <h3>Recherche de stagiaires</h3>
  <div class="bg-card text-card-foreground rounded-lg border shadow-sm " data-v0-t="card" style="background-color: #d4d3e0">
    <div class="p-6 ">
      <div class="flex w-full items-center gap-2">
        <input class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Rechercher par thématique, entreprise..." type="text" />
        <button class="ring-offset-background focus-visible:ring-ring bg-primary text-primary-foreground hover:bg-primary/90 inline-flex h-10 items-center justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50" type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
          </svg>
        </button>
      </div>
    </div>
  </div>
    <form action="<?=Action::ENSEIGNANT_TUTORER_ETUDIANT->value?>" method="post">
        <?php if (empty($conventions)): ?>
            <p class="text-center text-xl font-semibold mt-6">Il n'y a pas de convention</p>
        <?php else: ?>
        <ul class="mt-6 space-y-4">
          <?php foreach ($conventions as $index => $convention): ?>
              <?php
                  $etudiant = $etudiants[$index];
                  $entreprise = $entreprises[$index];
                  $commune = $communes[$index];
              ?>
              <li>
                  <label for="<?=$convention->getIdConvention()?>" class="bg-card text-card-foreground flex items-center gap-4 rounded-lg border bg-slate-100 shadow-lg p-4">
                        <input type="checkbox" name="id_conventions[]" value="<?=$convention->getIdConvention()?>" id="<?=$convention->getIdConvention()?>">
                      <div class="flex flex-row flex-1 justify-between items-center p-4 gap-4">
                          <div class="p-6 w-[67rem]">
                              <h3 class="font-bold"><?="{$etudiant->getPrenom()} {$etudiant->getNom()}"?></h3>
                              <p><?=$convention->getThematique()?></p>
                              <p class="font-bold"><?=$entreprise->getRaisonSociale()?></p>
                              <p class="italic"><?="{$convention->getNumeroVoie()}, {$commune->getCommune()} ({$commune->getCodePostal()})"?></p>
                          </div>
                          <div>
                              <p class="font-bold">Tâches:</p>
                              <p><?=$convention->getTaches()?></p>
                          </div>
                          <div>
                              <p class="font-bold">Commentaires:</p>
                              <p><?=$convention->getCommentaires()?></p>
                          </div>
                          <div>
                              <p class="font-bold">Détails:</p>
                              <p><?=$convention->getDetails()?></p>
                          </div>
                      </div>
                  </label>
              </li>
          <?php endforeach; ?>
        </ul>
        <div class="mt-6 flex justify-end">
          <input type="submit" class="inline-flex h-10 items-center justify-center rounded-md border-indigo-300 bg-slate-400 px-4 py-2 text-sm font-medium transition-colors hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
        </div>
        <?php endif; ?>
    </form>
  <div class="bg-card text-card-foreground shadow-smS mt-8 rounded-lg border" style="background-color: #d4d3e0;" data-v0-t="card">
    <div class="flex flex-col space-y-1.5 p-6">
      <h3 class="text-2xl font-semibold leading-none tracking-tight">Etudiants suivis:</h3>
    </div>
    <div class="p-6">
        <ul class="list-inside list-disc">
            <?php if (empty($etudiantsSuivis)): ?>
                <li>Aucun</li>
            <?php else: ?>
                <?php foreach ($etudiantsSuivis as $etudiant): ?>
                    <li><?= $etudiant->getPrenom() . " " . $etudiant->getNom() ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
  </div>
</main>

<script>
  // JavaScript pour basculer l'état de la case à cocher personnalisée
  document.querySelectorAll('.toggleCheckbox').forEach(button => {
    button.addEventListener('click', function() {
      const isChecked = this.getAttribute('aria-checked') === 'true';
      this.setAttribute('aria-checked', String(!isChecked));
      this.querySelector('.checkmark svg').classList.toggle('hidden', isChecked);
    });
  });
</script>