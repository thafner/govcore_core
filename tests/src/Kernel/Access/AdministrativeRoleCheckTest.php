<?php

namespace Drupal\Tests\govcore_core\Kernel\Access;

use Drupal\Core\Routing\RouteMatch;
use Drupal\KernelTests\KernelTestBase;
use Drupal\govcore_core\Access\AdministrativeRoleCheck;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Symfony\Component\Routing\Route;

/**
 * @coversDefaultClass \Drupal\govcore_core\Access\AdministrativeRoleCheck
 *
 * @group govcore_core
 */
class AdministrativeRoleCheckTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['system', 'user'];

  /**
   * @covers ::access
   */
  public function testAccess() {
    $admin_role = $this->randomMachineName();

    Role::create([
      'id' => $admin_role,
      'label' => $admin_role,
      'is_admin' => TRUE,
    ])->save();

    $route = new Route('/foo');
    $route_match = new RouteMatch('foo', $route);

    $account = User::create();
    $account->addRole($admin_role);

    $access_check = new AdministrativeRoleCheck(
      $this->container->get('entity_type.manager')
    );

    $this->assertTrue($access_check->access($route, $route_match, $account)->isAllowed());

    $account->removeRole($admin_role);
    $this->assertTrue($access_check->access($route, $route_match, $account)->isForbidden());
  }

}
