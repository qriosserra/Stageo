<?php
/**
 * @var ArrayObject $etudiants
 * @var Etudiant $etu
 * @var int[] $nbcandidature
 * @var int[] $nbaccepter
 * @var Convention[] $conventions
 * @var Convention $conventions
 * @var Suivi[] $suivies
 * @var Suivi $suivie
 */

use Stageo\Lib\enums\Action;
use Stageo\Lib\UserConnection;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\Secretaire;
use Stageo\Model\Object\Suivi;

?>
<style>
    table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
  }

  table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
  }

  table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: .35em;
  }

  table th,
  table td {
    padding: .625em;
    text-align: center;
  }

  table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
  }

  @media screen and (max-width: 910px) {
    table {
      border: 0;
    }

    table caption {
      font-size: 1.3em;
    }

    table thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }

    table tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }

    table td {
      border-bottom: 1px solid #ddd;
      display: block;
      font-size: .8em;
      text-align: right;
    }

    table td::before {
  
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }

    table td:last-child {
      border-bottom: 0;
    }
  }
</style>
<main class="mt-[5rem] h-screen flex justify-center items-center">
<table class="mb-[15rem] ml-4 mr-4">
  <caption>Gestion d'étudiants</caption>
  <thead>
    <tr>
      <th scope="col">Login</th>
      <th scope="col">Nom</th>
      <th scope="col">Prenom</th>
      <th scope="col">Nombre de candidature</th>
      <th scope="col">Candidatures acceptées</th>
      <th scope="col">Convention</th>

    </tr>
  </thead>
  <tbody>
  <?php foreach ($etudiants as $etu) : ?>
  <?php $user= UserConnection::getSignedInUser()?>
                <tr>
                    <td data-label="Login" ><?= $etu->getLogin() ?></td>
                    <td data-label="Nom" ><?= $etu->getNom() ?></td>
                    <td data-label="Prenom" ><?= $etu->getPrenom() ?></td>
                    <td data-label="Nombre de candidature" ><?= $nbcandidature[$etu->getlogin()] ?></td>
                    <td data-label="Convention" ><?= $nbaccepter[$etu->getlogin()] ?></td>
                    <?php $conv = $conventions[$etu->getlogin()];if ($conv!=null):?>
                        <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700">
                            <a href="<?= Action::ADMIN_VALIDECONV_FROM->value."&etulogin=".$etu->getLogin() ?>"
                               >
                               
<button class=" flex-col ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50  px-[2rem] inline-flex items-center justify-center h-[60px] border border-transparent text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 ease-in-out transform hover:scale-105">
  Voir la convention
  <?php
  if(($user instanceof Enseignant && $user->getEstAdmin()) && $suivies[$etu->getlogin()]!=null && !$suivies[$etu->getlogin()]->getModifiable() && !$conv->getVerificationAdmin() && $conv->getVerificationEntreprise() && !$conv->getVerificationSecretaire()):?>
    <span class="block text-red-500 text-xs ">Action requise</span>
  <?php
  elseif($user instanceof Secretaire && $suivies[$etu->getlogin()]!=null && !$suivies[$etu->getlogin()]->getModifiable() && !$conv->getVerificationSecretaire() && $conv->getVerificationEntreprise() && $conv->getVerificationAdmin()):?>
      <span class="block text-red-500 text-xs ">Action requise</span>
  <?php
  elseif($user instanceof Entreprise && $user->getIdEntreprise()==$conv->getIdEntreprise() && !$conv->getVerificationEntreprise() && !$conv->getVerificationAdmin() && !$conv->getVerificationSecretaire() && !$suivies[$etu->getlogin()]->getModifiable()):?>
      <span class="block text-red-500 text-xs ">Action requise</span>
  <?php
  elseif($suivies[$etu->getlogin()]!=null && !$suivies[$etu->getlogin()]->getModifiable() && $conv->getVerificationEntreprise() && $conv->getVerificationAdmin() && $conv->getVerificationSecretaire()):?>
      <span class="block text-red-500 text-xs ">Convention valide</span>
    <?php else:?>
    <span class="block text-green-500 text-xs ">aucune action requise</span>
    <?php endif;?>
</button>
                            </a>
                            
                        </td>
                    <?php else :?>
                        <td class="px-4 py-3 border-b border-gray-200 text-sm text-gray-700">Pas de convention!</td>
                    <?php endif;?>
                </tr>
            <?php endforeach; ?>
  </tbody>
</table>
</main>