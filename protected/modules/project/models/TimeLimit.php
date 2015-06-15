<?php

/**
 * This is the model class for table "ic_time_limit".
 *
 * The followings are the available columns in table 'ic_time_limit':
 * @property integer $id
 * @property integer $month_limit
 * @property integer $is_funding_time
 * @property integer $is_actived
 */
class TimeLimit extends CActiveRecord
 {
	public $defaultColumns = array();

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TimeLimit the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'ic_time_limit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('month_limit, is_funding_time', 'required'),
			array('month_limit, is_funding_time, is_actived', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, month_limit, is_funding_time, is_actived', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('label', 'ID'),
			'month_limit' => Yii::t('label', 'Batas Bulan'),
			'is_funding_time' => Yii::t('label', 'Jenis Waktu'),
			'is_actived' => Yii::t('label', 'Aktif'),
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

		$criteria->compare('id',$this->id);
		$criteria->compare('month_limit',$this->month_limit);
		$criteria->compare('is_funding_time',$this->is_funding_time);
		$criteria->compare('is_actived',$this->is_actived);

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
			$this->defaultColumns[] = 'month_limit';
			$this->defaultColumns[] = 'is_funding_time';
			$this->defaultColumns[] = 'is_actived';
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
			//$this->defaultColumns[] = 'id';
			$this->defaultColumns[] = 'month_limit';
			$this->defaultColumns[] = //'is_funding_time';
                array(
                    "name"=>'is_funding_time',
                    "type"=>'raw',
                    "value"=>  '($data->is_funding_time==1)?Pendanaan:Project',
                );
			$this->defaultColumns[] = //'is_actived';
                array(
                    "name"=>'is_actived',
                    "type"=>'raw',
                    "value"=>  'Utility::getPublishedToImg($data->is_actived)',
                );
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

    public static function getCategory($id) {
        $model = self::model()->findAll(array('condition'=>'is_funding_time='.$id));
        $items = array();
        if($model != null) {
            foreach($model as $key => $val) {
                $items[$val->month_limit] = $val->month_limit;
            }
            return $items;
        } else {
            return false;
        }
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