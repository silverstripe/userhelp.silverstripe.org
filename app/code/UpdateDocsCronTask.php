<?php

class UpdateDocsCronTask implements CronTask {
	/**
	 * 
	 * @return string
	 */
	public function getSchedule() {
		return "05 * * * *";
	}

	/**
	 * 
	 * @return BuildTask
	 */
	public function process() {
		UpdateTask::init();
	}
}