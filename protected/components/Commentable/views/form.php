<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>false,
	'action'=>'/comment/create'
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name')?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date',array('value'=>date('Y-m-d H:i'))); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>
	
	<?php $commentRelation = new CommentRelation()?>
	
	<?php echo $form->hiddenField($commentRelation,'model_id', array('value'=>$entity->id)); ?>
 	<?php echo $form->hiddenField($commentRelation,'model_name', array('value'=>get_class($entity))); ?>
 	<?php echo $form->hiddenField($model,'parent_id'); ?>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->