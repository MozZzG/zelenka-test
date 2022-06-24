<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @package app\common\models
 * 
 * @property int $id
 * @property int $real_id
 * @property string $user_name
 * @property string $user_phone
 * @property string $warehouse_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $status
 * @property int $items_count
 */
class Order extends ActiveRecord {
    public static function tableName() {
        return "order";
    }
}