<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//require_once ('/var/www/html/configs/ldap.config');

class Phones{
    
    
    public function ShowAll(){
        //выборка из АД
        require_once ('/var/www/html/configs/ldap.config');
        $ldap = ldap_connect($ldaphost,$ldapport) or die("Cant connect to LDAP Server");
        //Включаем LDAP протокол версии 3
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ldap, "oadm", "Dcbsm17J") or die('Не могу подсоединиться к LDAP-серверу');
        $that=array("sAMAccountName","telephoneNumber","otherTelephone");
        $result = ldap_search($ldap,$base,$phone_filter,$that);
        $info = ldap_get_entries($ldap, $result);
        return array($info);
    }
    
    public function ShowPhone($number) {
        $this->number=$number;
        
    }
    
    public function Edit($number){
        $this->number=$number;
        
    }
}