<?php

/**
 * This is the model class for table "lookup".
 *
 * The followings are the available columns in table 'lookup':
 * @property integer $ID
 * @property integer $CODE
 * @property string $NAME
 * @property string $TYPE
 * @property integer $POSITION
 *
 * The followings are the available model relations:
 * @property Setting[] $settings
 * @property SettingCategory[] $settingCategories
 */
class Lookup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Lookup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lookup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CODE, POSITION', 'numerical', 'integerOnly'=>true),
			array('NAME, TYPE', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CODE, NAME, TYPE, POSITION', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'CODE' => 'Code',
			'NAME' => 'Name',
			'TYPE' => 'Type',
			'POSITION' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('CODE',$this->CODE);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('TYPE',$this->TYPE,true);
		$criteria->compare('POSITION',$this->POSITION);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Gets the text corresponding to the given lookup unique ID, when type is not provided.
	 * Gets the text corresponding to the given lookup code and type, when type is provided.
	 * Returns null if no matching item is found.
	 */
	public static function getText($id, $type=''){
		if($type === ''){
			$result = Lookup::model()->findByPk((int) $id);
		} else {
			$result = Lookup::model()->findByAttributes(array('CODE'=>$id, 'TYPE'=>$type));	
		}
		$text = null;
		if($result != null){
			$text = $result->NAME;
		}
		return $text;
	}
	
	/**
	 * Gets an array of values (code=>name) corresponding to the given lookup type.
	 */
	public static function listValues($type){
		$result = Lookup::model()->findAllByAttributes(array('TYPE'=>$type), array('order'=>'POSITION, CODE'));
		$values = array();
		foreach($result as $resultVal){
			$values[$resultVal->CODE] = $resultVal->NAME;
		}
		return $values;
	}
}