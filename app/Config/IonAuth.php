<?php 

namespace Config;

class IonAuth extends \IonAuth\Config\IonAuth
{
    // set your specific config
    public $siteTitle                = 'Joyari';       // Site Title, example.com
    public $adminEmail               = 'connect@joyari.com'; // Admin Email, admin@example.com
    public $emailTemplates           = 'App\\Views\\user\\email\\';
    public $useCiEmail               = true;
    // ...
}