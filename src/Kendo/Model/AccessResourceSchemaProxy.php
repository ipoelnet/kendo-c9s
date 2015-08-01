<?php
/**
 * THIS FILE IS AUTO-GENERATED BY LAZYRECORD,
 * PLEASE DO NOT MODIFY THIS FILE DIRECTLY.
 * 
 * Last Modified: August 1st at 11:04am
 */
namespace Kendo\Model;


use LazyRecord;
use LazyRecord\Schema\RuntimeSchema;
use LazyRecord\Schema\Relationship;

class AccessResourceSchemaProxy extends RuntimeSchema
{

    public static $column_names = array (
  0 => 'rules_class',
  1 => 'name',
  2 => 'label',
  3 => 'description',
);
    public static $column_hash = array (
  'rules_class' => 1,
  'name' => 1,
  'label' => 1,
  'description' => 1,
);
    public static $mixin_classes = array (
);
    public static $column_names_include_virtual = array (
  0 => 'rules_class',
  1 => 'name',
  2 => 'label',
  3 => 'description',
);

    const schema_class = 'Kendo\\Model\\AccessResourceSchema';
    const collection_class = 'Kendo\\Model\\AccessResourceCollection';
    const model_class = 'Kendo\\Model\\AccessResource';
    const model_name = 'AccessResource';
    const model_namespace = 'Kendo\\Model';
    const primary_key = NULL;
    const table = 'access_resources';
    const label = 'AccessResource';

    public function __construct()
    {
        /** columns might have closure, so it can not be const */
        $this->columnData      = array( 
  'rules_class' => array( 
      'name' => 'rules_class',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'varchar',
          'primary' => NULL,
          'length' => 64,
        ),
    ),
  'name' => array( 
      'name' => 'name',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'varchar',
          'primary' => NULL,
          'length' => 64,
          'unique' => true,
        ),
    ),
  'label' => array( 
      'name' => 'label',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'varchar',
          'primary' => NULL,
          'length' => 128,
        ),
    ),
  'description' => array( 
      'name' => 'description',
      'attributes' => array( 
          'isa' => 'str',
          'type' => 'text',
          'primary' => NULL,
        ),
    ),
);
        $this->columnNames     = array( 
  'rules_class',
  'name',
  'label',
  'description',
);
        $this->primaryKey      = NULL;
        $this->table           = 'access_resources';
        $this->modelClass      = 'Kendo\\Model\\AccessResource';
        $this->collectionClass = 'Kendo\\Model\\AccessResourceCollection';
        $this->label           = 'AccessResource';
        $this->relations       = array( 
  'access_rules' => \LazyRecord\Schema\Relationship::__set_state(array( 
  'data' => array( 
      'type' => 1,
      'self_column' => 'name',
      'self_schema' => 'Kendo\\Model\\AccessResourceSchema',
      'foreign_column' => 'resource',
      'foreign_schema' => 'Kendo\\Model\\AccessRuleSchema',
    ),
  'accessor' => 'access_rules',
  'where' => NULL,
  'orderBy' => array( 
    ),
)),
);
        $this->readSourceId    = 'default';
        $this->writeSourceId    = 'default';
        parent::__construct();
    }


    /**
     * Code block for message id parser.
     */
    private function __() {
        _('AccessResource');
    }

}
