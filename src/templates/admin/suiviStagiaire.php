<!--
// v0 by Vercel.
// https://v0.dev/t/90j2papGR4n
-->
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
  <ul class="mt-6 space-y-4">
    <!-- Répétez ce bloc pour chaque stagiaire -->
    <li>
      <div class="bg-card text-card-foreground flex items-center gap-4 rounded-lg border bg-slate-100 shadow-lg" data-v0-t="card "  style="margin-top:2rem">
        <button type="button" role="checkbox" aria-checked="false" class="toggleCheckbox border-primary ring-offset-background focus-visible:ring-ring data-[state=unchecked]:bg-transparent data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground peer h-4 w-4 shrink-0 rounded-sm border focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" style="border: 2px solid black; margin : 2rem" id="person1">
          <span class="checkmark flex items-center justify-center text-current" style="pointer-events: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 hidden"><polyline points="20 6 9 17 4 12"></polyline></svg>
          </span>
        </button>
        <div class="p-6">
          <h3 class="font-bold">Prénom Nom</h3>
          <p>Thématique</p>
          <p>Adresse</p>
          <p>Entreprise</p>
        </div>
      </div>
    </li>
    <!-- Fin de la liste des stagiaires -->
  </ul>
  <div class="mt-6 flex justify-end">
    <button class="inline-flex h-10 items-center justify-center rounded-md border-indigo-300 bg-slate-400 px-4 py-2 text-sm font-medium transition-colors hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50" style="background-color: gray; margin-top: 2rem">Enregistrer</button>
  </div>
  <div class="bg-card text-card-foreground shadow-smS mt-8 rounded-lg border" style="background-color: #d4d3e0;" data-v0-t="card">
    <div class="flex flex-col space-y-1.5 p-6">
      <h3 class="text-2xl font-semibold leading-none tracking-tight">Personnes déjà suivi</h3>
    </div>
    <div class="p-6">
      <ul class="list-inside list-disc">
        <li>Person 1</li>
        <li>Person 2</li>
        <li>Person 3</li>
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
