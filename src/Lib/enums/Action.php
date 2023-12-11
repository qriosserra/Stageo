<?php

namespace Stageo\Lib\enums;

enum Action: string
{
    case HOME = "?a=home";
    case ERROR = "?a=error";
    case SIGN_OUT = "?a=signOut";
    case ETUDIANT_SIGN_IN_FORM = "?c=etudiant&a=signInForm";
    case ETUDIANT_SIGN_IN = "?c=etudiant&a=signIn";
    case ETUDIANT_POSTULER_OFFRE_FORM = "?c=etudiant&a=afficherFormulairePostuler";
    case ETUDIANT_POSTULER_OFFRE = "?c=etudiant&a=postuler";
    case ENTREPRISE_SIGN_UP_STEP_1_FORM = "?c=entreprise&a=signUpStep1Form";
    case ENTREPRISE_SIGN_UP_STEP_1 = "?c=entreprise&a=signUpStep1";
    case ENTREPRISE_SIGN_UP_STEP_2_FORM = "?c=entreprise&a=signUpStep2Form";
    case ENTREPRISE_SIGN_UP_STEP_2 = "?c=entreprise&a=signUpStep2";
    case ENTREPRISE_SIGN_UP_STEP_3_FORM = "?c=entreprise&a=signUpStep3Form";
    case ENTREPRISE_SIGN_UP_STEP_3 = "?c=entreprise&a=signUpStep3";
    case ENTREPRISE_SIGN_UP_STEP_4_FORM = "?c=entreprise&a=signUpStep4Form";
    case ENTREPRISE_SIGN_UP_STEP_4 = "?c=entreprise&a=signUpStep4";
    case ENTREPRISE_VERIFIER = "?c=entreprise&a=verifier";
    case ENTREPRISE_SIGN_IN_FORM = "?c=entreprise&a=signInForm";
    case ENTREPRISE_SIGN_IN = "?c=entreprise&a=signIn";
    case LISTE_OFFRE = "?a=listeOffre";
    case AFFICHER_OFFRE = "?a=afficherOffre";
    case ENTREPRISE_POSTULE_OFFRE_ETUDIANT = "?c=entreprise&a=voirAPostuler";
    case ENTREPRISE_ACCEPTE_ETUDIANT_OFFRE = "?c=entreprise&a=accepterEtudiantOffre";
    case ENTREPRISE_CREATION_OFFRE_FORM = "?c=entreprise&a=offreAddForm";
    case ENTREPRISE_CREATION_OFFRE = "?c=entreprise&a=offreAdd";
    case ENTREPRISE_AFFICHER_OFFRE = "?c=entreprise&a=afficherOffreEntreprise";
    case ENTREPRISE_MODIFICATION_OFFRE_FORM = "?c=entreprise&a=afficherFormulaireMiseAJourOffre";
    case ENTREPRISE_MODIFICATION_OFFRE = "?c=entreprise&a=mettreAJourOffre";
    case ENTREPRISE_DELETE_OFFRE = "?c=entreprise&a=deleteOffre";
    case ADMIN_MODIFICATION_INFO_FORM = "?c=admin&a=afficherFormulaireMiseAJour";
    case ADMIN_MODIFICATION_INFO = "?c=admin&a=mettreAJourAdmin";
    case ADMIN_SIGN_UP_FORM = "?c=admin&a=signUpForm";
    case ADMIN_SIGN_UP = "?c=admin&a=signUp";
    case ADMIN_SIGN_IN_FORM = "?c=admin&a=signInForm";
    case ADMIN_SIGN_IN = "?c=admin&a=signIn";
    case ADMIN_DASH = "?c=admin&a=dashboard";
    case ADMIN_LISTEENTREPRISE = "?c=admin&a=listeEntreprises";
    case ADMIN_VALIDEENTREPRISE = "?c=admin&a=validerEntreprise";
    case ADMIN_SUPRIMERENTREPRISE = "?c=admin&a=suprimerEntreprise";
    case ABOUT = "?a=about";
    case CSVFORM = "?a=csvForm";
    case CSV = "?a=csv&XDEBUG_SESSION_START=";
    case SECRETAIRE_SIGN_UP_FORM = "?c=secretaire&a=signUpForm";
    case SECRETAIRE_SIGN_UP = "?c=secretaire&a=signUp";
    case SECRETAIRE_SIGN_IN = "?c=secretaire&a=signIn";
    case SECRETAIRE_DASH = "?c=secretaire&a=dashboard";
    case ETUDIANT_CONVENTION_ADD_FORM = "?c=etudiant&a=conventionAddForm";
    case ETUDIANT_CONVENTION_ADD = "?c=etudiant&a=conventionAdd";
    case SECRETAIRE_LISTE_CONVENTIONS = "?c=secretaire&a=listeConventions";
    case SECRETAIRE_CONVENTION_DETAILS = "?c=secretaire&a=conventionDetails&id_convention=";
    case TEST_EMAIL = "?a=testEmail";
    case PROFILE_ETUDIANT = "?c=etudiant&a=afficherProfile";
    case PROFILE_METTRE_A_JOUR_ETUDIANT = "?c=etudiant&a=MettreAJourProfile";
    case VALIDER_DEFINITIVEMENT_OFFRE = "?c=etudiant&a=validerDefinitivement";
    case REFUSER_DEFINITIVEMENT_OFFRE = "?c=etudiant&a=refuserDefinitivement";
}