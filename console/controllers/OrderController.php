<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\Order;
use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class OrderController extends Controller {
    public function actionUpdateNet($url) {
        $data = file_get_contents($url); 
        $this->processData($data);
    }  
    
    public function actionUpdateLocal($path) {
        $data = file_get_contents(Yii::getAlias("@console/../$path"));
        $this->processData($data);   
    }
    
    public function actionInfo($id) {
        if (!empty($order = Order::findOne(['id' => $id]))) {
            echo Json::encode($order->attributes, JSON_PRETTY_PRINT);
        } else {
            echo "Заказ не найден.\n";
        } 
    }
    
    private function processData($data) {
        if (!empty($data)) {
            $encoded = json_decode($data, true);
            if ($encoded !== null) {
                $orders = $encoded['orders'] ?? [];
                foreach ($orders as $orderData) {
                    if (empty($id = $orderData['id'] ?? null)) {
                        continue; // не обрабатывать записи без ID
                    }
                    
                    if (empty($order = Order::findOne(['id' => $id]))) {
                        $order = new Order([
                            'id' => $id
                        ]);
                    }
                    
                    $order->real_id = $orderData['real_id'] ?? null;
                    $order->user_name = $orderData['user_name'] ?? null;
                    $order->user_phone = $orderData['user_phone'] ?? null;
                    $order->warehouse_id = $orderData['warehouse_id'] ?? null;
                    $order->created_at = $orderData['created_at'] ?? null;
                    $order->status = $orderData['status'] ?? null;
                    $order->items_count = count($orderData['items'] ?? []);
                    
                    if (!$order->save()) {
                        echo "Ошибка сохранения заказа: ".VarDumper::dumpAsString([
                            'аттрибуты' => $order->attributes,
                            'ошибки' => $order->getErrors(),
                        ])."\n";
                    }
                } 
        
            } else {
                echo "Ошибка в полученных данных: ".json_last_error_msg()."\n";
            }
        } else {
            echo "Данные не найдены.\n";    
        }
    }
}