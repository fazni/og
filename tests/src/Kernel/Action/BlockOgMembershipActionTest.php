<?php

namespace Drupal\Tests\og\Kernel\Action;

use Drupal\og\OgMembershipInterface;

/**
 * Tests the BlockOgMembership action plugin.
 *
 * @group og
 * @coversDefaultClass \Drupal\og\Plugin\Action\BlockOgMembership
 */
class BlockOgMembershipActionTest extends ActionTestBase {

  /**
   * {@inheritdoc}
   */
  protected $pluginId = 'og_membership_block_action';

  /**
   * Checks if the action can be performed correctly.
   *
   * @param string $membership
   *   The membership on which to perform the action.
   *
   * @covers ::execute
   * @dataProvider executeProvider
   */
  public function testExecute($membership = NULL) {
    $membership = $this->memberships[$membership];
    /** @var \Drupal\og\Plugin\Action\AddOgMembershipRole $plugin */
    $configuration = !empty($default_role_name) ? ['role_name' => $default_role_name] : [];
    $plugin = $this->getPlugin($configuration);
    $plugin->execute($membership);

    $this->assertEquals(OgMembershipInterface::STATE_BLOCKED, $membership->getState());
  }

  /**
   * {@inheritdoc}
   */
  public function executeProvider() {
    return [
      ['member'],
      ['pending'],
      ['group_administrator'],
      ['group_moderator'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function accessProvider() {
    return [
      // Access should be provided if the membership is not already blocked and
      // the user executing the action is a privileged user.
      ['uid1', 'member'],
      ['uid1', 'pending'],
      ['uid1', 'group_administrator'],
      ['uid1', 'group_moderator'],
      ['administrator', 'member'],
      ['administrator', 'pending'],
      ['administrator', 'group_administrator'],
      ['administrator', 'group_moderator'],
      ['group_administrator', 'member'],
      ['group_administrator', 'pending'],
      ['group_administrator', 'group_administrator'],
      ['group_administrator', 'group_moderator'],
      ['group_moderator', 'member'],
      ['group_moderator', 'pending'],
      ['group_moderator', 'group_administrator'],
      ['group_moderator', 'group_moderator'],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function noAccessProvider() {
    return [
      // Access is denied to users that are not privileged, and if the
      // membership is already blocked.
      ['uid1', 'blocked'],
      ['administrator', 'blocked'],
      ['group_administrator', 'blocked'],
      ['group_moderator', 'blocked'],
      ['anonymous', 'member'],
      ['anonymous', 'pending'],
      ['anonymous', 'blocked'],
      ['anonymous', 'group_administrator'],
      ['anonymous', 'group_moderator'],
      ['authenticated', 'member'],
      ['authenticated', 'pending'],
      ['authenticated', 'blocked'],
      ['authenticated', 'group_administrator'],
      ['authenticated', 'group_moderator'],
      ['member', 'member'],
      ['member', 'pending'],
      ['member', 'blocked'],
      ['member', 'group_administrator'],
      ['member', 'group_moderator'],
      ['pending', 'member'],
      ['pending', 'pending'],
      ['pending', 'blocked'],
      ['pending', 'group_administrator'],
      ['pending', 'group_moderator'],
      ['blocked', 'member'],
      ['blocked', 'pending'],
      ['blocked', 'blocked'],
      ['blocked', 'group_administrator'],
      ['blocked', 'group_moderator'],
    ];
  }

}
