<?php

namespace Make\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Metadata\Metadata;
/**
 * Metadata
 */
class Table {

    protected $metadata;
    protected $name;
    protected $columns;
    protected $constraints;
    protected $tablenames;
    protected $properts;
    protected $columnsName;

    public function __construct(Adapter $adapter) {
        $this->metadata = new Metadata($adapter);
        $this->setTablenames($this->metadata->getTableNames());
        
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function getName() {
        return $this->name;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getConstraints($key="") {
        if(empty($key)):
        return $this->constraints;
        endif;
        return $this->constraints[$key];
    }

    public function getTablenames() {
        return $this->tablenames;
    }
    
    public function getProperts() {
        return $this->properts;
    }

    public function setName($name) {
        $this->name = $this->metadata->getTable($name);
        return $this;
    }
    public function getColumnsName() {
        return $this->columnsName;
    }

    
    public function setColumns($tableName) {
        $table = $this->metadata->getTable($tableName);
        foreach ($table->getColumns() as $column):
            $this->columns[$column->getName()] = [
                'name' => $column->getName(),
                'schemaName' => $column->getSchemaName(),
                'ordinalPosition' => $column->getOrdinalPosition(),
                'columnDefault' => $column->getColumnDefault(),
                'isNullable' => $column->getIsNullable(),
                'dataType' => $column->getDataType(),
                'characterMaximumLength' => $column->getCharacterMaximumLength(),
                'characterOctetLength' => $column->getCharacterOctetLength(),
                'numericPrecision' => $column->getNumericPrecision(),
                'numericScale' => $column->getNumericScale(),
                'numericUnsigned' => $column->getNumericUnsigned()
            ];
            $this->setColumnsName($column);
        endforeach;
        $this->setConstraints($tableName);
        $this->setProperts();
        return $this;
    }

    public function setConstraints($tableName) {
        $pkCols = [];
        $fkCols = [];
        foreach ($this->metadata->getConstraints($tableName) as $constraint) {
            $pkCols[] = [$constraint->getName(), $constraint->getType()];
            if (!$constraint->hasColumns()) {
                continue;
            }
            if ($constraint->isForeignKey()) {
                $fkCols = array();
                foreach ($constraint->getReferencedColumns() as $refColumn) {
                    $fkCols[] = ['ref' => $constraint->getReferencedTableName(), 'column' => $refColumn];
                }
            }
        }
        $this->constraints['pk'] = $pkCols;
        $this->constraints['fkCols'] = $fkCols;
        return $this;
    }

    public function setTablenames($tablenames) {
        foreach ($tablenames as $value) :
            $this->tablenames[$value]= $value;
        endforeach;
        
        return $this;
    }

    public function setProperts() {
        if ($this->columns) {
            foreach ($this->columns as $key => $value) {
                $this->properts[] = "protected $".$key.";";
            }
        }
        return $this;
    }
    public function setColumnsName($columnsName) {
        
        $this->columnsName []=['name'=> $columnsName->getName()];
        return $this;
    }



}
