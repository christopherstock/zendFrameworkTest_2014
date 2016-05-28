<?php

	class GuestbookController extends Zend_Controller_Action
	{
	    public function init()
	    {
			/* Initialize action controller here */
	    }

	    public function indexAction()
	    {
			//fetch all guestbook entries
	        $guestbook = new Application_Model_GuestbookMapper();
	        $this->view->entries = $guestbook->fetchAll();
	    }

	    public function signAction()
	    {
	        // signing action
    		$request = $this->getRequest();

    		$form    = new Application_Form_Guestbook();

    		//handle post data if received
    		if ( $this->getRequest()->isPost() )
    		{
    			if ( $form->isValid( $request->getPost() ) )
    			{
    				$comment = new Application_Model_Guestbook( $form->getValues() );
    				$mapper  = new Application_Model_GuestbookMapper();
    				$mapper->save( $comment );
    				return $this->_helper->redirector( 'index' );
    			}
    		}

    		$this->view->form = $form;
		}

	    public function clearAction()
	    {
	        echo 'perform clear action<br><br>';

	        $mapper  = new Application_Model_GuestbookMapper();
	        $mapper->clearAll();

	        echo 'Create and show the form<br><br>';

	        //show return form
	        $form    = new Application_Form_BackToGuestbook();

	        //redirect to guestbook page if post data was received
	        if ( $this->getRequest()->isPost() )
	        {
        		return $this->_helper->redirector( 'index' );
	        }

	        $this->view->form = $form;
	    }
	}

?>
