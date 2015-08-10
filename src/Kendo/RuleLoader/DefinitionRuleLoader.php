<?php
namespace Kendo\RuleLoader;
use Kendo\DefinitionStorage;
use Kendo\RuleLoader\RuleLoader;
use SplObjectStorage;

class DefinitionRuleLoader implements RuleLoader
{
    /**
     * @var array accessControlList[actor][role][resource] = [ CREATE, UPDATE, DELETE ];
     *
     * role == 0   -- without role restriction
     */
    protected $accessControlList = array();


    public function __construct()
    {
    }

    public function getAllAccessControlList()
    {
        return $this->accessControlList;
    }

    public function getAccessControlListByActorIdentifier($actorIdentifier)
    {
        if ($this->accessControlList[ $actorIdentifier ]) {
            return $this->accessControlList[ $actorIdentifier ];
        }
    }

    public function load(DefinitionStorage $storage)
    {
        foreach ($storage as $definition) {
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
        return $this->accessControlList;
    }

}



