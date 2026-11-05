<?php

class Mmaster extends My_Model {
	public function __construct(){ echo'######';die;
        $this->load->model('Mlibrary');
        $this->load->model('Mcommon');
    }
	
}

?>