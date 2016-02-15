<?php

class ControllerExtension extends Extension {
	
	/**
	 * @var string
	 */
	public static $google_analytics_code = null;

	/**
	 * @return string 
	 */
	public function getGoogleAnalyticsCode() {
		return self::$google_analytics_code;
	}
	
	/**
	 * @return boolean
	 */
	public function IsDev() {
		return (Director::isDev());
	}

	/**
	 * Create a URL Segment to use for feedback tool
	 *
	 * @return String
	 */
	public function getURLSegment(){
		if ($this->owner->record){
			return Controller::join_links($this->owner->record->getVersion(),'/',$this->owner->record->getRelativeLink());
		}
		return false;
	}

}