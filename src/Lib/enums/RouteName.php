<?php

namespace Stageo\Lib\enums;

enum RouteName: string
{
    case PREVIOUS_PAGE = "previousPage";
    case RELOAD_PAGE = "reloadPage";
    case HOME = "home";
    case ABOUT = "about";
    case FAQ = "faq";
    case CONTACT_FORM = "contactForm";
    case CONTACT = "contact";
    case THANKS_FOR_CONTACTING = "thanksForContacting";
    case ERROR = "error";
    case ETUDIANT_SIGN_UP_FORM = "etudiantSignUpForm";
    case ETUDIANT_SIGN_UP = "etudiantSignUp";
    case SIGN_OUT = "signOut";
    case ETUDIANT_SIGN_IN_FORM = "etudiantSignInForm";
    case ETUDIANT_SIGN_IN = "etudiantSignIn";
    case SETTINGS = "settings";
    case ADMIN_DASHBOARD = "adminDashboard";
    case ENTREPRISE_ADD_FORM = "entrepriseAddForm";
    case ENTREPRISE_ADD = "entrepriseAdd";
    case ENTREPRISE_SIGN_IN_FORM = "entrepriseSignInForm";
    case ENTREPRISE_CREATION_OFFRE_FORM = "creationOffreForm";
    case ENTREPRISE_CREATION_OFFRE = "creationOffre";
}