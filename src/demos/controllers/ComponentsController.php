<?php


namespace khans\utils\demos\controllers;


use khans\utils\controllers\KHanWebController;

class ComponentsController extends KHanWebController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionJalali()
    {
        return $this->render('jalali');
    }
    public function actionDatePicker()
    {
        return $this->render('date-picker');
    }
    public function actionJwt()
    {
        return $this->render('jwt');
    }
    public function actionRestV2()
    {
        return $this->render('rest-v2');
    }
}