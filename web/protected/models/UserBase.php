<?php

/**
 * This is the model class for table "mbu_user".
 *
 * The followings are the available columns in table 'mbu_user':
 * @property integer $ID
 * @property string $USER_ID
 * @property string $PASSWORD
 * @property string $FIRST
 * @property string $LAST
 * @property string $PHONE
 * @property string $EMAIL
 * @property string $ADDRESS_LINE_1
 * @property string $ADDRESS_LINE_2
 * @property string $CITY
 * @property string $ZIP_CODE
 *
 * The followings are the available model relations:
 * @property EntryHeader[] $entryHeaders
 */
abstract class UserBase extends CActiveRecord
{
	private $_retrievedPassword; //the password retreived on a find operation
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	protected function afterFind(){
		parent::afterFind();
		$this->_retrievedPassword = $this->getAttribute('PASSWORD');
		$this->setAttribute('PASSWORD', null);
	}
	
	/**
	 * Determines whether the given password matches the password retrieved from the database.
	 * @param string $password The password to test.
	 * @return boolean True if the passwords match, otherwise false.
	 */
	public function validatePassword($password){
		return $this->hashPassword($password) == $this->_retrievedPassword;
	}
	
	/**
	 * Gets a hashed version of the password.
	 * @return The hashed password, in a 40-character string.
	 */
	private function hashPassword($pass){
		$hashed = hash_hmac('md5', $pass, PrivateField::get('hashkey'));
		$hashed = hash_hmac('sha1', $hashed, PrivateField::get('hashkey'));
		return $hashed;
	}
	
	protected function beforeSave(){
		if(parent::beforeSave()){		
			if($this->PASSWORD != null){
				$this->setAttribute('PASSWORD', $this->hashPassword($this->PASSWORD));	
			} else {
				$this->setAttribute('PASSWORD', $this->_retrievedPassword);				
			}			
		}
		return true;
	}
}