<?php

namespace BankaUI\form;

use dktapps\pmforms\{MenuForm, FormIcon, MenuOption};
use pocketmine\Player;
use pocketmine\utils\Config;
use BankaUI\Main;
use BankaUI\form\BankaYatir;
use BankaUI\form\BankaCek;

class BankaMenu extends MenuForm{

	public function __construct(Player $g){
		$this->cfg = new Config(Main::getInstance()->getDataFolder() . "Hesaplar/" . $g->getName() . ".yml", Config::YAML);
		parent::__construct(
			"§7» §bBanka Menüsü",
			"§7» §aYapmak İstediğiniz İşlemi Seçiniz!\n§7» §aBankadaki Paranız: §b".$this->cfg->get("Para")."§6TL",
			[
				new MenuOption("§7» §fPara Yatır", new FormIcon('https://www.freeiconspng.com/uploads/money-icon-15.png', FormIcon::IMAGE_TYPE_URL)),
				new MenuOption("§7» §fPara Çek", new FormIcon('https://cdn.iconscout.com/icon/free/png-512/save-more-taxes-1817355-1538226.png', FormIcon::IMAGE_TYPE_URL))
			],

			function(Player $g, int $sel): void{
				if($sel == 0){
					$g->sendForm(new BankaYatir($g));
				}
				if($sel == 1){
					$g->sendForm(new BankaCek($g));
				}
			}
		);
	}
}