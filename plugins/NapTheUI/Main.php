<?php

declare(strict_types=1);

namespace MrDinoDuck\NapTheUI;

use pocketmine\plugin\PluginBase;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class Main extends PluginBase{
	
	/*
	=======================================================================================
	|Cái này t làm giống quý chỉ fix lỗi, add ui với cả sắp xếp lại dòng code nhìn cho đẹp|
	=======================================================================================
	*/

	public function onEnable() : void{
		$this->getLogger()->info("§9>§b NapTheUI by§c MrDinoDuck");
		$trans_id = time();
		$this->coin = $this->getServer()->getPluginManager()->getPlugin("CoinAPI");
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		switch($command->getName()){
			case "napthe":
			if(!$sender instanceof Player){
				$sender->sendMessage("§r§l§b♦§c NapThe §l§b♦ §r§9➤§c Vào máy chủ để dùng!");
				return true;
			}
			$naptheform = new NapTheForm($this);
			$sender->sendForm($naptheform);
			return true;
		default:
			return false;
		}
	}
		
	public function xuLyCard($sopin, $seri, $card_value, $mang, $ten, Player $player){
		$merchant_id = "4002";
		$api_email = "nguyenvanf9@gmail.com";
		$secure_code = "e7e92b3cdb9d1334997922176ab8b085";
		$api_url = "http://api.napthengay.com/v2/";
		$trans_id = time();
		$user = $player->getName();
		$arrayPost = array(
		"merchant_id"=>intval($merchant_id),
		"api_email"=>trim($api_email),
		"trans_id"=>trim((string)$trans_id),
		"card_id"=>trim((string)$mang),
		"card_value"=> intval($card_value),
		"pin_field"=>trim($sopin),
		"seri_field"=>trim($seri),
		"algo_mode"=>"hmac");
		$data_sign = hash_hmac("SHA1", implode("",$arrayPost), $secure_code);
		$arrayPost["data_sign"] = $data_sign;
		$curl = curl_init($api_url);
		curl_setopt_array($curl, array(
		CURLOPT_POST=>true,
		CURLOPT_HEADER=>false,
		CURLINFO_HEADER_OUT=>true,
		CURLOPT_TIMEOUT=>120,
		CURLOPT_RETURNTRANSFER=>true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_POSTFIELDS=>http_build_query($arrayPost)));
		$data = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$result = json_decode($data, true);
		$time = time();
		if($status==200){
			$amount = $result["amount"];
			switch($amount) {
				case 10000: $coin = 40; break;
				case 20000: $coin = 80; break;
				case 50000: $coin = 200; break;
				case 100000: $coin = 400; break;
				case 200000: $coin = 800; break;
				case 500000: $coin = 2000; break;
			}			
			if($result["code"] == 100){
				$file = "carddung.log";
				$fh = fopen($file,"a") or die("cant open file");
				fwrite($fh,"Tai khoan: ".$user.", Loai the: ".$ten.", Menh gia: ".$amount.", Thoi gian: ".$time);
				fwrite($fh,"\r\n");
				fclose($fh);
				$player->sendMessage("§r•§a Đã nạp thành công thẻ§e $amount $ten và nhận được số§e coins là§c $coin");
				$this->getServer()->broadcastMessage("§r•§a Người chơi §c" . $player->getName() . " §ađã nạp thành công thẻ§e $amount $ten và nhận được số§e coins là§c $coin");
				$this->coin->addMoney($player->getName(), $coin);
			}else{
				$player->sendMessage("§cStatus Code: ".$result["code"]." ");  
				$error = $result["msg"];
				$file = "cardsai.log";
				$fh = fopen($file,"a") or die("cant open file");
				fwrite($fh,"Tai khoan: ".$user.", Ma the: ".$sopin.", Seri: ".$seri.", Noi dung loi: ".$error.", Thoi gian: ".$time);
				fwrite($fh,"\r\n");
				fclose($fh);
				$player->sendMessage("§r•§c Đã xảy ra lỗi trong quá trình xử lí!. Lỗi: $error");
			}
		}else{
			$player->sendMessage("§r•§c Đã xảy ra lỗi trong quá trình xử lí!. Lỗi: $error");
		}
	}
}