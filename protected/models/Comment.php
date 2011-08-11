<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $date
 * @property integer $parent_id
 *
 * The followings are the available model relations:
 * @property Comment $parent
 * @property Comment[] $comments
 * @property CommentRelation[] $commentRelations
 */
class Comment extends CActiveRecord {
    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, text', 'required'),
            array('parent_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 200),
            array('date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, text, date, parent_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'parent' => array(self::BELONGS_TO, 'Comment', 'parent_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'parent_id'),
            'commentRelations' => array(self::HAS_MANY, 'CommentRelation', 'comment_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'date' => 'Date',
            'parent_id' => 'Parent',
        );
    }

    public function behaviors() {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'date',
                'updateAttribute' => 'date',
            )
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('parent_id', $this->parent_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    public function createEntity($name, $pk = null) {
        $dirrectories = explode(PATH_SEPARATOR, get_include_path());
        $fileExists = false;
        foreach ($dirrectories as $dir) {
            if (file_exists($dir . '/' . $name . '.php')) {
                $fileExists = true;
            }
        }
        if (!$fileExists) return false;
        $entity = call_user_func(array($name, 'model'));
        if (!$entity instanceof CActiveRecord) return false;
        if ($pk !== null) {
            $entity = $entity->findByPk($pk);
        }

        return $entity;
    }

    public function getOwner() {
        $commentRelation = CommentRelation::model()->findByAttributes(array('comment_id' => $this->id));
        if ($commentRelation) {
            $entity = $this->createEntity($commentRelation->model_name, $commentRelation->model_id);
            return $entity;
        }
    }
}