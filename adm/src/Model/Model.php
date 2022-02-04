<?php

namespace Friweb\CMS\Model;

abstract class Model {

    // tabela no db
    protected static $table = '';

    // colunas no db
    protected static $columns = [];

    //
    protected $values = [];
    


    // construtor
    function __construct($array = '') {
        $this->loadFromArray($array);
    }


    // chama os métodos mágicos
    public function loadFromArray($array) {
        if($array) {
            foreach($array as $key => $value) {
                $this->$key = $value;
            }
        }
    }


    // getter
    public function __get($key) {
        return $this->values[$key];
    }


    // setter
    public function __set($key, $value) {
        $this->values[$key] = $value;
    }
    


    // retorna apenas uma row do db
        // conjunctionFilters: filtros 'and' no db; disjunctionFilters = filtros 'or' no db
    public static function getRow($conjunctionFilters = [], $columns = '*', $disjunctionFilters = []) {

        // recebe a classe que chamou a função
        $class = get_called_class();

        // 
        $result = static::getResultFromSelect($conjunctionFilters, $columns, $disjunctionFilters);

        //
        return $result ? new $class($result->fetch_assoc()) : null; 
    }

    //retorna a array instanciada ao objeto (classe);
    public static function get($conjunctionFilters = [], $columns = '*') {
        $objects = [];
        $result = static::getResultFromSelect($conjunctionFilters, $columns);
        if ($result) {
            $class = get_called_class();
            while ($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }

    // retorna query 'select' em array
    public static function getArraySelect($conjunctionFilters = [], $columns = '*',
     $disjunctionFilters = []) {

        $sql = "SELECT ${columns} from " . static::$table . static::getFiltersByConjunction($conjunctionFilters) . static::getFiltersByDisjunction($disjunctionFilters);

        $result = Database::getResultFromQuery($sql);

        if ($result->num_rows === 0) {
            return null;
        } else {
            while ($row = $result->fetch_assoc()) {
                $registros[] = $row;
            }
            return $registros;
        }
    }


    // retorna query 'select' em tipo 'mysqli_query'
    public static function getResultFromSelect($conjunctionFilters = [], $columns = '*',
        $disjunctionFilters = []) {

        // query
        $sql = "SELECT ${columns} from " . static::$table . static::getFiltersByConjunction($conjunctionFilters) . static::getFiltersByDisjunction($disjunctionFilters);

        // recebe o resultado da query
        $result = Database::getResultFromQuery($sql);

        // retorna, se número de linhas não for zero
        if ($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    public static function getPaginator($limit = '', $offset = '', $columns = '*', $order = 'DESC', $publish = '', $mixed = []) {

        // pega chave primaria da classe chamada (sempre primeiro valor na array $columns)
        foreach ( static::$columns as $key ) {
            $primaryKey = $key;
            break;
        }

        // query
        $sql = "SELECT ${columns} FROM ". static::$table . " WHERE ativo = 1";

        if ($publish != '') {
            $sql .= " AND publicar = 1";
        }

        if ($mixed != []) {
            $sql .= " AND (";
            foreach ($mixed as $index => $value) {
                $sql .= " ${index} = ${value} or";
            }
            $sql .= " 1 = 0)";
        }

        $sql .= " ORDER BY ${primaryKey} ${order}";

        // se for passado limite
        if ($limit != '') {
            $sql .= " LIMIT ${limit}";
        }

        // se for passado offset
        if ($offset != '') {
            $sql .= " OFFSET ${offset}";
        }

        // retorna query
        return Database::getResultFromQuery($sql);

    }

    // concatena filtros 'and'
    public static function getFiltersByConjunction($conjunctionFilters) {
        $sql = '';
        if (count($conjunctionFilters) > 0) {
            $sql .= " WHERE 1 = 1";
            foreach ($conjunctionFilters as $column => $value) {
                $sql .= " AND ${column} = " . static::getFormatedValue($value);
            }
        }
        return $sql;
    }

    // concatena filtros 'or'
    public static function getFiltersByDisjunction($disjunctionFilters) {
        $sql = '';
        if (count($disjunctionFilters) > 0) {
            $sql .= " WHERE 1 = 0";
            foreach ($disjunctionFilters as $column => $value) {
                $sql .= " OR ${column} = " . static::getFormatedValue($value);
            }
        }
        return $sql;
    }

    // tratamento de valores
    private static function getFormatedValue($value) {
        if (is_null($value)) {
            return "null";
        } elseif (gettype($value) == 'string') {
            return "'${value}'";
        } elseif (is_int($value)) {
            return $value;
        } else {
            return "null";
        }   
    }
}