<?php
/**
 *	This widget renders commentaries form.
 *	$entity  ActiveRecord class is required
 *	To change view see views/form.php file
 */
class Form extends CWidget {
 	
	public $model;
	
	public $entity;
	
    public function run() {
    	if($this->model ===null){
    		$this->model = new Comment();
    	}
    	if($this->entity ===null){
    		throw new Exception("Entity can`t be null");
    	}
        $this->render('form',array('model'=>$this->model,'entity'=>$this->entity));
    }
}
?>