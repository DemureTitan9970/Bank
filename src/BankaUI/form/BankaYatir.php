<?php

namespace BankaUI\form;

use dktapps\pmforms\{CustomForm, CustomFormResponse};
use dktapps\pmforms\element\{Input, Label};
use onebone\economyapi\EconomyAPI;
use pocketmine\Player;
use BankaUI\Main;
use pocketmine\utils\Config;

class BankaYatir extends CustomForm{

	public function __construct(Player $g){
		$this->cfg = new Config(Main::getInstance()->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml", Config::YAML);
		$this->para = EconomyAPI::getInstance();
		parent::__construct(
			"§7» §6PARA YATİRMA",
			[
				new Label("element0", "§7» §bYatırmak İstediğiniz Miktarı Yazınız"),
				new Input("element1", "§7» Buraya Yazınız")
			],
			function(Player $g, CustomFormResponse $response): void{
				$fiyat = $response->getString("element1");
				if($this->para->myMoney($g) >= $fiyat){
					$this->para->reduceMoney($g, $fiyat);
					$this->cfg->set("Para", $this->cfg->get("Para") + $fiyat);
					$this->cfg->save();
					$g->sendPopup("§7» §bParanız Bankaya Yatırıldı.");
				}else{
					$g->sendPopup("§7» §cYeterli Miktarda Paranız Yok!");
				}
			}
		);
	}
}