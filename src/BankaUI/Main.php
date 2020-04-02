<?php

namespace BankaUI;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use BankaUI\form\BankaMenu;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\Server;

class Main extends PluginBase implements Listener{

public $cfg;

    private static $ins;
	
	public function onLoad(){
		self::$ins = $this;
	}
	
	public static function getInstance(): Main{
		return self::$ins;
	}

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		@mkdir($this->getDataFolder());
                @mkdir($this->getDataFolder()."Hesaplar/");
	}

	public function giris(PlayerJoinEvent $ev){
		$g = $ev->getPlayer();
		if(!file_exists($this->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml")){
			$this->cfg = new Config($this->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml", Config::YAML);
			$this->cfg->set("Hesap", "yok");
			$this->cfg->save();
		}
                $this->cfg = new Config($this->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml", Config::YAML);
	}

	public function onQuit(PlayerQuitEvent $ev){
		$g = $ev->getPlayer();
		$config = new Config($this->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml", Config::YAML);
		$config->save();
	}

	public function onCommand(CommandSender $g, Command $kmt, string $label, array $args): bool{
		if($kmt->getName() == "hesapolustur"){
			if($this->cfg->get("Hesap") == "yok"){
			$this->cfg->set("Hesap", "var");
			$this->cfg->set("Para", 5000);
			$this->cfg->save();
			$g->sendPopup("§7» §bHesap Başarıyla Oluşturuldu");
			$g->sendMessage("§7» §aBankamıza Hoş Geldiniz. Hoş Geldin Hediyesi Olarak 5000§6TL §aHesabınıza Yatırıldı.");
		}else{
			$g->sendPopup("§7» §cZaten Bir Hesabınız Var");
		}
		}elseif($kmt->getName() == "atm"){
			if($this->cfg->get("Hesap") == "var"){
				$g->sendForm(new BankaMenu($g));
		}else{
				$g->sendPopup("§7» §cHesabınız Bulunmamaktadır.");
		}
		}
		return true;
	}
}