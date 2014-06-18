<?php
/**
 * EncryptModel
 *
 * Encrypt or decrypt data saved in a database.
 *
 */
class EncryptModel extends CActiveRecord
{
	/**
	 * Encryption key
	 */ 
	private $_encryptionKey = 'd3QaZX#g5JL8@Y%_Op(fH&!W&KL48DG)73TKnk5UT4oprVBE';
	
	/**
	 * Encrypt/Decrypt a string
	 * @param $text string to encrypt or decrypt
	 * @param $operation encrypt|decrypt
	 * @return return decrypted/encrypted text
	 */
	public function encryptDecrypt($text, $operation='encrypt')
	{
		if(!empty($text)){
			if (empty($this->_encryptionKey)) {
				throw new Exception();
				return '';
			}
			if (empty($operation) || !in_array($operation, array('encrypt', 'decrypt'))) {
				throw new Exception();
				return '';
			}
			if (strlen($this->_encryptionKey) < 32) {
				throw new Exception();
				return '';
			}
			
			$algorithm = 'rijndael-256';
			$mode = 'cbc';
			$cryptKey = substr($this->_encryptionKey, 0, 32);
			$iv = substr($this->_encryptionKey, strlen($this->_encryptionKey) - 32, 32);

			if ($operation === 'encrypt') {
				return mcrypt_encrypt($algorithm, $cryptKey, $text, $mode, $iv);
			}
			
			if(!$text) return $text;
			
			return rtrim(mcrypt_decrypt($algorithm, $cryptKey, $text, $mode, $iv), "\0");
		}
		return $text;
	}

	/**
	 * After Find
	 */
	public function afterFind()
	{
		
		foreach($this->encrypt as $key)
		{
			$this->{$key} = $this->encryptDecrypt($this->{$key}, 'decrypt');
		}
		parent::afterFind();
	}
	
	/**
	 * findAllByAttributes
	 */
	public function findAllByAttributes($attributes,$condition='',$params=array())
	{
        foreach($attributes as $attribute=>$value)
        {
        	if(in_array($attribute, $this->encrypt))
                $attributes[$attribute] = $this->encryptDecrypt($value);
        }
        
        return parent::findAllByAttributes($attributes, $condition, $params);
	}
	
	/**
	 * findByAttributes
	 */
	public function findByAttributes($attributes,$condition='',$params=array())
	{
        foreach($attributes as $attribute=>$value)
        {
        	if(in_array($attribute, $this->encrypt))
                $attributes[$attribute] = $this->encryptDecrypt($value);
        }
        
        return parent::findByAttributes($attributes, $condition, $params);
	}

	/**
	 * Before Save
	 */
	public function beforeSave()
	{
		parent::beforeSave();
		
		foreach($this->encrypt as $key)
		{
			$this->{$key} = $this->encryptDecrypt($this->{$key}, 'encrypt');
		}

		return true;
	}
	
	/**
	 * After save
	 */
	public function afterSave()
	{
		foreach($this->encrypt as $key)
		{
			$this->{$key} = $this->encryptDecrypt($this->{$key}, 'decrypt');
		}
		return parent::afterSave();
	}
}