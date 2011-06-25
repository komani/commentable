<?php
/**
 *  This widget renders commentaries form.
 *	$entity  ActiveRecord class is required
 *	To change view see views/form.php file
 */

class Tree extends CWidget {
	
	public $entity;
	
    public function run() {
    	if($this->entity ===null){
    		throw new Exception("Entity can`t be null");
    	}
        $this->render('tree',array('entity'=>$this->entity));
    }
}
?>