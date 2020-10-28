<?php
	//This is a menu item abstract class
	abstract class Menu_Item{
		protected $menu_label;
		protected $menu_path;

		public function __construct($label, $path) {
		    $this->menu_label = $label;
		    $this->menu_path = $path;
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
		public function __construct($label, $path) {
		    $this->menu_label = $label;
		    $this->menu_path = $path;
		    $this->subMenuList = array();
	  	}

	  	public function addSubMenu($subMenu){
	  		array_push($this->subMenuList, $subMenu);
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