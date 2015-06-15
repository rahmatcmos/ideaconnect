<?php

/**
 * This is the model class for table "ic_progress_detail".
 *
 * The followings are the available columns in table 'ic_progress_detail':
 * @property string $id
 * @property string $task_name
 * @property string $detail
 * @property string $start_date
 * @property string $end_date
 * @property string $updated_time
 * @property string $parent_id
 * @property string $project_id
 *
 * The followings are the available model relations:
 * @property ProgressDetail $parent
 * @property ProgressDetail[] $icProgressDetails
 * @property IcProject $project
 * @property IcShowProgressDetail[] $icShowProgressDetails
 */
class ProgressDetail extends CActiveRecord
 {
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProgressDetail the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'ic_progress_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('task_name, detail, start_date, end_date, updated_time, project_id', 'required'),
			array('task_name', 'length', 'max'=>255),
			array('parent_id, project_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, task_name, detail, start_date, end_date, updated_time, parent_id, project_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'parent' => array(self::BELONGS_TO, 'ProgressDetail', 'parent_id'),
			'ic_progress_details' => array(self::HAS_MANY, 'ProgressDetail', 'parent_id'),
			'project' => array(self::BELONGS_TO, 'IcProject', 'project_id'),
			'ic_show_progress_details' => array(self::HAS_MANY, 'IcShowProgressDetail', 'progress_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('label', 'ID'),
			'task_name' => Yii::t('label', 'Task Name'),
			'detail' => Yii::t('label', 'Detail'),
			'start_date' => Yii::t('label', 'Start Date'),
			'end_date' => Yii::t('label', 'End Date'),
			'updated_time' => Yii::t('label', 'Updated Time'),
			'parent_id' => Yii::t('label', 'Parent'),
			'project_id' => Yii::t('label', 'Project'),
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('task_name',$this->task_name,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('updated_time',$this->updated_time,true);
		$criteria->compare('parent_id',$this->parent_id,true);
		$criteria->compare('project_id',$this->project_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
			$this->defaultColumns[] = 'task_name';
			$this->defaultColumns[] = 'detail';
			$this->defaultColumns[] = 'start_date';
			$this->defaultColumns[] = 'end_date';
			$this->defaultColumns[] = 'updated_time';
			$this->defaultColumns[] = 'parent_id';
			$this->defaultColumns[] = 'project_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'task_name';
			$this->defaultColumns[] = 'detail';
			$this->defaultColumns[] = 'start_date';
			$this->defaultColumns[] = 'end_date';
			$this->defaultColumns[] = 'updated_time';
			$this->defaultColumns[] = 'parent_id';
			$this->defaultColumns[] = 'project_id';
			/* $this->defaultColumns[] = array(
				'name' => 'publish',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl("publish",array("id"=>$data->id)), $data->publish, 1)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'type' => 'raw',
			); */

		}
		parent::afterConstruct();
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