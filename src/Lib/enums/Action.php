<?php

namespace Stageo\Lib\enums;

enum Action: string
{
    case HOME = "?a=home";
    case ERROR = "?a=error";
    case ETUDIANT_SIGN_UP_FORM = "?c=etudiant&a=signUpForm";
    case ETUDIANT_SIGN_UP = "?c=etudiant&a=signUp";
    case SIGN_OUT = "?c=signOut";
    case ETUDIANT_SIGN_IN_FORM = "?c=etudiant&a=signInForm";
    case ETUDIANT_SIGN_IN = "?c=etudiant&a=signIn";
    case ENTREPRISE_ADD_FORM = "?c=entreprise&a=addForm";
    case ENTREPRISE_ADD = "?c=entreprise&a=add";
    case LISTE_OFFRE = "?a=listeOffre";
    case AFFICHER_OFFRE = "?a=afficherOffre";
    case ENTREPRISE_CREATION_OFFRE_FORM = "?c=entreprise&a=creation_offre_form";
    case ENTREPRISE_CREATION_OFFRE = "?c=entreprise&a=creation_offre";
    case ADMIN_SIGN_UP_FORM = "?c=admin&a=signUpForm";
    case ADMIN_SIGN_UP = "?c=admin&a=signUp";
    case ADMIN_SIGN_IN_FORM = "?c=admin&a=signInForm";
    case ADMIN_SIGN_IN = "?c=admin&a=signIn";
    case ABOUT = "?a=about";
}