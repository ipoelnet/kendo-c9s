<?php
namespace Kendo\RuleLoader;
use Kendo\Definition\Definition;
use SplObjectStorage;

class RuleLoader
{

    /**
     * @var SplObjectStorage
     */
    protected $definitions;

    /**
     * @array accessControlList[actor][role][resource] = [ CREATE, UPDATE, DELETE ];
     *
     * role == 0   -- without role restriction
     */
    protected $accessControlList = array();



    public function __construct()
    {
        $this->definitions = new SplObjectStorage;
    }

    public function load(Definition $definition)
    {
        if ($this->definitions->contains($definition)) {
            return false;
        }
        $this->definitions->attach($definition);

        // Expand access control list
        $rules = $definition->getRules();
        foreach ($rules as $rule) {
            $actor = $rule->getActor();
            $permissions = $rule->getPermissions();

            foreach ($permissions as $resource => $operations)
            {
                if ($roles = $rule->getRoles()) {

                    foreach ($roles as $role) {
                        $this->accessControlList[$actor->getIdentifier()][$role][$resource] = $operations;
                    }

                } else {

                    $this->accessControlList[ $actor->getIdentifier() ][0][$resource] = $operations;

                }
            }


        }
    }
}



