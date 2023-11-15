<?php

namespace Stageo\Lib\enums;

enum Action: string
{
    case HOME = "?a=home";
    case ERROR = "?a=error";
    case ETUDIANT_SIGN_UP_FORM = "?c=etudiant&a=signUpForm";
    case ETUDIANT_SIGN_UP = "?c=etudiant&a=signUp";
    case SIGN_OUT = "?a=signOut";
    case ETUDIANT_SIGN_IN_FORM = "?c=etudiant&a=signInForm";
    case ETUDIANT_SIGN_IN = "?c=etudiant&a=signIn";
    case ETUDIANT_POSTULER_OFFRE = "?c=etudiant&a=postuler";
    case ETUDIANT_POSTULER_OFFRE_FORM = "?c=etudiant&a=afficherFormulairePostuler";
    case ENTREPRISE_ADD_STEP_1_FORM = "?c=entreprise&a=addStep1Form";
    case ENTREPRISE_ADD_STEP_1 = "?c=entreprise&a=addStep1";
    case ENTREPRISE_ADD_STEP_2_FORM = "?c=entreprise&a=addStep2Form";
    case ENTREPRISE_ADD_STEP_2 = "?c=entreprise&a=addStep2";
    case ENTREPRISE_ADD_STEP_3_FORM = "?c=entreprise&a=addStep3Form";
    case ENTREPRISE_ADD_STEP_3 = "?c=entreprise&a=addStep3";
    case ENTREPRISE_ADD_STEP_4_FORM = "?c=entreprise&a=addStep4Form";
    case ENTREPRISE_ADD_STEP_4 = "?c=entreprise&a=addStep4";
    case ENTREPRISE_SIGN_UP_FORM = "?c=entreprise&a=signUpForm";
    case ENTREPRISE_SIGN_UP = "?c=entreprise&a=signUp";
    case ENTREPRISE_SIGN_IN_FORM = "?c=entreprise&a=signInForm";
    case ENTREPRISE_SIGN_IN = "?c=entreprise&a=signIn";
    case LISTE_OFFRE = "?a=listeOffre";
    case AFFICHER_OFFRE = "?a=afficherOffre";
    case ENTREPRISE_CREATION_OFFRE_FORM = "?c=entreprise&a=offreAddForm";
    case ENTREPRISE_CREATION_OFFRE = "?c=entreprise&a=offreAdd";
    case ENTREPRISE_AFFICHER_OFFRE = "?c=entreprise&a=afficherOffreEntreprise";
    case ENTREPRISE_MODIFICATION_OFFRE_FORM = "?c=entreprise&a=afficherFormulaireMiseAJourOffre";
    case ENTREPRISE_MODIFICATION_OFFRE = "?c=entreprise&a=mettreAJourOffre";
    case ENTREPRISE_DELETE_OFFRE = "?c=entreprise&a=deleteOffre";
    case ADMIN_SIGN_UP_FORM = "?c=admin&a=signUpForm";
    case ADMIN_SIGN_UP = "?c=admin&a=signUp";
    case ADMIN_SIGN_IN_FORM = "?c=admin&a=signInForm";
    case ADMIN_SIGN_IN = "?c=admin&a=signIn";
    case ADMIN_DASH = "?c=admin&a=dashboard";
    case ABOUT = "?a=about";
    case SECRETAIRE_SIGN_UP_FORM = "?c=secretaire&a=signUpForm";
    case SECRETAIRE_SIGN_UP = "?c=secretaire&a=signUp";
    case SECRETAIRE_SIGN_IN = "?c=secretaire&a=signIn";
    case SECRETAIRE_DASH = "?c=secretaire&a=dashboard";
}