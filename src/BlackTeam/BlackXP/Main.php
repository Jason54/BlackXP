<?php

namespace BlackTeam\BlackXP;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents(($this), $this);
		$this->getLogger()->info("Plugin Enabled.");
	}

	public function onBreak(BlockBreakEvent $event) {
		if ($event->isCancelled()) {
			return;
		}
		$event->getPlayer()->addXp($event->getXpDropAmount());
		$event->setXpDropAmount(0);
	}


	public function onPlayerKill(PlayerDeathEvent $event) {
		$player = $event->getPlayer();
		$cause = $player->getLastDamageCause();
		if ($cause instanceof EntityDamageByEntityEvent) {
			$damager = $cause->getDamager();
			if ($damager instanceof Player) {
				$damager->addXp($player->getXpDropAmount());
				$player->setCurrentTotalXp(0);
			}
		}
	}
}