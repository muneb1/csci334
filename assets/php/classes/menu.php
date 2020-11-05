<?php
	//This is a menu item abstract class
	// This is a class without implementing any pattern
	// This is Menu class that store the menus, will use if for user access control
	//This class needed to be amend later
	abstract class Menu_Item{
		protected $menu_label;
		protected $menu_path;
		protected $privacyList;

		public function __construct($label, $path, $pos) {
		    $this->menu_label = $label;
		    $this->menu_path = $path;
		    $this->privacyList = $pos;
	  	}

	  	public function userAuth($pos){
			if(in_array($pos, $this->privacyList)){
				return true;
			}else{
				return false;
			}
		}

	  	abstract public function print();
	}
	
	class Sub_Menu extends Menu_Item{
		public function print(){
			return array(
				"label"=>$this->menu_label,
				"path"=>$this->menu_path
			);
		}
	}

	class Main_Menu extends Menu_Item{
		private $subMenuList;
		public function __construct($label, $path, $pos) {
		    $this->menu_label = $label;
		    $this->menu_path = $path;
		    $this->subMenuList = array();
		    $this->privacyList = $pos;
	  	}

	  	public function addSubMenu($subMenu){
	  		array_push($this->subMenuList, $subMenu);
	  	}

	  	public function getSubMenus(){
	  		return $this->subMenuList;
	  	}

	  	public function print(){
	  		$tempArray = array();
	  		foreach ($this->subMenuList as $subMenu) {
	  			array_push($tempArray, $subMenu->print());
	  		}

			return array(
				"label"=>$this->menu_label,
				"path"=>$this->menu_path,
				"subMenu"=>$tempArray
			);
		}
	}
?>