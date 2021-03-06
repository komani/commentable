<?php
/**
 * CommentBehavior class file
 * @author Konovalov Maxim <max.zloy@gmail.com>
 * This behavior can be attached to any ActiveRecord class and give commentary functiononality
 * Comment model and CommentRelation model are used
 */
class CommentableBehavior extends CActiveRecordBehavior
{
	/**
	 * Add comment to AR
	 * @param $comment - Comment AR instance
	 * Find an existing comment  and if it exists update
	 * if not, add create new comment and attach it to current model 
	 */
	public function addComment(Comment $comment)
	{
		$relationAttributes = array(
						'comment_id' => $comment->id,
						'model_id'   => $this->getOwner()->id,
						'model_name' => get_class($this->getOwner())
					);
		$commentRelation = CommentRelation::model()
			->findByAttributes($relationAttributes);
		if($commentRelation) {
			$comment->save();
		} else {
			$commentRelation = new CommentRelation();
			$commentRelation->setAttributes($relationAttributes);
			$comment->save();
			$commentRelation->save();
		}
	}

	/**
	 * delete сomment from AR
	 * @param $comment - comment AR
	 */
	public function deleteComment(Comment $comment)
	{
		$commentRelation = CommentRelation::model()
			->findByAttributes(
				array(
					'comment_id' => $comment->id,
					'model_id'   => $this->getOwner()->id,
					'model_name' => get_class($this->getOwner())
				))->delete();
	}
	
	/**
	 * Find all comments for current AR
	 */
	public function findComments()
	{
		$criteria = new CDbCriteria();
		$criteria->join ='`comment_relation` on `comment_relation`.comment_id  = `t`.id';
		$criteria->condition = '`comment_relation`.model_id = ' . $this->getOwner()->id ;
		$criteria->addCondition("`comment_relation`.model_name = '".get_class($this->getOwner())."'");
		return Comment::model()->findAll();
	}
}