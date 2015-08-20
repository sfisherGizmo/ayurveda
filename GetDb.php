<?php

class GrabDataBase {

	protected $rid;
	protected $sid;
	protected $user;
	protected $md5;
	protected $v;
	protected $sg_url;

	public function __construct( $rid, $sid, $user, $md5, $v, $sg_url ) {
		
		$this->rid = $rid;
		$this->sid = $sid;
		$this->user = $user;
		$this->md5 = $md5;
		$this->v = $v;
		$this->sg_url;
	}

	public function dbVals() {

		$sg_api = new restapi;
		
		$ids = array(
			'survey' => $this->sid,
			'surveyresponse' => $this->rid,
		);

		$sg_api->setup( $this->user, $this->md5, $this->v, $resultsperpage=1 );
		
		$response = $sg_api->get( "surveyresponse", $ids );

		return $response;

	}

}