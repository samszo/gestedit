<?php
class AuthController extends Zend_Controller_Action
{
    public function loginAction()
    {    	
		$this->view->erreur = false;    		
    		
		$ssExi = new Zend_Session_Namespace('uti');
		
		if($this->_getParam('redir', 0)){
			$ssExi->redir='/'.$this->_getParam('redir', 0);
		}
		
    		// Obtention d'une référence de l'instance du Singleton de Zend_Auth
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();

		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		$adapter = new Zend_Auth_Adapter_DbTable(
                $dbAdapter,
                'iste_uti',
                'login',
                'mdp'
                );		                
        $adapter->setIdentity($this->_getParam('login'));
        $adapter->setCredential($this->_getParam('mdp'));
        $login = $this->_getParam('login');
        if($login)$result = $auth->authenticate($adapter);			
    			
    		if ($result->isValid()) {		            	
			//met en sessions les informations de l'existence
			$dbUti = new Model_DbTable_Iste_uti();
			$rs = $dbUti->findByLogin($login);
    			$ssExi->uti = $rs;
			$ssUti->idUti = $rs["uti_id"];		            	
	        	
			$this->view->rs = $ssExi->uti;
	    }else{
	    		switch ($result->getCode()) {
            		case 0:
						$this->view->erreur = "Problème d'identification. Veuillez contacter le webmaster.";		            	
	            		break;		            		
            		case -1:
						$this->view->erreur = "Le login n'a pas été trouvé. Contactez votre administrateur.";		            	
	            		break;		            		
            		case -2:
						$this->view->erreur = "Le login est ambigue.";		            	
	            		break;		            		
            		case -2:
						$this->view->erreur = "Le login et/ou le mot de passe ne sont pas bons.";		            	
	            		break;		            		
            	}
	   	}
    }

    
    public function deconnexionAction()
    {
		$this->clearConnexion();
    }
    
    function clearConnexion(){
		$ssExi = new Zend_Session_Namespace('uti'); 		   	
		$redir = $ssExi->redir;
		Zend_Session::namespaceUnset('uti');
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
	    	$this->_redirect($redir);            	
    }   
  
}