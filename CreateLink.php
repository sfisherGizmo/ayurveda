<?php

require_once "sgapiModel.php";
require_once "GetDb.php";

class CreateLink {

	private $user;
	private $md5;
	private $sid;
	private $v;
	private $sg_obj;
	private $db_obj;

	public function __construct( $sid, $user, $md5, $v, $sg_obj, $db_obj ) {
		
		$this->sid = $sid;
		$this->user = $user;
		$this->md5 = $md5;
		$this->v = $v;
		$this->sg_obj = $sg_obj;
		$this->db_obj = $db_obj;
	}

	public function campaign() {

		$tokens = array(
			'uid'		=> $this->db_obj->{'responseID'},
			'business' 	=> $this->db_obj->{'[question(4)]'},
			'name'		=> $this->db_obj->{'[question(2)]'} . " " . $this->db_obj->{'[question(3)]'}, 
			'email'		=> $this->db_obj->{'[question(11)]'}, 
		);
		$tokens = http_build_query($tokens);
		$params = array(
			'type' 	  			=> 'link',
			'name' 	  			=> $this->db_obj->{'[question(4)]'},
			'status'  			=> 'active',
			'subtype' 			=> 'shortlink',
			'scheduledclose' 	=> date('Y-m-d' , strtotime( '+30 days' ) ),
			'tokenvariables'  	=> $tokens,
		);
		
		$ids = $this->sg_obj;

		$sg_api = new restapi;
		$sg_api->setup( $this->user, $this->md5, $this->v, $resultsperpage=1 );
		$links = $sg_api->put( 'surveycampaign', $params, $ids );

		return $links;
	}

}

$api = new GrabDataBase( $_REQUEST['rid'], '2274448', 'steve@universal-nets.com', 'b1c7e8fcb990fc07c25194f6eacd8903', 'v4', 'https://restapi.surveygizmo.com/v4/survey/' );
$db_res = $api->dbVals();

$sg_obj = array( 
	'survey' => '2248781', 
	'surveycampaign' => '',
);

$sg = new CreateLink( '2274448', 'steve@universal-nets.com', 'b1c7e8fcb990fc07c25194f6eacd8903', 'v4', $sg_obj, $db_res );
$new_link = $sg->campaign();

echo "link=".$new_link->data->uri;
//echo "<pre>" . print_r($new_link, true) . "</pre>";


