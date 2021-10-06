<?php
declare(strict_types=1);
namespace Vecnavium\StatsX\Provider;

use pocketmine\command\ConsoleSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use Vecnavium\StatsX\Main;
use pocketmine\utils\TextFormat as C;

class UserDataSessionProvider
{
	/** @var Player */
	private $player;
	/** @var Config */
	private $config;
	/** @var int */
	private $currentStreak = 0;

	/**
	 * UserDataSessionProvider constructor.
	 * @param Player $player
	 */
	public function __construct(Player $player)
	{
		$this->player = $player;
		$this->config = new Config(Main::getInstance()->getDataFolder() . "data/{$player->getName()}.json");
	}

	/**
	 * @return int
	 */
	public function getKills(): int
	{
		return (int)$this->config->get('kills', 0);
	}

	public function addKill(): void
	{
		$kills = $this->getKills() + 1;
		$this->config->set('kills', $kills);
		$this->config->save();
		$this->currentStreak++;
		}


	/**
	 * @return int
	 */
	public function getDeaths(): int
	{
		return (int)$this->config->get('deaths', 0);
	}

	/**
	 * @param Player|null $assasin
	 */
	public function addDeath(?Player $assasin = null): void
	{
		$deaths = $this->getDeaths();
		$this->config->set('deaths', $deaths + 1);
		$this->config->save();
	}


	/**
	 * @return Player
	 */
	public function getPlayer(): Player
	{
		return $this->player;
	}


	/**
	 * @return Main
	 */
	public function getPlugin(): Main
	{
		return Main::getInstance();
	}

}
