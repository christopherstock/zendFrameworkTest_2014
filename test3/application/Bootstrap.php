<?php

	class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
	{
		protected function _initDoctype()
		{
			//echo "Bootstrap::_initDoctype()<br><br>\n\n";
			
			//pick view object
			$this->bootstrap( 'view' );
			$view = $this->getResource( 'view' );
			
			//set the doctype
			$view->doctype( 'XHTML1_STRICT' );			
		}			
	}

?>
