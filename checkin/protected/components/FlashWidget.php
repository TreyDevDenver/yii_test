<?php

/**
 * Reusable component to show flash messages.
 */
class FlashWidget extends CWidget {

	/**
	 * Render the view.
	 */
	public function run() {
    $this->render('flashWidget');
  }
}