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
    case ENTREPRISE_ADD_STEP_1_FORM = "?c=entreprise&a=addStep1Form";
    case ENTREPRISE_ADD_STEP_1 = "?c=entreprise&a=addStep1";
    case ENTREPRISE_ADD_STEP_2_FORM = "?c=entreprise&a=addStep2Form";
    case ENTREPRISE_ADD_STEP_2 = "?c=entreprise&a=addStep2";
    case ENTREPRISE_ADD_STEP_3_FORM = "?c=entreprise&a=addStep3Form";
    case ENTREPRISE_ADD_STEP_3 = "?c=entreprise&a=addStep3";
    case ENTREPRISE_ADD_STEP_4_FORM = "?c=entreprise&a=addStep4Form";
    case ENTREPRISE_ADD_STEP_4 = "?c=entreprise&a=addStep4";
    case LISTE_OFFRE = "?a=listeOffre";
    case AFFICHER_OFFRE = "?a=afficherOffre";
    case ENTREPRISE_CREATION_OFFRE_FORM = "?c=entreprise&a=offreAddForm";
    case ENTREPRISE_CREATION_OFFRE = "?c=entreprise&a=offreAdd";
    case ADMIN_SIGN_UP_FORM = "?c=admin&a=signUpForm";
    case ADMIN_SIGN_UP = "?c=admin&a=signUp";
    case ADMIN_SIGN_IN_FORM = "?c=admin&a=signInForm";
    case ADMIN_SIGN_IN = "?c=admin&a=signIn";
    case ADMIN_DASH = "?c=admin&a=dashboard";
    case ABOUT = "?a=about";
}