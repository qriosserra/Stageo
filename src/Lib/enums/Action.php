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
    case ENTREPRISE_POSTULE_OFFRE_ETUDIANT = "?c=entreprise&a=afficherPostuleEtudiantAll";
    case ENTREPRISE_ACCEPTE_ETUDIANT_OFFRE = "?c=entreprise&a=accepterEtudiantOffre";
    case ENTREPRISE_CREATION_OFFRE_FORM = "?c=entreprise&a=offreAddForm";
    case ENTREPRISE_CREATION_OFFRE = "?c=entreprise&a=offreAdd";
    case ENTREPRISE_AFFICHER_OFFRE = "?c=entreprise&a=afficherOffreEntreprise";
    case ENTREPRISE_MODIFICATION_OFFRE_FORM = "?c=entreprise&a=afficherFormulaireMiseAJourOffre&id=";
    case ENTREPRISE_MODIFICATION_OFFRE = "?c=entreprise&a=mettreAJourOffre";
    case ENTREPRISE_DELETE_OFFRE = "?c=entreprise&a=deleteOffre";
    case ADMIN_SIGN_UP_FORM = "?c=admin&a=signUpForm";
    case ADMIN_SIGN_UP = "?c=admin&a=signUp";
    case ADMIN_SIGN_IN_FORM = "?c=admin&a=signInForm";
    case ADMIN_SIGN_IN = "?c=admin&a=signIn";
    case ADMIN_DASH = "?c=admin&a=dashboard";
    case ADMIN_LISTEENTREPRISE = "?c=admin&a=listeEntreprises";
    case ADMIN_GESTION_ETUDIANT = "?c=admin&a=gestionEtudiant";
    case ADMIN_VALIDECONV_FROM = "?c=admin&a=validerConventionForm";
    case ADMIN_VALIDEENTREPRISE = "?c=admin&a=validerEntreprise";
    case ADMIN_SUPRIMERENTREPRISE = "?c=admin&a=suprimerEntreprise";
    case ADMIN_SUPRIMERADMIN_FROM = "?c=admin&a=supprimerAdminForm";
    case ADMIN_SUPRIMERADMIN = "?c=admin&a=supprimerAdmin";
    case ABOUT = "?a=about";
    case IMPORT_CSV_FORM = "?c=main&a=importCsvForm";
    case IMPORT_CSV = "?c=main&a=importCsv";
    case EXPORT_CSV = "?c=main&a=exportCsv";
    case SECRETAIRE_SIGN_UP_FORM = "?c=secretaire&a=signUpForm";
    case SECRETAIRE_SIGN_UP = "?c=secretaire&a=signUp";
    case SECRETAIRE_SIGN_IN = "?c=secretaire&a=signIn";
    case SECRETAIRE_DASH = "?c=secretaire&a=dashboard";
    case ETUDIANT_CONVENTION_ADD_STEP_1_FORM = "?c=etudiant&a=conventionAddStep1Form";
    case ETUDIANT_CONVENTION_ADD_STEP_1 = "?c=etudiant&a=conventionAddStep1";
    case ETUDIANT_CONVENTION_ADD_STEP_2_FORM = "?c=etudiant&a=conventionAddStep2Form";
    case ETUDIANT_CONVENTION_ADD_STEP_2 = "?c=etudiant&a=conventionAddStep2";
    case ETUDIANT_CONVENTION_ADD_STEP_3_FORM = "?c=etudiant&a=conventionAddStep3Form";
    case ETUDIANT_CONVENTION_ADD_STEP_3 = "?c=etudiant&a=conventionAddStep3";
    case ETUDIANT_SOUMETTRE_CONVENTION = "?c=etudiant&a=soumettreConvention";
    case ETUDIANT_MES_CANDIDATURE = "?c=etudiant&a=voirMesCandidature";
    case SECRETAIRE_LISTE_CONVENTIONS = "?c=secretaire&a=listeConventions";
    case SECRETAIRE_CONVENTION_DETAILS = "?c=secretaire&a=conventionDetails&id_convention=";
    case SECRETAIRE_CONVENTION_VALIDATION = "?c=secretaire&a=conventionValidation";
    case SECRETAIRE_CONVENTION_REFUS = "?c=secretaire&a=conventionRefus";
    case PROFILE_ETUDIANT = "?c=etudiant&a=afficherProfile";
    case PROFILE_METTRE_A_JOUR_ETUDIANT = "?c=etudiant&a=MettreAJourProfile";
    case VALIDER_DEFINITIVEMENT_OFFRE = "?c=etudiant&a=validerDefinitivement";
    case REFUSER_DEFINITIVEMENT_OFFRE = "?c=etudiant&a=refuserDefinitivement";
    case ADMIN_LISTEOFFRES = "?c=admin&a=listeOffre";
    case ADMIN_VALIDEOFFRE = "?c=admin&a=validerOffre";
    case ADMIN_SUPRIMEROFFRES = "?c=admin&a=suprimerOffre";
    case A_PROPOS = "?a=a_propos";
    case CONTACT = "?a=contact";
    case CONTACT_FORM = "?a=contact_form";
    case FAQ = "?a=faq";
    case CONFIDENTIALITE = "?a=confidentialite";
    case SUIVI_STAGIAIRE_FORM = "?c=admin&a=suiviStagiaire";

    case LISTE_ENTREPRISES = "?a=listeEntreprises";

    case AFFICHER_ENTREPRISE = "?a=afficherEntreprise";
    case TUTORIEL = "?a=tutoriel";
}