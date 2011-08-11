<?php
$entity->attachBehavior('CommentableBehavior', new CommentableBehavior());
$comments = $entity->findComments();
foreach($comments as $comment){
    echo $this->render('view', array(
                'data' => $comment,
                'margin' => 0,
                'entity' => $entity,
                'showDeleteLink' => $showDeleteLink,
                'showAnswerButton' => false
    ));
}