<?php

namespace ThinkerS;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\command\{Command, CommandSender, ConsoleCommandSender};
use onebone\economyapi\EconomyAPI;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\Enchantment;
class MuaKit extends PluginBase implements Listener{
	
	public $tags = "§f§l[§cMua Kit§f]§r ";
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
		$this->loadConfig();
		$this->saveDefaultConfig();
		$this->point =  $this->getServer()->getPluginManager()->getPlugin("PointAPI");
		$this->eco =  $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
	}
	public function loadConfig(){
		$this->saveResource("settings.yml");
		$this->settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);		
    }
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
		switch($cmd->getName()){
			case "muakit":
			if(!($sender instanceof Player)){
				$sender->sendMessage("§cDùng lệnh này trong game!");
				break;	
			} else {
				if(count($args) === 0){
				$sender->sendMessage($this->settings->get("usage"));
				}else{
			if(count($args) === 1){
			switch($args[0]){
				case "gia":
				$sender->sendMessage($this->settings->get("gia-kit-1"));
				$sender->sendMessage($this->settings->get("gia-kit-2"));
				$sender->sendMessage($this->settings->get("gia-kit-3"));
				$sender->sendMessage($this->settings->get("gia-kit-4"));
				$sender->sendMessage($this->settings->get("gia-kit-5"));
				break;
				case "kit1":
				$tien = $this->point->myMoney($sender);
				$amount = $this->settings->get("kit1-costs");
				$can = $amount - $tien;
				if(!($tien >= $amount)){
					$str = str_replace(["{tongtien}", "{sotiencan}"], [$can, $amount], $this->settings->get("khong-du-tien"));
					$sender->sendMessage($this->tags."".$str);//roi
				}else{
					$sender->sendMessage($this->tags."".$this->settings->get("mua-thanh-cong"));
					$this->point->reduceMoney($sender, $amount);
					$inv = $sender->getInventory();
					$i = Item::get(Item::DIAMOND_HELMET, 0, 1);
					$i2 = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
					$i3 = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
					$i4 = Item::get(Item::DIAMOND_BOOTS, 0, 1);
					$i5 = Item::get(Item::DIAMOND_SWORD, 0, 1);
					$i->setCustomName($this->settings->get("helmet1-name"));
					$i2->setCustomName($this->settings->get("chestplate1-name"));
					$i3->setCustomName($this->settings->get("legging1-name"));
					$i4->setCustomName($this->settings->get("boots1-name"));
					$i5->setCustomName($this->settings->get("sword1-name"));
					$i->setLore(array($this->settings->get("helmet1-lore")));
					$i2->setLore(array($this->settings->get("chestplate1-lore")));
					$i3->setLore(array($this->settings->get("legging1-lore")));
					$i4->setLore(array($this->settings->get("boots1-lore")));
					$i5->setLore(array($this->settings->get("sword1-lore")));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 25));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 25));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 25));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 25));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 25));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 25));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 25));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 25));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 25));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 25));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 25));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 25));
					$i3->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 25));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 25));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 25));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 25));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 25));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 25));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), 10));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 3));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13), 5));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(14), 10));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 25));
					$sender->getInventory()->addItem($i);
					$sender->getInventory()->addItem($i2);
					$sender->getInventory()->addItem($i3);
					$sender->getInventory()->addItem($i4);
					$sender->getInventory()->addItem($i5);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 16 999 10");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 3 999 10");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 1 999 3");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." strength 999 5");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 10 999 5");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." resistance 999 5");
					break;
				}
				case "kit2":
				$tien = $this->point->myMoney($sender);
				$amount = $this->settings->get("kit2-costs");
				$can = $amount - $tien;
				if(!($tien >= $amount)){
					$str = str_replace(["{tongtien}", "{sotiencan}"], [$can, $amount], $this->settings->get("khong-du-tien"));
					$sender->sendMessage($this->tags."".$str);//roi
				}else{
					$sender->sendMessage($this->tags."".$this->settings->get("mua-thanh-cong"));
					$this->point->reduceMoney($sender, $amount);
					$inv = $sender->getInventory();
					$i = Item::get(Item::DIAMOND_HELMET, 0, 1);
					$i2 = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
					$i3 = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
					$i4 = Item::get(Item::DIAMOND_BOOTS, 0, 1);
					$i5 = Item::get(Item::DIAMOND_SWORD, 0, 1);
					$i->setCustomName($this->settings->get("helmet2-name"));
					$i2->setCustomName($this->settings->get("chestplate2-name"));
					$i3->setCustomName($this->settings->get("legging2-name"));
					$i4->setCustomName($this->settings->get("boots2-name"));
					$i5->setCustomName($this->settings->get("sword2-name"));
					$i->setLore(array($this->settings->get("helmet2-lore")));
					$i2->setLore(array($this->settings->get("chestplate2-lore")));
					$i3->setLore(array($this->settings->get("legging2-lore")));
					$i4->setLore(array($this->settings->get("boots2-lore")));
					$i5->setLore(array($this->settings->get("sword2-lore")));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 50));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 50));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 50));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 50));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 50));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 50));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 50));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 50));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 50));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 50));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 50));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 50));
					$i3->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 50));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 50));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), 20));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 6));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13), 10));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(14), 20));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 50));
					$sender->getInventory()->addItem($i);
					$sender->getInventory()->addItem($i2);
					$sender->getInventory()->addItem($i3);
					$sender->getInventory()->addItem($i4);
					$sender->getInventory()->addItem($i5);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 16 999 20");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 3 999 20");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 1 999 6");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." strength 999 10");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 10 999 10");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." resistance 999 10");
					break;
				}
				case "kit3":
				$tien = $this->point->myMoney($sender);
				$amount = $this->settings->get("kit3-costs");
				$can = $amount - $tien;
				if(!($tien >= $amount)){
					$str = str_replace(["{tongtien}", "{sotiencan}"], [$can, $amount], $this->settings->get("khong-du-tien"));
					$sender->sendMessage($this->tags."".$str);//roi
				}else{
					$sender->sendMessage($this->tags."".$this->settings->get("mua-thanh-cong"));
					$this->point->reduceMoney($sender, $amount);
					$inv = $sender->getInventory();
					$i = Item::get(Item::DIAMOND_HELMET, 0, 1);
					$i2 = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
					$i3 = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
					$i4 = Item::get(Item::DIAMOND_BOOTS, 0, 1);
					$i5 = Item::get(Item::DIAMOND_SWORD, 0, 1);
					$i->setCustomName($this->settings->get("helmet3-name"));
					$i2->setCustomName($this->settings->get("chestplate3-name"));
					$i3->setCustomName($this->settings->get("legging3-name"));
					$i4->setCustomName($this->settings->get("boots3-name"));
					$i5->setCustomName($this->settings->get("sword3-name"));
					$i->setLore(array($this->settings->get("helmet3-lore")));
					$i2->setLore(array($this->settings->get("chestplate3-lore")));
					$i3->setLore(array($this->settings->get("legging3-lore")));
					$i4->setLore(array($this->settings->get("boots3-lore")));
					$i5->setLore(array($this->settings->get("sword3-lore")));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 75));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 75));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 75));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 75));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 75));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 75));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 75));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 75));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 75));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 75));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 75));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 75));
					$i3->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 75));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 75));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 75));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 75));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 75));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 75));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 75));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), 35));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 9));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13), 30));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(14), 30));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 75));
					$sender->getInventory()->addItem($i);
					$sender->getInventory()->addItem($i2);
					$sender->getInventory()->addItem($i3);
					$sender->getInventory()->addItem($i4);
					$sender->getInventory()->addItem($i5);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 16 999 30");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 3 999 30");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 1 999 9");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." strength 999 15");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 10 999 15");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." resistance 999 15");
					break;
				}
				case "kit4":
				$tien = $this->point->myMoney($sender);
				$amount = $this->settings->get("kit4-costs");
				$can = $amount - $tien;
				if(!($tien >= $amount)){
					$str = str_replace(["{tongtien}", "{sotiencan}"], [$can, $amount], $this->settings->get("khong-du-tien"));
					$sender->sendMessage($this->tags."".$str);//roi
				}else{
					$sender->sendMessage($this->tags."".$this->settings->get("mua-thanh-cong"));
					$this->point->reduceMoney($sender, $amount);
					$inv = $sender->getInventory();
					$i = Item::get(Item::DIAMOND_HELMET, 0, 1);
					$i2 = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
					$i3 = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
					$i4 = Item::get(Item::DIAMOND_BOOTS, 0, 1);
					$i5 = Item::get(Item::DIAMOND_SWORD, 0, 1);
					$i6 = Item::get(Item::BOW, 0, 1);
					$i->setCustomName($this->settings->get("helmet4-name"));
					$i2->setCustomName($this->settings->get("chestplate4-name"));
					$i3->setCustomName($this->settings->get("legging4-name"));
					$i4->setCustomName($this->settings->get("boots4-name"));
					$i5->setCustomName($this->settings->get("sword4-name"));
					$i6->setCustomName($this->settings->get("sword4-name"));
					$i->setLore(array($this->settings->get("helmet4-lore")));
					$i2->setLore(array($this->settings->get("chestplate4-lore")));
					$i3->setLore(array($this->settings->get("legging4-lore")));
					$i4->setLore(array($this->settings->get("boots4-lore")));
					$i5->setLore(array($this->settings->get("sword4-lore")));
					$i6->setLore(array($this->settings->get("bow4-lore")));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 100));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 100));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 100));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 100));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 100));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 100));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 100));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 100));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 100));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 100));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 100));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 100));
					$i3->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 100));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 100));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 100));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 100));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 100));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 100));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 100));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), 50));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 12));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13), 50));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(14), 50));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 100));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(19), 50));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(20), 12));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(21), 50));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(22), 1));
					$sender->getInventory()->addItem($i);
					$sender->getInventory()->addItem($i2);
					$sender->getInventory()->addItem($i3);
					$sender->getInventory()->addItem($i4);
					$sender->getInventory()->addItem($i5);
					$sender->getInventory()->addItem($i6);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 16 999 40");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 3 999 40");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 1 999 12");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." strength 999 20");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 10 999 20");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." resistance 999 20");
					break;
				}
				case "kit5":
				$tien = $this->point->myMoney($sender);
				$amount = $this->settings->get("kit5-costs");
				$can = $amount - $tien;
				if(!($tien >= $amount)){
					$str = str_replace(["{tongtien}", "{sotiencan}"], [$can, $amount], $this->settings->get("khong-du-tien"));
					$sender->sendMessage($this->tags."".$str);//roi
				}else{
					$sender->sendMessage($this->tags."".$this->settings->get("mua-thanh-cong"));
					$this->point->reduceMoney($sender, $amount);
					$inv = $sender->getInventory();
					$i = Item::get(Item::DIAMOND_HELMET, 0, 1);
					$i2 = Item::get(Item::DIAMOND_CHESTPLATE, 0, 1);
					$i3 = Item::get(Item::DIAMOND_LEGGINGS, 0, 1);
					$i4 = Item::get(Item::DIAMOND_BOOTS, 0, 1);
					$i5 = Item::get(Item::DIAMOND_SWORD, 0, 1);
					$i6 = Item::get(Item::BOW, 0, 1);
					$i->setCustomName($this->settings->get("helmet5-name"));
					$i2->setCustomName($this->settings->get("chestplate5-name"));
					$i3->setCustomName($this->settings->get("legging5-name"));
					$i4->setCustomName($this->settings->get("boots5-name"));
					$i5->setCustomName($this->settings->get("sword5-name"));
					$i6->setCustomName($this->settings->get("sword5-name"));
					$i->setLore(array($this->settings->get("helmet5-lore")));
					$i2->setLore(array($this->settings->get("chestplate5-lore")));
					$i3->setLore(array($this->settings->get("legging5-lore")));
					$i4->setLore(array($this->settings->get("boots5-lore")));
					$i5->setLore(array($this->settings->get("sword5-lore")));
					$i6->setLore(array($this->settings->get("bow5-lore")));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 200));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 200));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 200));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 200));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 200));
					$i->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 200));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 200));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 200));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 200));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 200));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 200));
					$i2->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 200));
					$i3->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 200));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 200));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(1), 200));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(2), 200));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(3), 200));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(4), 200));
					$i4->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 200));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), 100));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), 15));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13), 100));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(14), 100));
					$i5->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 200));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(19), 100));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(20), 15));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(21), 100));
					$i6->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(22), 1));
					$sender->getInventory()->addItem($i);
					$sender->getInventory()->addItem($i2);
					$sender->getInventory()->addItem($i3);
					$sender->getInventory()->addItem($i4);
					$sender->getInventory()->addItem($i5);
					$sender->getInventory()->addItem($i6);
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 16 999 50");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 3 999 50");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 1 999 15");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." strength 999 25");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." 10 9999 25");
					$this->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect ". $sender->getName()." resistance 999 25");
					break;
				}
			}
			}
				}
			}
		}
	return true;
	}
}