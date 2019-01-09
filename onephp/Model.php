<?php

class Model extends Sql
{
    protected $_model;
    protected $_table;
    public static $dbConfig = [];

    public function __construct()
    {
        // 连接数据库
        $this->connect(self::$dbConfig['host'], self::$dbConfig['username'], self::$dbConfig['password'], self::$dbConfig['dbname']);


        // 获取数据库表名
        if (!$this->_table) {
            // 获取模型类实例
            $this->_model = get_class($this);
            // 删除类名最后的 Model 字符
            $this->_model = substr($this->_model, 0, -5);

            // 数据库表名与类名一致
            $this->_table = strtolower($this->_model);
        }
    }
}