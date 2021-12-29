<?php

declare(strict_types=1);

namespace MrDinoDuck\NapTheUI;

use AltayForm\
{
	form\CustomForm,
	form\Form,
	form\element\Dropdown,
	form\element\Input,
};
use pocketmine\Player;

class NapTheForm extends CustomForm{

	public function __construct(Main $plugin){
		$this->plugin = $plugin;
		parent::__construct("§l§f•§b NAPTHE§f •", [
		new Dropdown("§r• §e Chọn loại thẻ", ["Viettel", "Mobifone", "Vinaphone"]),
		new Dropdown("§r•§e Chọn giá trị của thẻ", ["10000", "20000", "50000", "100000", "200000", "500000"]),
		new Input("§r•§e Mã pin", ""),
		new Input("§r•§e Mã seri", ""),
		]);
	}
	    
	public function onSubmit(Player $player) : ?Form{
		$ten = $this->getElement(0)->getOptions()[$this->getElement(0)->getValue()];
		$card_value = $this->getElement(1)->getOptions()[$this->getElement(1)->getValue()];
		$pin = (string) $this->getElement(2)->getValue();
		$seri = (string) $this->getElement(3)->getValue();
		if(!is_numeric($pin) || !is_numeric($seri)){
			$player->sendMessage("§r•§6 Số liệu bạn vừa điền không phải là số");
			return null;
		}
		switch($ten){
			case "Viettel":
			$mang = 1;
			$ten = "Viettel";
			$this->plugin->xuLyCard($pin, $seri, $card_value, $mang, $ten, $player);
			break;
			case "Mobifone":
			$mang = 2;
			$ten = "Mobifone";
			$this->plugin->xuLyCard($pin, $seri, $card_value, $mang, $ten, $player);
			break;
			case "Vinaphone":
			$mang = 3;
			$ten = "Vinaphone";
			$this->plugin->xuLyCard($pin, $seri, $card_value, $mang, $ten, $player);
			break;
		}
		return null;
	}
}