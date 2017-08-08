<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai 
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 * 
 *
 */
	
	class ContentBase
	{
		protected  $title = ''; //page title
		protected $heading = ''; //page heading
		protected $contents = array('main'=>''); //page contents
		protected $css = ''; //page css
		protected $js = ''; //page javascript
		protected $bodyId = 'normal'; //id of body tag
		protected $auth = null; //auth object
		protected $tabs = array(); //available tabs
		protected $menus = array(); //the main menus
		protected $subMenus = array(); //the sub menus
		protected $quickMenus = array(); //quick menus
		protected $tab = ''; //present tab
		protected $module = ''; //presnet module
		protected $action = ''; //present action
		protected $page = '';  //present page
		protected $jsFiles = array();
		protected $cssFiles = array();
		protected $cssPath = '/css/';
		protected $isProductionMode = true;
		
		/**
		 * constructor 
		 *
		 */
		public function __construct()
		{
			$this->setSubMenus();
		}
		/**
		 * set the present module
		 *
		 * @param string $module
		 */
		public function setModule($module)
		{
			$this->module = $module;
		}
		/**
		 * set the present action
		 *
		 * @param string $action
		 */
		public function setAction($action)
		{
			$this->action = $action;
		}
		/**
		 * get present module
		 *
		 * @return string
		 */
		public function getModule()
		{
			return $this->module;
		}
		

		/**
		 * get present action
		 *
		 * @return string
		 */
		public function getAction()
		{
			return $this->action;
		}
		
	
		/**
		 * set present page
		 *
		 * @param string $page
		 */
		public function setPage($page)
		{
			$this->page = $page;
		}		
		/**
		 * get present page
		 *
		 * @return string
		 */
		public function getPage()
		{
			return $this->page;
		}


		/**
		 * set main menu
		 *
		 * @param array $menu
		 */				
		public function setMenus($inputs)
		{
			$this->menus = $inputs;
		}				
		/**
		 * get main menu
		 *
		 * @return array
		 */		
		public function getMenus()
		{
			return $this->menus;
		}		

		
		/**
		 * set present sub menus
		 *
		 * @param array $inputs
		 */
		public function setSubMenus($inputs=array())
		{

			$this->subMenus = $inputs;
		}
		/**
		 * get sub menus
		 *
		 * @return array
		 */
		public function getSubMenus()
		{
			return $this->subMenus;
		}	
				
		/**
		 * set page title
		 *
		 * @param string $value
		 */
		public function setTitle($value)
		{
			$this->title = $value;
		}
		/**
		 * get page title
		 *
		 * @return string
		 */
		public function getTitle()
		{
			return $this->title;
		}		
		/**
		 * set page heading
		 *
		 * @param string $value
		 */
		public function setHeading($value)
		{
			$this->heading = $value;
		}		

		/**
		 * get page heading
		 *
		 * @return string
		 */
		public function getHeading()
		{
			return $this->heading;
		}
		

		

		/**
		 * set present tab
		 *
		 * @param string $value
		 * @return string
		 */
		public function setTab($value)
		{
			return $this->tab = $value;
		}		

		/**
		 * get present tab
		 *
		 * @return string
		 */
		public function getTab()
		{
			return $this->tab;
		}
		

		/**
		 * set page content
		 *
		 * @param string $input page content
		 * @param boolean $isFile the specified page content is a file name if true, or string
		 * @param string $key
		 */
		public function setContent( $input,  $isFile= false, $key = 'main')
		{
			if($isFile)
			{
				@ob_start();
				global $db, $msg, $content, $sql, $auth, $survey;
				include($input);
				$this->contents[$key] = @ob_get_clean();
			}else 
			{
			 	$this->contents[$key] = $input;
			}
		}
		/**
		 * set page content
		 *
		 * @param string $input page content
		 * @param boolean $isFile the specified page content is a file name if true, or string
		 * @param string $key
		 */		
		public function appendContent($input,  $isFile= false, $key = 'main')
		{
			if(!isset($this->contents[$key]))
			{
				$this->contents[$key] = '';
			}
			if($isFile)
			{
				@ob_start();
				global $db, $msg, $content, $sql, $auth, $survey;
				include($input);
				$this->contents[$key] .= @ob_get_clean();
			}else 
			{
			 	$this->contents[$key] .= $input;
			}			
		}		
		/**
		 * get page content
		 *
		 * @param string $key
		 * @return string
		 */
		public function getContent($key='main')
		{

			if(isset($this->contents[$key]))
			{
				return $this->contents[$key];
			}else 
			{
				return '';
			}
		}		
		/**
		 * set id for body tag
		 *
		 * @param string $value
		 */
		public function setBodyId($value)
		{
			$this->bodyId = $value;
		}
		
		/**
		 * get id of body tag
		 *
		 * @return string
		 */		
		public function getBodyId()
		{
			return $this->bodyId;
		}
		

		

		/**
		 * append css
		 *
		 * @param string $value css content, css link if $isFile true
		 * @param booean $isFile 
		 * @param string $mediaType the media type
		 */
		public function appendCss($value,  $isFile = true, $mediaType = "screen", $ieLimit = null)
		{
			if($isFile)
			{
				if(!empty($ieLimit))
				{
					$this->css .= '<!--[' . $ieLimit . ']>';
					$this->css .= sprintf('<link href="%s" rel="stylesheet" type="text/css" media="%s">', $value, $mediaType) . "\n";
					$this->css .= '<![endif]-->';
				}else 
				{
					$this->css .= "\n" . sprintf('<link href="%s" rel="stylesheet" type="text/css" media="%s">', $value, $mediaType). "\n";

					
				}
				
			}else
			{
				if(strpos('<style', trim($value)) === 0)
				{
					$this->css .=  "\n" .    $value . "\n";
				}else 
				{
					$this->css .= '<style type="text/css">';
					$this->css .=  "\n" .    $value . "\n";
					$this->css .= '</style>' . "\n";
				}
				
			}
		}


		/**
		 * get the css
		 *
		 * @return string
		 */
		public function getCss()
		{

			return $this->css;
		}
	
		/**
		 * append js
		 *
		 * @param string $value the javascript, it is javascript file name if $isFile true
		 * @param boolean $isFile
		 */
		public function appendJs($value, $isFile = true)
		{
			if($isFile)
			{
				if(array_search($value, $this->jsFiles) === false)
				{
					$this->js .= "\n" . sprintf('<script type="text/javascript" src="%s">', $value). "</script>\n";		
					$this->jsFiles[] = $value;						
				}


				

			}else
			{
				if(strpos($value, '<script') === false)
				{
					$this->js .= "<script type=\"text/javascript\">\n" . $value . "\n</script>\n";
				}else 
				{
					$this->js .=  "\n" .    $value . "\n";
				}
				
			}
		}


		/**
		 * get the css
		 *
		 * @return string
		 */
		public function getJs()
		{
			return $this->js;
		}
		
		

	}