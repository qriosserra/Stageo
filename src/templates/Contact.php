<?php

use Stageo\Lib\enums\Pattern;
use Stageo\Lib\enums\Action;
use Stageo\Model\Object\Entreprise;

include __DIR__ . "/../macros/input.php";
include __DIR__ . "/../macros/button.php";
/**
 * @var string $token
 * @var Entreprise $entreprise
 */
?>
<main class="bg-gray-100 p-10 mt-[8rem]">
  <div class="flex flex-col items-start justify-center space-y-10 md:flex-row md:items-center md:space-x-10 md:space-y-0">
    <div class="w-full md:w-1/3">
      <div class="space-y-8">
        <div class="space-y-2">
          <h2 class="text-3xl font-bold text-gray-700">Contactez-nous</h2>
          <p class="text-gray-500">Une question, un problème, un retour ? On aimerait vous aider. Veuillez remplir le formulaire ci-dessous et nous vous recontacterons dès que possible.</p>
        </div>
        <form class="space-y-4" action="<?=Action::CONTACT_FORM->value?>" method="POST">
          <div class="space-y-2">
            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="name">Nom & Prénom</label>
            <input required class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="name" placeholder="Votre nom & prénom" />
          </div>
          <?token($token)?>
          <div class="space-y-2"><label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="email">Email</label><input required class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="email" placeholder="Votre Email" type="email" /></div>
          <div class="space-y-2"><label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="subject">Sujet</label><input required class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex h-10 w-full rounded-md border px-3 py-2 text-sm file:border-0 file:bg-transparent file:text-sm file:font-medium focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="subject" placeholder="Sujet" /></div>
          <div class="space-y-2"><label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="message">Message</label><textarea required class="border-input bg-background ring-offset-background placeholder:text-muted-foreground focus-visible:ring-ring flex min-h-[100px] w-full rounded-md border px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" id="message" placeholder="Votre message"></textarea></div>
          <div class="flex justify-center items-center h-full">

            <button class="ring-offset-background focus-visible:ring-ring hover:bg-primary/90 inline-flex h-10 items-center justify-center rounded-md bg-blue-500 px-4 py-2 text-sm font-medium text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50" type="submit">Envoyer</button>
          </div>
         
        </form>
      </div>
    </div>

    <div class="w-full space-y-4 md:w-1/3 " style="display : flex; flex-direction : column; justify-content : center; align-items : center">
      <p class="text-lg text-gray-700">Notre localisation:</p>
      <iframe src="https://maps.google.com/maps?q=43.6353354,3.8506696&t=&z=13&ie=UTF8&iwloc=&output=embed" class="  rounded-lg" style="height: calc(20rem + 15vh); width : calc(15rem + 15vw)" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
  <footer class="mt-10 flex flex-col items-center justify-center space-y-4 text-gray-700 " style="background-color: whitesmoke;">
    <p class="text-lg">Vous pouvez nous contacter via:</p>
    <p>Email: stageo@gmail.com</p>
    <p>Téléphone: 06060606</p>
    <p>Adresse: 99 Av. d'Occitanie, 34090 Montpellier</p>
  </footer>
</main>