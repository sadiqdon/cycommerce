<?php

class OnlinePaymentSettingsController extends Controller
{
 
    public function actionIndex()
    {
        $settings = app()->settings;
 
        $model = new OnlinePaymentSettingsForm();
 
        if (isset($_POST['SettingsForm'])) {
            $model->setAttributes($_POST['SettingsForm']);
            $settings->deleteCache();
            foreach($model->attributes as $category => $values){
                $settings->set($category, $values);
            }
            user()->setFlash('success', 'Online Payment settings were updated.');
            $this->refresh();
        }
        foreach($model->attributes as $category => $values){
            $cat = $model->$category;
            foreach($values as $key=>$val){
                $cat[$key] = $settings->get($category, $key);
            }
            $model->$category = $cat;
        }
        $this->render('index', array('model' => $model));
    }
 
}