<?php

namespace MariusB;

use pocketmine\utils\TextFormat as MT;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\event\block\BlockPlaceEvent;

use pocketmine\math\Vector3;
use pocketmine\level\Position;


use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerRespawnEvent;

use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityMoveEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;

class main extends PluginBase implements Listener {
    
        public $worlds = array(); //new
        public $items = array(); //new
        public $config; //new
       
        public function onEnable()
        {
            if (!file_exists($this->getDataFolder()))
            {
                @mkdir($this->getDataFolder(), true);
            }
           
            $this->config = new Config($this->getDataFolder(). "config.yml", Config::YAML, array("worlds" => [], "items" => []));
            $this->getServer()->getPluginManager()->registerEvents($this,$this);$this->getLogger()->info(TextFormat::YELLOW . "Enabling VIPItems");
            $this->worlds = $this->config->get("worlds"); //new
            $this->items = $this->config->get("items"); //new
        }
       
        public function playerSpawn(PlayerRespawnEvent $event)
        {
            $level = $event->getPlayer()->getLevel()->getName(); //new
            if($event->getPlayer()->hasPermission("vipitems") || $event->getPlayer()->hasPermission("vipitems.receive"))
            {
              if(in_array($level, $this->worlds))//new
              {//new
                 foreach($this->item as $setitem)
                 {
                      $i = explode(":", $setitem);
                     $item = new Item($i[0],$i[1],$i[2]);
                     $event->getPlayer()->getInventory()->addItem($item);
                 }
              }//new
            }
        }
    public function onDisable() {
    $this->getLogger()->info(TextFormat::YELLOW . "Disabling VIPItems");
  }
}
