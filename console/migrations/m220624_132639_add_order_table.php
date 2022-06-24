<?php

use yii\db\Migration;

/**
 * Class m220624_132639_add_order_table
 */
class m220624_132639_add_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'order',
            [
                'id' => $this->bigInteger(),
                'real_id' => $this->bigInteger(),
                'user_name' => $this->string(30),
                'user_phone' => $this->string(30),
                'warehouse_id' => $this->string(10),
                'status' => $this->integer(),
                'items_count' => $this->integer(),
                'created_at' => $this->dateTime(),
                'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            ]
        );
        
        $this->addPrimaryKey('pk-order', 'order', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk-order', 'order');
        
        $this->dropTable('order');
    }
}
