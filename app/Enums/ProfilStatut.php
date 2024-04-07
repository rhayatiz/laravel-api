<?php
namespace App\Enums;

enum ProfilStatut: string {
    case ACTIVE = 'actif';
    case INACTIF = 'inactif';
    case EN_ATTENTE = 'en attente';
}