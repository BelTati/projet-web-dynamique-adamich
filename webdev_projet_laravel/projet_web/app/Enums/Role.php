<?php
namespace App\Enums;

enum Role: string
{
   
    case ADMIN = 'admin';
    case USER = 'user';
    case PROVIDER = 'provider';
    case TEMP = 'temp';
    
}