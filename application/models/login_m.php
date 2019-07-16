<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
Class Login_m extends CI_Model{
    //Login Credentials authorization
    // Author: Anand Srivastava Date: 05-Feb-2019
    function ldapauthorization($associateId,$password){
        $userentered = $associateId;
        $ldapdomain = "CERNERASP";
        $ldapuser  = join(DIRECTORY_SEPARATOR, array($ldapdomain , $userentered));
        $ldappass = $password;
        $ldaptree = "DC=cernerasp,DC=com";
        $ldap_con = ldap_connect("ldap://taspmoldap.cernerasp.com");
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        if(@ldap_bind($ldap_con, $ldapuser, $ldappass)) {
            // echo "Bind successful!";
            $sql = "Select * from associate where AssociateID = '".$associateId."'";
            $query = $this->db->query($sql); 
            $result = $query->result();
            if($query->num_rows()==1) 
                return $result;
        }        
    }
    // Author: Anand Srivastava Date: 05-Feb-2019
    function authorization($associateId,$password){
        // echo "Bind successful!";
        $sql = "Select * from associate where AssociateID = '".$associateId."' AND Password='".$password."'";
        $query = $this->db->query($sql); 
        $result = $query->result();
        if($query->num_rows()==1) 
            return $result;
    }
     // Author: Anand Srivastava Date: 05-Feb-2019
    function authorizationlog(){
        return isset($this->session->userdata('userdata')[0]->AssociateID) ? $this->session->userdata('userdata')[0]->AssociateID : FALSE;
    }
     // Author: Anand Srivastava Date: 05-Feb-2019
    function authorizationfilter(){
        return isset($this->session->userdata('userdata')[0]->AssociateID) ? TRUE : FALSE;
    }
}
?>
