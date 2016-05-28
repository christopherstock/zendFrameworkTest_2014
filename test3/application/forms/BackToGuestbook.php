<?php

	class Application_Form_BackToGuestbook extends Zend_Form
	{
	    public function init()
	    {
	    	// Setzt die Methode for das Anzeigen des Formulars mit POST
	    	$this->setMethod('post');

	    	// Den Submit Button hinzufügen
	    	$this->addElement('submit', 'submit', array(
	    			'ignore'   => true,
	    			'label'    => 'Back to Guestbook',
	    	));

	    	// Und letztendlich etwas CSRF Protektion hinzufügen
	    	$this->addElement('hash', 'csrf', array(
	    			'ignore' => true,
	    	));
	    }
	}
?>
