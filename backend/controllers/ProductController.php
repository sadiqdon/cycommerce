<?php

class ProductController extends CrudController
{
	public $modelName = 'Product';
	
	private $_productoption = array();
	
	private $_productattribute = array();
	
	private $_productdiscount = array();
	
	private $_productspecial = array();
	
	public function actionView($id) {
		parent::view($id, $this->modelName);
	}

	public function actionCreate() {		
		$model = new Product;
		$description = new ProductDescription;
		$image = new XUploadForm;
		$userImages = array();
		$thumbs = array();
		if(!isset($_POST[$this->modelName])){
			Yii::app()->user->setState( 'product_images', NULL );
			Yii::app()->user->setState( 'thumbs', NULL );
		}
		//$product_option_value = new ProductOptionValue;
		
		$this->performAjaxValidation(array($model,$description), 'product-form');
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			
			$suc = Yii::t('info','Product was successfully created');
			$err = Yii::t('info','Could not create Product');
			$description->product_id = 0;
			$description->locale_code = Yii::app()->getLanguage();
			//$description->link = str_replace(' ','-',trim(strtolower(str_replace('_','-',preg_replace('/(?<![A-Z])[A-Z]/', '\0', $description->name)))));
			$description->link = strtolower(str_replace(' ','-',preg_replace('!\s+!', ' ', trim(preg_replace("/[^A-Za-z ]/", ' ', $description->name)))));
			$userImages = Yii::app()->user->getState('product_images');
			$thumbs = Yii::app()->user->getState('thumbs');
			
			if( Yii::app()->user->hasState('thumbs') ) {
				if ($this->validateProduct($model, $description)){
					if ($model->save()) {
						$description->product_id = $model->id;
						$description->save();
						$this->addImages($model->id, 'Image', 'thumbs','Product');
						$tpath = realpath(UtilityHelper::yiiparam('frontPath').'/www'.$model->thumbs[0]->source );	
						$timage = Yii::app()->image->load($tpath);
						$timage->resize(200, 200);
						$timage->save();
						$this->productSave($model);
						
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
						if (Yii::app()->getRequest()->getIsAjaxRequest()){
							$this->renderPartial('_view', array('model' => $model, 'description' => $description, 'option'=> $this->_productoption, 'attribute' => $this->_productattribute), false, true);					
							Yii::app()->end();
						}else
							$this->redirect(array('view', 'id' => $model->id));
					}else{
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
					}				
				}
			}else{
				Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR, Yii::t('info','Please upload an image'));
			}
			
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form_product', array('model' => $model, 'description' => $description, 'option'=> $this->_productoption, 'attribute' => $this->_productattribute, 'thumbs'=>$thumbs, 'image' => $image, 'userImages'=> $userImages, 'discount' =>  $this->_productdiscount, 'special' =>  $this->_productspecial), false, true);
			Yii::app()->end();
		}
		$this->render('create', array( 'model' => $model, 'description' => $description, 'option'=> $this->_productoption, 'attribute' => $this->_productattribute, 'thumbs'=>$thumbs, 'image' => $image, 'userImages'=> $userImages, 'discount' =>  $this->_productdiscount, 'special' =>  $this->_productspecial));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, $this->modelName);
		$description = $model->productDescriptions[0];
		$image = new XUploadForm;
		if(!isset($_POST[$this->modelName])){
			$this->loadImages($model, 'product_images');
			$this->loadImages($model, 'thumbs', 'thumbs');
		}
		$this->loadProductOption($model->id);
		$this->loadProductAttribute($model->id);
		$this->loadProductDiscount($model->id);
		$this->loadProductSpecial($model->id);
		$this->performAjaxValidation(array($model,$description), 'product-form');
		$userImages = Yii::app( )->user->getState( 'product_images' );
		$thumbs = Yii::app()->user->getState('thumbs');
		
		
		if (isset($_POST[$this->modelName])) {
			$model->setAttributes($_POST[$this->modelName]);
			$description->setAttributes($_POST[$this->modelName.'Description']);
			$suc = Yii::t('info','Product was successfully updated');
			$err = Yii::t('info','Could not update Product');
			if( Yii::app()->user->hasState('thumbs') ) {
				if ($this->validateProduct($model, $description)){
					if ($model->save()) {
						$description->product_id = $model->id;
						$description->link = strtolower(str_replace(' ','-',preg_replace('!\s+!', ' ', trim(preg_replace("/[^A-Za-z ]/", ' ', $description->name)))));
						$description->save();
						$this->deleteImages($model, 'thumbs');
						$this->addImages($model->id, 'Image', 'thumbs','Product');
						$tpath = realpath(UtilityHelper::yiiparam('frontPath').'/www'.$model->thumbs[0]->source );											
						$timage = Yii::app()->image->load($tpath);
						$timage->resize(200, 200);
						$timage->save();
						$this->productUpdate($model);
						
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_SUCCESS,$suc);
						if (Yii::app()->getRequest()->getIsAjaxRequest()){
							$this->renderPartial('_view', array('model' => $model, 'description' => $description, 'option'=> $this->_productoption, 'attribute' => $this->_productattribute), false, true);					
							Yii::app()->end();
						}else
							$this->redirect(array('view', 'id' => $model->id));
					}else{
						Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$err);
					}
				}
			}
		}
		if (Yii::app()->getRequest()->getIsAjaxRequest()){
			$this->renderPartial('_form_product', array('model' => $model, 'description' => $description, 'option'=> $this->_productoption, 'attribute' => $this->_productattribute, 'thumbs'=>$thumbs, 'image' => $image, 'userImages'=> $userImages, 'discount' =>  $this->_productdiscount, 'special' =>  $this->_productspecial), false, true);
			Yii::app()->end();
		}
		$this->render('update', array( 'model' => $model, 'description' => $description, 'option'=> $this->_productoption, 'attribute' => $this->_productattribute, 'thumbs'=>$thumbs, 'image' => $image, 'userImages'=> $userImages, 'discount' =>  $this->_productdiscount, 'special' =>  $this->_productspecial));
	}
	
	protected function productUpdate($model)
	{		
		$id = $model->id;
		ProductCategory::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($model->categories))
			foreach ($model->categories as $catid){
				$productCategories = new ProductCategory;
				$productCategories->product_id = $model->id;
				$productCategories->category_id = $catid;
				$productCategories->save();
			}
		ProductRelated::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($model->relatedA))
			foreach ($model->relatedA as $rid){
				$productRelations = new ProductRelated;
				$productRelations->product_id = $id;
				$productRelations->related_id = $rid;
				$productRelations->save();
			}
		ProductStore::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));	
		if(!empty($model->stores))
			foreach ($model->stores as $sid){
				$productStores = new ProductStore;
				$productStores->product_id = $id;
				$productStores->store_id = $sid;
				$productStores->save();
			}
		$this->deleteImages($model);
		$productImages = Yii::app()->user->getState('product_images');
		if(!empty($productImages))
			$this->addImages($model->id, 'ProductImage', 'product_images','Product');
		//This needs to be updated, you cant delete 	
		ProductOption::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		ProductOptionValue::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		foreach($this->_productoption as $productoption){
			$optionModel = $productoption[0];
			$valueModel = $productoption[1];
			$optionModel->product_id = $id;					
			$optionModel->save();
			foreach($valueModel as $value){
				$value->product_option_id = $optionModel->id;
				$value->product_id = $id;
				$value->option_id = $optionModel->option_id;
				$value->save();
			}
		}
		ProductAttribute::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($this->_productattribute))
			foreach($this->_productattribute as $productattribute){
				$productattribute->product_id = $id;
				$productattribute->save();
			}
		ProductDiscount::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($this->_productdiscount))
			foreach($this->_productdiscount as $productdiscount){
				$productdiscount->product_id = $id;
				//$productdiscount->date_start = date('Y-m-d',strtotime($productdiscount->date_start));
				//$productdiscount->date_end = date('Y-m-d',strtotime($productdiscount->date_end));
				$productdiscount->save();
			}
		ProductSpecial::model()->deleteAll('product_id=:product_id', array(':product_id'=>$id));
		if(!empty($this->_productspecial))
			foreach($this->_productspecial as $productspecial){
				$productspecial->product_id = $id;
				//$productspecial->date_start = date('Y-m-d',strtotime($productspecial->date_start));
				//$productspecial->date_end = date('Y-m-d',strtotime($productspecial->date_end));
				$productspecial->save();
			}
	}
	
	protected function productSave($model){
		$id = $model->id;
		if(!empty($model->categories))
			foreach ($model->categories as $catid){
				$productCategories = new ProductCategory;
				$productCategories->product_id = $id;
				$productCategories->category_id = $catid;
				$productCategories->save();
			}
		if(!empty($model->relatedA))
			foreach ($model->relatedA as $rid){
				$productRelations = new ProductRelated;
				$productRelations->product_id = $id;
				$productRelations->related_id = $rid;
				$productRelations->save();
			}
		if(!empty($model->stores))
			foreach ($model->stores as $sid){
				$productStores = new ProductStore;
				$productStores->product_id = $id;
				$productStores->store_id = $sid;
				$productStores->save();
			}
		$productImages = Yii::app()->user->getState('product_images');
		if(!empty($productImages))
			$this->addImages($id, 'ProductImage', 'product_images','Product');
		if(!empty($this->_productoption))
			foreach($this->_productoption as $productoption){
				$optionModel = $productoption[0];
				$valueModel = $productoption[1];
				$optionModel->product_id = $id;					
				$optionModel->save();
				foreach($valueModel as $value){
					$value->product_option_id = $optionModel->id;
					$value->product_id = $id;
					$value->option_id = $optionModel->option_id;
					$value->save();
				}
			}
		if(!empty($this->_productattribute))
			foreach($this->_productattribute as $productattribute){
				$productattribute->product_id = $id;
				$productattribute->save();
			}
		if(!empty($this->_productdiscount))
			foreach($this->_productdiscount as $productdiscount){
				$productdiscount->product_id = $id;
				$productdiscount->date_start = date('Y-m-d',strtotime($productdiscount->date_start));
				$productdiscount->date_end = date('Y-m-d',strtotime($productdiscount->date_end));
				$productdiscount->save();
			}
		if(!empty($this->_productspecial))
			foreach($this->_productspecial as $productspecial){
				$productspecial->product_id = $id;
				$productspecial->date_start = date('Y-m-d',strtotime($productspecial->date_start));
				$productspecial->date_end = date('Y-m-d',strtotime($productspecial->date_end));
				$productspecial->save();
			}
	
	}
	
	public function validateProduct(&$model, &$description)
	{
		$error = '';
		$poption = $this->validateProductOption();
		$pattribute = $this->validateProductAttribute();
		$pdiscount = $this->validateProductDiscount();
		$pspecial = $this->validateProductSpecial();
		$productImages = Yii::app()->user->getState('product_images');
		
		if(!$poption)
			$error .= Yii::t('info','Please fill in all values for Product Options').'<br/>';
		if(!$pattribute)
			$error .= Yii::t('info','Please fill in all values for Product Attributes').'<br/>';
		if(!$pdiscount)
			$error .= Yii::t('info','Please fill in all values for Product Discounts').'<br/>';
		if(!$pspecial)
			$error .= Yii::t('info','Please fill in all values for Product Specials').'<br/>';
		if(empty($productImages)) 
			$error .= Yii::t('info','Please upload image(s) using the image tab').'<br/>';
		if(!empty($error))	
			Yii::app()->user->setFlash(TbHtml::ALERT_COLOR_ERROR,$error);
			
		return $model->validate() && $description->validate() && $poption && $pattribute && $pdiscount && $pspecial && !empty($productImages);
	}
	
	public function actionSort()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$i = 0;
			foreach ($_POST['items'] as $item) {
				$project = Product::model()->findByPk($item);
				$project->sort_order = $i;
				$project->save();
				$i++;
			}
		}
	}
	
	public function loadProductOption($id){
		$data = ProductOption::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
		foreach($data as $productoption){
			$value = ProductOptionValue::model()->findAll('product_option_id=:product_option_id', array(':product_option_id'=>$productoption->id));
			$valueList[] = $value;
			$this->_productoption[] = array($productoption, $value);
		}
		return $this->_productoption;
	}
		
	public function loadProductAttribute($id){
		$this->_productattribute = ProductAttribute::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
	}
	
	public function loadProductDiscount($id){
		$this->_productdiscount = ProductDiscount::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
	}
	
	public function loadProductSpecial($id){
		$this->_productspecial = ProductSpecial::model()->findAll('product_id=:product_id', array(':product_id'=>$id));
	}
	
	public function validateProductDiscount(){
		if(isset($_POST['ProductDiscount']))
		{
			$valid=true;
			$this->_productdiscount = array();
				/*Yii::log( "ProductCreateAction: ".CVarDumper::dumpAsString( $_POST['ProductOption'] ),
						CLogger::LEVEL_ERROR, "product.actions.create" 
					);*/
				foreach($_POST['ProductDiscount'] as $i=>$pdiscount)
				{
					if(isset($_POST['ProductDiscount'][$i])){
						$discount = new ProductDiscount;
						$discount->product_id = 0;
						$discount->attributes = $_POST['ProductDiscount'][$i];
						$discount->date_start = date('Y-m-d',strtotime($_POST['ProductDiscount'][$i]['date_start']));
						$discount->date_end = date('Y-m-d',strtotime($_POST['ProductDiscount'][$i]['date_end']));
						Yii::log( "ProductCreateAction: ".$discount->date_start." ".$discount->date_end,
						CLogger::LEVEL_ERROR, "product.actions.create" 
					);
						$valid=$discount->validate() && $valid;
						$this->_productdiscount[] = $discount;
					}
				}
				if(!$valid){
					return false;
				}
			
		}
		return true;
	}
	
	public function validateProductSpecial(){
		if(isset($_POST['ProductSpecial']))
		{
			$valid=true;
			$this->_productspecial = array();
				/*Yii::log( "ProductCreateAction: ".CVarDumper::dumpAsString( $_POST['ProductOption'] ),
						CLogger::LEVEL_ERROR, "product.actions.create" 
					);*/
				foreach($_POST['ProductSpecial'] as $i=>$special)
				{
					if(isset($_POST['ProductSpecial'][$i])){
						$special = new ProductSpecial;
						$special->product_id = 0;
						$special->attributes = $_POST['ProductSpecial'][$i];
						$special->date_start = date('Y-m-d',strtotime($_POST['ProductSpecial'][$i]['date_start']));
						$special->date_end = date('Y-m-d',strtotime($_POST['ProductSpecial'][$i]['date_end']));
						$valid=$special->validate() && $valid;
						$this->_productspecial[] = $special;
					}
				}
				if(!$valid){
					return false;
				}
			
		}
		return true;
	}
	
	public function validateProductAttribute(){
		if(isset($_POST['ProductAttribute']))
		{
			$valid=true;
			$this->_productattribute = array();
				/*Yii::log( "ProductCreateAction: ".CVarDumper::dumpAsString( $_POST['ProductOption'] ),
						CLogger::LEVEL_ERROR, "product.actions.create" 
					);*/
				foreach($_POST['ProductAttribute'] as $i=>$attribute)
				{
					if(isset($_POST['ProductAttribute'][$i])){
						$attribute = new ProductAttribute;
						$attribute->product_id = 0;
						$attribute->locale_code = Yii::app()->getLanguage();
						$attribute->attributes = $_POST['ProductAttribute'][$i];
						$valid=$attribute->validate() && $valid;
						$this->_productattribute[] = $attribute;
					}
				}
				if(!$valid){
					return false;
				}
			
		}
		return true;
	}
	
	public function validateProductOption(){
		if(isset($_POST['ProductOption']))
		{
			$valid=true;
			$this->_productoption = array();
				/*Yii::log( "ProductCreateAction: ".CVarDumper::dumpAsString( $_POST['ProductOption'] ),
						CLogger::LEVEL_ERROR, "product.actions.create" 
					);*/
				foreach($_POST['ProductOption'] as $i=>$item)
				{
					if(isset($_POST['ProductOption'][$i])){
						$option = new ProductOption;
						$option->product_id = 0;
						if(isset($_POST['ProductOption'][$i]['option_id']))
							$option->option_id = $_POST['ProductOption'][$i]['option_id'];
						if(isset($_POST['ProductOption'][$i]['option_value']))
							$option->option_value = $_POST['ProductOption'][$i]['option_value'];
						$option->required = $_POST['ProductOption'][$i]['required'];
						$valid=$option->validate() && $valid;
						$optionvalue = array();
						if(isset($_POST['ProductOption'][$i]['ProductOptionValue'])){
							foreach($_POST['ProductOption'][$i]['ProductOptionValue'] as $j=>$item)
							{
								if(isset($_POST['ProductOption'][$i]['ProductOptionValue'][$j])){
									$model = new ProductOptionValue;
									$model->attributes = $_POST['ProductOption'][$i]['ProductOptionValue'][$j];
									$model->product_option_id = 0;
									$model->product_id = 0;
									$model->option_id = 0;
									$valid=$model->validate() && $valid;
									$optionvalue[] = $model;
								}
							}
						}
						$this->_productoption[] = array($option, $optionvalue);
					}
				}
				if(!$valid){
					return false;
				}
			
		}
		return true;
	}
	
	public function actionGetOptionValue($id){
		echo CJSON::encode(Editable::source(OptionValue::model()->findAll('option_id=:option_id', array(':option_id'=>$id)),'id',function($data){ return CHtml::encode($data->getName());}));
	}
	
	public function actionGetCustomerGroup(){
		echo CJSON::encode(Editable::source(CGroup::model()->findAll(),'id',function($data){ return CHtml::encode($data->getName());}));
	}
	
	public function actionGetAttributeName(){
		echo CJSON::encode(Editable::source(Attribute::model()->findAll(),'id',function($data){ return CHtml::encode($data->getName());}));
	}
	
	public function actionDelete($id) {
			parent::delete($id, $this->modelName, array('productDescriptions'));
	}
	
	public function actionBatchDelete() {
			parent::batchDelete($this->modelName, array('productDescriptions'));
	}
	
	public function actionExportSelected() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'model',
		'sku',
		'upc',
		'ean',
		'jan',
		'isbn',
		'mpn',
		'location',
		'quantity',
		'stock_status_id',
		'image',
		'manufacturer_id',
		'shipping',
		'price',
		'points',
		'tax_class_id',
		'date_available',
		'weight',
		'weight_class_id',
		'length',
		'width',
		'height',
		'length_class_id',
		'subtract',
		'minimum',
		'sort_order',
		'status',
		'date_added',
		'date_modified',
		'viewed',
		);
		 		$criteriaWith = array(
			'productDescriptions'=>array(
                          'together'=>true
                     ),
		);
		parent::exportSelected($this->modelName, 't.id', $criteriaWith, $exportfield);
	}
	
	public function actionExportAll() {
		$criteriaWith = array();
		$exportfield = array(
		'id',
		'model',
		'sku',
		'upc',
		'ean',
		'jan',
		'isbn',
		'mpn',
		'location',
		'quantity',
		'stock_status_id',
		'image',
		'manufacturer_id',
		'shipping',
		'price',
		'points',
		'tax_class_id',
		'date_available',
		'weight',
		'weight_class_id',
		'length',
		'width',
		'height',
		'length_class_id',
		'subtract',
		'minimum',
		'sort_order',
		'status',
		'date_added',
		'date_modified',
		'viewed',
		);
		$criteriaWith = array(
			'productDescriptions'=>array(
                          'together'=>true
                     ),
		);
		
		parent::exportAll($this->modelName, $criteriaWith, $exportfield);
	}

	public function actionIndex() {
		$dorder = '';
		$modelName = $this->modelName;
		if($modelName::model()->hasAttribute('sort_order'))
			$dorder = 't.sort_order ASC';
		else if($modelName::model()->hasAttribute('id'))
			$dorder = 't.id DESC';
		$criteriaWith = $attr = array();
		$criteriaWith = array(
			'productDescriptions'=>array(
                          'together'=>true
                     ),
		);
		$attr['name'] = array('asc' => 'productDescriptions.name ASC', 'desc' => 'productDescriptions.name DESC');
		
		$attr[] = '*';
		$sort = array( 'defaultOrder' => $dorder, 'attributes' => $attr);
		parent::index($this->modelName, $sort, $criteriaWith);
	}

	public function actionAdmin() {
		$model = new Product('search');
		parent::admin($model, $this->modelName);	
	}
}
