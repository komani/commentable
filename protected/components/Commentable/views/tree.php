<?php
$entity->attachBehavior('CommentableBehavior',new CommentableBehavior());
$comments = $entity->findComments();
function tree($comments,$parent,$i,$widget,$entity)
{
	$i++;	
	foreach($comments as $comment){
		if($parent == $comment->parent_id){
			$widget->render('view',array('data'=>$comment, 'margin'=>$i,'entity'=>$entity));
			tree($comments, $comment->id, $i,$widget,$entity);
		}
	}
}
tree($comments, 0, -1,$this,$entity);
?>