<?php
class AuthController extends Zend_Controller_Action
{
    public function loginAction()
    {    	
		$this->view->erreur = false;    		
    		
		$ssExi = new Zend_Session_Namespace('uti');
		
		if($this->_getParam('redir', 0)){
			$ssExi->redir='/'.$this->_getParam('redir', 0);
		}else{
			$ssExi->redir='../admin';			
		}		
		
    		// Obtention d'une référence de l'instance du Singleton de Zend_Auth
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();

		if ($this->_getParam('login')) {

	    		$adapter = new Zend_Auth_Adapter_DbTable(
	                null,
	                'iste_uti',
	                'login',
	                'mdp'
	                );		                
	        $login = $this->_getParam('login');
	        $adapter->setIdentity($login);
	        $adapter->setCredential($this->_getParam('mdp'));
	        // Tentative d'authentification et stockage du résultat
			$result = $auth->authenticate($adapter);
    		}else{
    			return;
    		}    					
			
    		if ($result->isValid()) {		            	
			//met en sessions les informations de l'existence
			$dbUti = new Model_DbTable_Iste_uti();
			$rs = $dbUti->findByLogin($login);
    			$ssExi->uti = $rs;
			$ssUti->idUti = $rs["uti_id"];		            		        	
			$this->view->rs = $ssExi->uti;
			
	    		$this->_redirect($ssExi->redir);
	    		return;
			
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
            		case -3:
						$this->view->erreur = "Le login et/ou le mot de passe ne sont pas bons.";		            	
	            		break;		            		
            	}
	   	}
    }
    
    public function deconnexionAction()
    {
		if($this->_getParam('all'))Zend_Session::destroy( true );
		$this->clearConnexion();
    }

    public function finsessionAction()
    {
		
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