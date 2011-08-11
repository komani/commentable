<?php
/**
 *  This widget renders commentaries form.
 *	$entity  ActiveRecord class is required
 *	To change view see views/form.php file
 */

class Line extends CWidget {
	
	public $entity;

    public $showDeleteLink;

    public function run() {
    	if($this->entity ===null){
    		throw new Exception("Entity can`t be null");
    	}
        $this->render('line',array('entity'=>$this->entity,'showDeleteLink'=>$this->showDeleteLink));
    }
}
?>