<?php 
class CustomUploadHandler extends UploadHandler {

    protected function initialize() {
        $this->db = new Model_DbTable_Iste_importfic();
        parent::initialize();
    }

    protected function handle_form_data($file, $index) {
        //$file->name = @$_REQUEST['nameObj'][$index];
    		$file->idObj = @$_REQUEST['idObj'][$index];
        $file->obj = @$_REQUEST['obj'][$index];
        $file->type = @$_REQUEST['type'][$index];
        $file->dateFin = @$_REQUEST['date_fin'][$index];
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
            $index = null, $content_range = null) {
        $f = parent::handle_file_upload($uploaded_file, $name, $size, $type, $error, $index, $content_range);
        if (empty($f->error)) {        	
    			$rs =$this->db->ajouter(array("nom"=>$f->name,"url"=>$f->url,"size"=>$f->size
				,"content_type"=>"inconnu","type"=>$f->type,"obj"=>$f->obj,"id_obj"=>$f->idObj,"periode_fin"=>$f->dateFin),false,true);
            $f->id = $rs["id_importfic"];
            $f->nbLigne = $rs["nbLigne"];
            $f->nbVente = $rs["nbVente"];
        }
        return $f;
    }

    protected function set_additional_file_properties($file) {
		parent::set_additional_file_properties($file);
       	if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	    		$rs = $this->db->findByUrl($file->url,array("periode_fin DESC"));
			$file->id = $rs["id_importfic"];
			//$file->name = $rs["nom"];
			$file->type = $rs["type"];
            $file->obj = $rs["obj"];
            $file->idObj = $rs["id_obj"];
            $file->dateFin = $rs["periode_fin"];
            $file->nbLigne = $rs["nbLigne"];
            $file->nbVente = $rs["nbVente"];
       	}
    }

    public function delete($print_response = true) {
        $response = parent::delete(false);
        foreach ($response as $name => $deleted) {
            if ($deleted) {
	        		$url = $this->options["upload_url"].$name;
	        		$rs = $this->db->findByUrl($url);
	        		//echo $rs["id_importfic"]." : ".$url;
	            	$this->db->remove($rs["id_importfic"]);
            }
        } 
        return $this->generate_response($response, $print_response);
    }

}
