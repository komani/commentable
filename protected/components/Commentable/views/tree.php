<?php
$entity->attachBehavior('CommentableBehavior', new CommentableBehavior());
$comments = $entity->findComments();
function tree($comments, $parent, $i, $widget, $entity, $showDeleteLink) {
    $i++;
    foreach ($comments as $comment) {
        if ($parent == $comment->parent_id) {
            $widget->render('view', array(
                'data' => $comment,
                'margin' => $i,
                'entity' => $entity,
                'showDeleteLink' => $showDeleteLink));
            tree($comments, $comment->id, $i, $widget, $entity, $showDeleteLink);
        }
    }
}
tree($comments, 0, -1, $this, $entity,$showDeleteLink);
?>