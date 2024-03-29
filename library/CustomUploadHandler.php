<?php 
class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
        $this->db = new Model_DbTable_Iste_importfic();
        parent::initialize();
    }

    protected function handle_form_data($file, $index) {
        //$file->name = @$_REQUEST['nameObj'][$index];
        if(is_array(@$_REQUEST['idObj'])){
            $file->idObj = @$_REQUEST['idObj'][$index];
            $file->obj = @$_REQUEST['obj'][$index];
            $file->type = @$_REQUEST['type'][$index];
            //on ne précise que l'année
            //$file->dateFin = @$_REQUEST['date_fin'][$index]."-01-01";
            //$file->dateDeb = (@$_REQUEST['date_fin'][$index]-1)."-01-01";
            //les dates sont explicitement choisies
            $file->dateFin = @$_REQUEST['dateFin'][$index];
            $file->dateDeb = @$_REQUEST['dateDeb'][$index];    
            $file->conversion = @$_REQUEST['conversion'][$index];    
        }else{
            $file->idObj = @$_REQUEST['idObj'];
            $file->obj = @$_REQUEST['obj'];
            $file->type = @$_REQUEST['type'];
            $file->dateFin = @$_REQUEST['dateFin'];
            $file->dateDeb = @$_REQUEST['dateDeb'];    
            $file->conversion = @$_REQUEST['conversion'];    
        }
        if($file->idObj)$path = "/data/".$file->obj."_".$file->idObj."/";
        else $path = "/data/".$file->obj."_".$file->type."/";
        $this->options['upload_dir']=ROOT_PATH.$path;    
        $this->options['upload_url']=WEB_ROOT.$path;    
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        /*ATTENTION l'adresse étant absolu il faut la modifier
        
        */
        $f = parent::handle_file_upload($uploaded_file, $name, $size, $type, $error, $index, $content_range);
        if (empty($f->error)) {        	
    		$rs =$this->db->ajouter(array("nom"=>$f->name,"url"=>$f->url,"size"=>$f->size
    			    ,"content_type"=>"inconnu","type"=>$f->type,"obj"=>$f->obj,"id_obj"=>$f->idObj
    			    ,"periode_debut"=>$f->dateDeb,"periode_fin"=>$f->dateFin,"conversion_livre_euro"=>$f->conversion),false,true);
            $f->id = $rs["id_importfic"];
            $f->recid = $rs["id_importfic"];
            $f->nbLigne = $rs["nbLigne"];
            $f->nbVente = $rs["nbVente"];
        }
        return $f;
    }

    protected function set_additional_file_properties($file) {
		parent::set_additional_file_properties($file);
       	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	    	$rs = $this->db->findByUrl($file->url,array("i.id_importfic DESC"));
			$file->id = $rs["id_importfic"];
			$file->recid = $rs["id_importfic"];
			//$file->name = $rs["nom"];
			$file->type = $rs["type"];
            $file->obj = $rs["obj"];
            $file->idObj = $rs["id_obj"];
            $file->dateFin = $rs["periode_fin"];
            $file->dateDeb = $rs["periode_debut"];
            $file->nbLigne = $rs["nbLigne"];
            $file->nbVente = $rs["nbVente"];
       	}
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
                    $url = $this->options["upload_url"].rawurlencode($name);
	        		$rs = $this->db->findByUrl($url);
                    //echo $rs["id_importfic"]." : ".$url;
                    $response['message']=$this->db->remove($rs["id_importfic"]);
            }
        } 
        return $this->generate_response($response, $print_response);
    }

}
