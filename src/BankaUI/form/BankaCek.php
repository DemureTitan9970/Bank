<?php

namespace BankaUI\form;

use dktapps\pmforms\{CustomForm, CustomFormResponse};
use dktapps\pmforms\element\{Input, Label};
use onebone\economyapi\EconomyAPI;
use pocketmine\Player;
use BankaUI\Main;
use pocketmine\utils\Config;

class BankaCek extends CustomForm{

	public function __construct(Player $g){
		$this->cfg = new Config(Main::getInstance()->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml", Config::YAML);
		$this->para = EconomyAPI::getInstance();
		parent::__construct(
			"§7» §6PARA ÇEKME",
			[
				new Label("element0", "§7» §bÇekmek İstediğiniz Miktarı Yazınız"),
				new Input("element1", "§7» Buraya Yazınız")
			],
			function(Player $g, CustomFormResponse $response): void{
				$fiyat = $response->getString("element1");
				if($this->cfg->get("Para") >= $fiyat){
					$this->para->addMoney($g, $fiyat);
					$this->cfg->set("Para", $this->cfg->get("Para") - $fiyat);
					$this->cfg->save();
					$g->sendPopup("§7» §bParayı Çektiniz.");
				}else{
					$g->sendPopup("§7» §cBankada Yeterli Miktarda Paranız Yok!");
				}
			}
		);
	}
}