<?php
namespace Kendo\Definition;
use Kendo\Definition\BaseDefinition;
use Kendo\Definition\OperationDefinition;
use Kendo\Operation\OperationConstantExporter;

class ResourceDefinition extends BaseDefinition
{
    public $operations = array();


    /**
     * @var Kendo\Definition\ResourceDefinition
     */
    public $group;

    public $group_id;


    /**
     * @var Kendo\Definition\ResourceDefinition
     */
    protected $childResources = [];


    public $label;

    public $description;


    public function operation($identifier, $label = null)
    {
        if (isset($this->operations[$identifier])) {
            throw new Exception("Operation $label ($identifier) is already defined.");
        }
        $def = new OperationDefinition($this->policy, $identifier, $label);
        $this->operations[$identifier] = $def;
        return $this;
    }



    private function inheritsOperationOrCreate($identifier, $label = null)
    {
        if ($def = $this->policy->findOperationByIdentifier($identifier)) {
            $this->operations[$identifier] = $def;
        } else {
            $this->operations[$identifier] = new OperationDefinition($this->policy, $identifier, $label);
        }
    }


    private function importOperationsFromMap(array $identifierToLabel)
    {
        foreach ($identifierToLabel as $identifier => $label) {
            $this->inheritsOperationOrCreate($identifier, $label);
        }
    }


    public function useGlobalOperations()
    {
        $this->operations = $this->policy->getOperationDefinitions();
        return $this;
    }

    /**
     * Operations method defines available operations of this resource
     *
     * @param OperationDefinition
     */
    public function operations($opertions)
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                // supports the following formats:
                //
                //     operations([ 'view', 'create' ])
                //
                //     operations([
                //          'view' => 'View',
                //          'create' => 'Create',
                //     ])
                //
                //     operations(new OperationDefinition('foo','Handle Foo'))
                //
                foreach ($arg as $op => $val) {
                    if ($val instanceof OperationDefinition) {
                        $this->operations[$val->identifier] = $val;
                    } else if (is_numeric($op)) {
                        $this->inheritsOperationOrCreate($val, ucfirst($val));
                    } else if ($def = $this->policy->findOperationByIdentifier($op)) {
                        $this->operations[$op] = $def;
                    } else {
                        $this->operations[$op] = new OperationDefinition($this->policy, $op, $val);
                    }
                }
            } else if ($arg instanceof OperationDefinition) {

                $this->operations[$arg->identifier] = $arg;

            } else if (method_exists($arg,'export')) {

                $map = $arg->export();
                $this->importOperationsFromMap($map);

            } else {
                $exporter = new OperationConstantExporter;
                $constants = $exporter->export($arg);
                $this->importOperationsFromMap($constants);
            }
        }
        return $this;
    }

    public function group(ResourceDefinition $group)
    {
        $this->group = $group;
        $group->addChildResource($this);
        return $this;
    }


    public function addChildResource(ResourceDefinition $resource)
    {
        $this->childResources[] = $resource;
    }

    public function getChildResources()
    {
        return $this->childResources;
    }


}




