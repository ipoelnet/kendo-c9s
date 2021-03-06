<?php
use LazyRecord\ConnectionManager;
use LazyRecord\Testing\ModelTestCase;
use Kendo\Testing\DatabaseTestCase;

use SimpleApp\SimpleSecurityPolicy;
use SimpleApp\UserSpecificSecurityPolicy;
use SimpleApp\User\NormalUser;
use SimpleApp\User\AdminUser;

use Kendo\RuleLoader\RuleLoader;
use Kendo\RuleLoader\PDORuleLoader;
use Kendo\RuleLoader\SchemaRuleLoader;
use Kendo\RuleMatcher\AccessRuleMatcher;

use Kendo\Operation\GeneralOperation;
use Kendo\Authorizer\Authorizer;
use Kendo\SecurityPolicy\SecurityPolicyModule;

use Kendo\RuleEditor\ActorRuleEditor;
use Kendo\RuleImporter\DatabaseRuleImporter;

use Kendo\Model\AccessRuleCollection;
use Kendo\Model\ActorCollection;
use Kendo\Model\ResourceCollection;
use Kendo\Model\OperationCollection;
use Kendo\Model\RoleCollection;

use CLIFramework\Debug\ConsoleDebug;

class ActorRuleEditorTest extends DatabaseTestCase
{
    public function getPolicies()
    {
        return [
            new UserSpecificSecurityPolicy,
        ];
    }

    public function testActorRuleEditorWithPDOLoader()
    {
        $loader = new SchemaRuleLoader;
        $loader->load($this->policyModule);

        $exporter = new DatabaseRuleImporter();
        $exporter->import($loader);

        $connectionManager = ConnectionManager::getInstance();
        $conn = $connectionManager->getConnection($this->getDriverType());
        $this->assertNotNull($conn);

        $loader = new PDORuleLoader();
        $loader->load($conn);

        $editor = new ActorRuleEditor(new UserSpecificSecurityPolicy, $loader);
        $editor->loadPermissionSettings('user', 1);

        $settings = $editor->getPermissionSettings();

        $editor->setAllow('books', 'create');
        $editor->setAllow('books', 'update');
        $editor->setAllow('books', 'delete');

        $this->assertTrue( $editor->getPermission('books', 'create'));
        $this->assertTrue( $editor->getPermission('books', 'update'));

        foreach ($editor as $resource => $ops) {
            $this->assertTrue(is_string($resource));
            $this->assertTrue(is_array($ops));
        }
        $editor->savePermissionSettings('user', 1);


        // re-create rule loader object
        $loader = new PDORuleLoader();
        $loader->load($conn);
        $editor2 = new ActorRuleEditor(new UserSpecificSecurityPolicy, $loader);
        $editor2->loadPermissionSettings('user', 1);

        $this->assertTrue( $editor->getPermission('books', 'create'));
        $this->assertTrue( $editor->getPermission('books', 'update'));
        // $editor2->
    }
}

