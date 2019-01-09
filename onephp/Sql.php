<?php

class Sql
{
    private static $dbConfig = [];
    private $filter = '';

    // 连接数据库
    public function pdo()
    {
        return Db::pdo(self::$dbConfig);
    }

    // 保存数据库配置
    public static function setConfig($config)
    {
        self::$dbConfig = $config;
    }

    // 查询条件
    public function where($where = array())
    {
        if (isset($where)) {
            $this->filter .= ' WHERE ';
            $this->filter .= implode(' ', $where);
        }

        return $this;
    }

    // 排序条件
    public function order($order = array())
    {
        if (isset($order)) {
            $this->filter .= 'ORDER BY ';
            $this->filter .= implode(',', $order);
        }

        return $this;
    }

    // 查询所有
    public function selectAll()
    {
        $sql = sprintf("select * from `%s` %s", $this->table, $this->filter);
        $sth = $this->pdo()->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();
    }

    // 根据条件 (id) 查询
    public function select($id)
    {
        $sql = sprintf("select * from `%s` where `id` = '%s'", $this->table, $id);
        $sth = $this->pdo()->prepare($sql);
        $sth->execute();

        return $sth->fetch();
    }

    // 根据条件 (id) 删除
    public function delete($id)
    {
        $sql = sprintf("delete from `%s` where `id` = '%s'", $this->table, $id);
        $sth = $this->pdo()->prepare($sql);
        $sth->execute();

        return $sth->rowCount();
    }

    // 自定义SQL查询，返回影响的行数
    public function query($sql)
    {
        $sth = $this->pdo()->prepare($sql);
        $sth->execute();

        return $sth->rowCount();
    }

    // 新增数据
    public function add($data)
    {
        $sql = sprintf("insert into `%s` %s", $this->table, $this->formatInsert($data));

        return $this->query($sql);
    }

    // 修改数据
    public function update($id, $data)
    {
        $sql = sprintf("update `%s` set %s where `id` = '%s'", $this->table, $this->formatUpdate($data), $id);

        return $this->query($sql);
    }

    // 将数组转换成插入格式的sql语句
    private function formatInsert($data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $values[] = sprintf("'%s'", $value);
        }

        $field = implode(',', $fields);
        $value = implode(',', $values);

        return sprintf("(%s) values (%s)", $field, $value);
    }

    // 将数组转换成更新格式的sql语句
    private function formatUpdate($data)
    {
        $fields = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s` = '%s'", $key, $value);
        }

        return implode(',', $fields);
    }
}