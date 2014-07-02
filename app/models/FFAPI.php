<?php

class FFAPI {

	public function loadBasicCharacter($name, $server){
		$char = $this->loadPlayerByNameAndServer($name, $server);
		$ret = new BasicPlayer($char);
		return $ret;
	}

	private function loadPlayerByNameAndServer($name, $server){
		$API = new Viion\Lodestone\API;
		$API->searchCharacter($name, $server, true);

		$MyID = $API->Search['results'][0]['id'];
		$API->parseProfile($MyID);
		$API->getCharacterByID($MyID);
		return array_pop($API->Characters);
	}

}

class BasicPlayer {

	private $ID;
	private $Server;
	private $Name;
	private $ItemLevel;
	private $Race;
	private $Media;
	private $Gear;
	private $ActiveClass;
	private $Classes;
	private $FreeCompany;


	public function __construct(Viion\Lodestone\Character $data){
		$this->ID = $data->getID();
		$this->Server = $data->getServer();
		$this->Name = $data->getName();
		$this->ItemLevel = $data->getItemLevelAverage();
		$this->Race = $data->getRace();
		$this->Media = $this->setMedia($data);
		$this->Classes = $this->setClasses($data->getClassJobs());
		$this->Gear = $data->getGear();
		$this->ActiveClass = new PlayerActiveClass($this->Classes($data->getActiveClass()), $data->getActiveJob(), $this->Gear);
		$this->FreeCompany = $this->setFreeCompany($data->getFreeCompany());
		$this->Stats = $data->getStats();
	}

	private function setMedia(Viion\Lodestone\Character $data){
		$sizes = array(50, 64,96);
		$img = new CharacterImage;

		foreach ($sizes as $size){
			$img->setProp($size, $data->getAvatar($size));
		}
		$img->setProp('Portrait', $data->getPortrait());
		return $img;
	}

	private function setClasses($data){
		$ret = array();
		foreach ($data as $key => $class){
			if (is_int($key)){
				$ret[] = new PlayerClass($class);
			}
		}
		return $ret;
	}

	private function setFreeCompany($data){
		$fc = new FreeCompanyBasic($data);
		return $fc;
	}

	public function id(){
		return $this->ID;
	}

	public function Name(){
		return $this->Name;
	}

	public function Media($type){
		$prop = ucwords($type);
		return $this->Media->$prop();
	}

	public function Classes($specific = false){
		if ($specific){
			foreach ($this->Classes as $class){
				if ($class->name() == ucwords($specific)){
					return $class;
				}
			}
			return $this->Classes;
		}
		else {
			return $this->Classes;
		}
	}

	public function FreeCompany(){
		return $this->FreeCompany;
	}

	public function ItemLevel() {
		return $this->ItemLevel;
	}

	public function Race() {
		return $this->Race;
	}

	public function ActiveClass(){
		return $this->ActiveClass;
	}

	public function AltClasses(){
		$ret = array();
		foreach ($this->Classes as $class){
			if ($class->level() > 0){
				$ret[] = $class;
			}
		}
		return $ret;
	}

	public function Stats($type = false){
		if ($type && isset($this->Stats[$type])){
			return $this->Stats[$type];
		}
		return $this->Stats;
	}

}

class PlayerClass {

	private $name;
	private $icon;
	private $level;
	private $currentXp;
	private $toNextLevel;

	public function __construct($data){
		$this->name = $data['class'];
        $this->icon = $data['icon'];
        $this->level = $data['level'];
        $this->currentXp = $data['exp-current'];
		$this->toNextLevel = $data['exp-max'];
	}

	public function name(){
		return ucwords($this->name);
	}

	public function icon(){
		return $this->icon;
	}

	public function level(){
		return $this->level;
	}

	public function currentXp(){
		return $this->currentXp;
	}

	public function toNextLevel(){
		return $this->toNextLevel;
	}

	public function progress(){
		// TODO :: Calculate progress to next level
	}

}

class CharacterImage {

	private $Small;
	private $Medium;
	private $Large;
	private $Portrait;

	public function setProp($prop, $link){
		switch($prop){
			case 50:
				$prop = "Small";
				break;
			case 64:
				$prop = "Medium";
				break;
			case 96:
				$prop = "Large";
				break;
		}
		$prop = ucwords($prop);
		$this->{$prop} = $link;
	}

	public function Small(){
		return $this->Small;
	}

	public function Medium(){
		return $this->Medium;
	}

	public function Large(){
		return $this->Large;
	}

	public function Portrait(){
		return $this->Portrait;
	}
}

class FreeCompanyBasic {

	private $Id;
	private $Name;

	public function __construct($data){
		$this->Id = (isset($data['id'])) ? $data['id'] : false;
		$this->Name = (isset($data['name'])) ? $data['name'] : 'N/A';

	}

	public function Id(){
		return $this->Id;
	}

	public function Name(){
		if ($this->Name)
		return $this->Name;
	}
}

class PlayerActiveClass {

	private $Base;
	private $BaseIcon;
	private $Job;
	private $JobIcon;
	private $Level;
	private $Gear;

	public function __construct(PlayerClass $class, $job = false, $gear){
		$this->Base = $class->name();
		$this->BaseIcon = $class->icon();
		$this->Job = ($job) ? $job['name'] : false;
		$this->JobIcon = ($job) ? $job['icon'] : false;
		$this->Level = $class->level();
		$this->Gear = $gear['equipped']['slots'];
	}

	public function Job()
	{
		if ($this->Job){
			return $this->Job;
		}
		return $this->Base();
	}

	public function JobIcon()
	{
		if ($this->JobIcon){
			return $this->JobIcon;
		}
		return $this->BaseIcon;
	}

	public function Level()
	{
		return $this->Level;
	}

	public function Base(){
		return $this->Base;
	}

	public function BaseIcon() {
		return $this->BaseIcon;
	}

	public function Gear($slot = false){
		if ($slot && isset($this->Gear[$slot])){
			return $this->Gear[$slot];
		}
		return $this->Gear;
	}
}