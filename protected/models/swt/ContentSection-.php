<?php

/**
 * This is the model class for table "swt_content_section".
 *
 * The followings are the available columns in table 'swt_content_section':
 * @property integer $id
 * @property string $title
 * @property string $alias_url
 * @property string $description
 * @property string $image
 * @property string $image_position
 * @property integer $published
 * @property integer $ordering
 * @property integer $access
 * @property string $params
 *
 * The followings are the available model relations:
 * @property SwtContentCategories[] $swtContentCategories
 * @property SwtContentSectionLang[] $swtContentSectionLangs
 */
class ContentSection extends CActiveRecord
{
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @return ContentSection the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()	{
		return 'swt_content_section';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('published, ordering, access', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>80),
			array('alias_url', 'length', 'max'=>200),
			array('image, description', 'length', 'max'=>255),
			array('image_position', 'length', 'max'=>30),
			array('params', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias_url, description, image, image_position, published, ordering, access, params', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'content_categories' => array(self::HAS_MANY, 'SwtContentCategories', 'content_section_id'),
			'content_section_langs' => array(self::HAS_MANY, 'SwtContentSectionLang', 'content_section_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('label', 'ID'),
			'title' => Yii::t('label', 'Section'),
			'alias_url' => Yii::t('label', 'Alias Url'),
			'description' => Yii::t('label', 'Description'),
			'image' => Yii::t('label', 'Image'),
			'image_position' => Yii::t('label', 'Image Position'),
			'published' => Yii::t('label', 'Published'),
			'ordering' => Yii::t('label', 'Ordering'),
			'access' => Yii::t('label', 'Access'),
			'params' => Yii::t('label', 'Params'),
		);
	}
	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias_url',$this->alias_url,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('image_position',$this->image_position,true);
		$criteria->compare('published',$this->published);
		$criteria->compare('ordering',$this->ordering);
		$criteria->compare('access',$this->access);
		$criteria->compare('params',$this->params,true);
		//$criteria->order = ''
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			/* 'pagination'=>array(
				'pageSize'=>20,
			), */
		));
	}
	

	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		}else {
			$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'title';
			$this->defaultColumns[] = 'alias_url';
			$this->defaultColumns[] = 'description';
			$this->defaultColumns[] = 'image';
			$this->defaultColumns[] = 'image_position';
			$this->defaultColumns[] = 'published';
			$this->defaultColumns[] = 'ordering';
			$this->defaultColumns[] = 'access';
			$this->defaultColumns[] = 'params';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		$current = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'title';
			//$this->defaultColumns[] = 'alias_url';
			$this->defaultColumns[] = 'description';
			$this->defaultColumns[] = 'image';
			//$this->defaultColumns[] = 'image_position';
			$this->defaultColumns[] = 'published';
			$this->defaultColumns[] = 'ordering';
			//$this->defaultColumns[] = 'access';
			//$this->defaultColumns[] = 'params';
		}
		parent::afterConstruct();
	}

	/**
	 * Get params	 setting
	 *	@param int categories_id, str $startType, str $endType
	 * @return array params
	 */
	 public function getParams($id, $startType, $endType)  {
		$result = array();
		$model = self::model()->findByPk($id, array('select'=>'params'));
		if($model != null) {			
			$arrParams = explode('-----', $model->params);
			foreach($arrParams as $key=>$val) {
				if(strpos($val, $startType) !== false)
					$index = $key;
			}
			$replaces = str_replace(array($startType, $endType), array('', ''), $arrParams[$index]);
			$listParams = explode(',', $replaces);
			foreach($listParams as $val) {
				$part = explode('=', $val);
				$result[trim($part[0])] = trim($part[1]);		
			}
		}
		return $result;
	 }

	/**
	 * before validate attributes
	 */
	/* protected function beforeValidate() {
		if(parent::beforeValidate()) {		
			if($this->isNewRecord) {
				$this->verifyPassword = $data;
			
			}else {
				
			}			
		}
		return true;
	} */
	
	/**
	 * before save attributes
	 */
	/* protected function beforeSave() {
		if(parent::beforeSave()) {
			if($this->isNewRecord) {
				$this->start_date 	= date('Y-m-d', strtotime($this->start_date));			
			}else {
				
			}
		}
		return true;
	} */
	
	
	/**
	 * After save attributes
	 */
	/* protected function afterSave() {
		parent::afterSave();
		// Create action		
	} */

}