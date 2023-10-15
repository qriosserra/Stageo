<?php

namespace Stageo\Lib\enums;

enum Action: string
{
    case HOME = "";
    case ERROR = "?a=error";
    case ETUDIANT_SIGN_UP_FORM = "?c=etudiant&a=signUpForm";
    case ETUDIANT_SIGN_UP = "?c=etudiant&a=signUp";
    case SIGN_OUT = "?c=signOut";
    case ETUDIANT_SIGN_IN_FORM = "?c=etudiant&a=signInForm";
    case ETUDIANT_SIGN_IN = "?c=etudiant&a=signIn";
    case ENTREPRISE_ADD_FORM = "?c=entreprise&a=addForm";
    case ENTREPRISE_ADD = "?c=entreprise&a=add";
    case ENTREPRISE_CREATION_OFFRE_FORM = "?c=entreprise&a=creation_offre_form";
    case ENTREPRISE_CREATION_OFFRE = "?c=entreprise&a=creation_offre";
}