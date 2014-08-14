<?php
/**
 * @author Kariuki
 * Edited by Collins
 */
ob_start();
class sms extends MY_Controller {
	var $test_mode = true;
	function __construct() {
		parent::__construct();
		$this -> load -> helper(array('form', 'url', 'file', 'download'));
		$this -> load -> library(array('hcmp_functions', 'form_validation', 'email', 'mpdf/mpdf'));

	}

	/*
	 |--------------------------------------------------------------------------|
	 | SMS	SECTION																	|
	 |--------------------------------------------------------------------------|
	 */

	//Test for sending emails
	public function send_email_test() {
		$this -> hcmp_functions -> send_email();
	}

	//Checks if there are potential expiries in the system
	public function check_potential_expiries() {
		$year = date("Y");
		$potential_expiries = Facility_stocks::get_potential_expiries_sms();
		$total_potential = count($potential_expiries);

		if ($total_potential > 0) {
			$total_facilitites = count($potential_expiries);

			$total_commodities = "";

			foreach ($potential_expiries as $potential) {
				$facility_code = $potential['facility_code'];
				$data = Users::getUsers($facility_code) -> toArray();
				//Filter the array to remove empty sections of the array
				$data = array_filter($data);
				if (!empty($data)) {
					foreach ($data as $users) {
						$user_type = $users['usertype_id'];

						switch ($user_type) {
							//Facility Admin
							case 2 :
								$message = $potential['total'] . " commodities will expire within 3 months. HCMP";
								break;
							//Sub County Head
							case 3 :
								$message = $total_facilitites . " facilities have commodities that will expire within 3 months. HCMP";
								break;
							//County Head
							case 10 :
								$message = "There are " . $total_potential . " potential expiries in the county. HCMP";
								break;
							//For test purposes only
							case 5 :
								$message = "Test SMS. HCMP";
								break;
						}

						$phone = $this -> get_facility_phone_numbers($facility_code);
						$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);
						$this -> hcmp_functions -> send_sms(substr($phone, 0, -1), $message);
					}
				} else {
					//DO Nothing
					//Array is empty
				}

			}

		} else {
			//No Potential Expiries

		}

	}

	//Stock out SMSes
	//will be called once a week by the system automatically
	public function stock_out_sms() {
		$stock_outs = Facility_stocks::get_stock_outs_sms();
		$total_stock_outs = count($stock_outs);
		if ($total_stock_outs > 0) {
			$total_facilitites = count($stock_outs);
			$total_commodities = "";

			foreach ($stock_outs as $stock_outs_) {
				$facility_code = $stock_outs_['facility_code'];
				$data = Users::getUsers($facility_code) -> toArray();
				//Filter the array to remove empty sections of the array
				$data = array_filter($data);
				if (!empty($data)) {
					$total_subcounties = count($data['']);
					foreach ($data as $users) {
						$user_type = $users['usertype_id'];

						switch ($user_type) {
							//Facility Admin
							case 2 :
								$message = $stock_outs_['total'] . " commodities are out of stock.";
								break;
							//Sub County Head
							case 3 :
								$message = $total_facilitites . " facilities have a total number of " . $total_stock_outs . " stock outs.";
								break;
							//County Head
							case 10 :
								$message = "There are " . $total_stock_outs . " stock outs in the county";
								break;
							//For test purposes only
							case 5 :
								$message = "To Me";
								break;
						}

						$phone = $this -> get_facility_phone_numbers($facility_code);
						$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);
						$this -> hcmp_functions -> send_sms(substr($phone, 0, -1), $message);
					}
				} else {
					//DO Nothing
					//Array is empty
				}

			}

		} else {
			//No Stock Outs

		}
	}

	//For Orders
	//Called when an order is placed by a particular facility
	public function send_order_sms() {
		$facility_code = $this -> session -> userdata('facility_id');
		$facility_name = Facilities::get_facility_name2($facility_code);
		$facility_name = $facility_name['facility_name'];
		$data = Users::getUsers($facility_code) -> toArray();
		foreach ($data as $users) {
			$user_type = $users['usertype_id'];

			switch ($user_type) {
				//Facility Admin
				case 2 :
					$message = "An  order has been placed by " . $facility_name;
					break;
				//Sub County Head
				case 3 :
					$message = $facility_name . " has placed an order";
					break;
				//County Head
				case 10 :
					$message = "An  order has been placed by " . $facility_name;
					break;
				//For test purposes only
				case 5 :
					$message = "Test order sms. Placed by " . $facility_name;
					break;
			}

			$phone = $this -> get_facility_phone_numbers($facility_code);
			$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);
			$this -> hcmp_functions -> send_sms(substr($phone, 0, -1), $message);
		}

	}

	//When stock is updated by a particular facility
	public function send_stock_update_sms() {
		$facility_code = $this -> session -> userdata('facility_id');
		$facility_name = Facilities::get_facility_name2($facility_code);
		$facility_name = $facility_name['facility_name'];
		$data = Users::getUsers($facility_code) -> toArray();

		foreach ($data as $users) {
			$user_type = $users['usertype_id'];

			switch ($user_type) {
				//Facility Admin
				case 2 :
					$message = "Stock has been updated for " . $facility_name;
					break;
				//Sub County Head
				case 3 :
					$message = $facility_name . " has updated its stock";
					break;
				//County Head
				case 10 :
					$message = "Stock has been updated for " . $facility_name;
					break;
				//For test purposes only
				case 5 :
					$message = "Stock has been updated for " . $facility_name;
					break;
			}

			$phone = $this -> get_facility_phone_numbers($facility_code);
			$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);
			$this -> hcmp_functions -> send_sms(substr($phone, 0, -1), $message);
		}

	}

	//Called when an order is rejected or approved bt the DPP
	//Accepts two parameters $facility code and status of the order
	public function send_order_approval_sms($facility_code, $status) {
		//$facility_code = $this -> session -> userdata('facility_id');
		$facility_name = Facilities::get_facility_name2($facility_code);
		$facility_name = $facility_name['facility_name'];
		$data = Users::getUsers($facility_code) -> toArray();

		$message = ($status == 1) ? $facility_name . "'s order has been rejected. HCMP" : $facility_name . "'s order has been approved. HCMP";

		$data = Users::getUsers($facility_code) -> toArray();
		$phone = $this -> get_facility_phone_numbers($facility_code);
		$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);

		$this -> send_sms(substr($phone, 0, -1), $message);

	}

	public function order_update_sms($facility_code, $status) {
		//$facility_code = $this -> session -> userdata('facility_id');
		$facility_name = Facilities::get_facility_name2($facility_code);
		$facility_name = $facility_name['facility_name'];
		$data = Users::getUsers($facility_code) -> toArray();
		$message = $facility_name . " has updated its order";

		$phone = $this -> get_facility_phone_numbers($facility_code);
		$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);
		$this -> hcmp_functions -> send_sms(substr($phone, 0, -1), $message);

	}

	public function send_stock_donate_sms($facility_code, $facility_code2) {
		//Facility code the mfl code for the facility donating drugs
		//Facility code 2 is for the facility recieving the commodities
		$facility_name = Facilities::get_facility_name2($facility_code);
		$facility_name = $facility_name['facility_name'];
		$facility_name2 = Facilities::get_facility_name2($facility_code2);
		$facility_name2 = $facility_name2['facility_name'];
		$data = Users::getUsers($facility_code) -> toArray();
		$data2 = Users::getUsers($facility_code) -> toArray();

		$message = $facility_name . " has donated commodirties to " . $facility_name2;

		$phone = $this -> get_facility_phone_numbers($facility_code);
		$phone .= $this -> get_facility_phone_numbers($facility_code2);
		$phone .= $this -> get_ddp_phone_numbers($data[0]['district']);
		$phone .= $this -> get_ddp_phone_numbers($data2[0]['district']);

		$this -> hcmp_functions -> send_sms(substr($phone, 0, -1), $message);

	}

	/*public function update_stock_out_table()
	 {

	 $in = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("
	 select stock_date,facility_code,
	 kemsa_code from facility_stock
	 where `balance`=0 and `status`=1 and quantity>0
	 group by kemsa_code,facility_code");

	 $jay = count($in);

	 for($i=0;$i<$jay;$i++)
	 {
	 Doctrine_Manager::getInstance()->getCurrentConnection()->execute("
	 insert into facility_stock_out_tracker
	 set facility_id='".$in[$i]['facility_code']."', drug_id='".$in[$i]['kemsa_code']."',
	 `start_date`='".$in[$i]['stock_date']."', status='stocked out' ");

	 }
	 }
	 */

	/*
	 |--------------------------------------------------------------------------|
	 | EMAIL SECTION															|
	 |--------------------------------------------------------------------------|
	 */

	//gets the emails of the respective DPPs in charge
	public function get_ddp_email($district_id) {
		$data = Users::get_dpp_details($district_id);
		$user_email = "";
		foreach ($data as $info) {
			$user_email .= $info -> email . ',';

		}
		return $user_email;
	}

	public function get_county_email($county_id) {
		$data = Users::get_county_emails($county_id);
		$user_email = "";
		foreach ($data as $info) {
			$user_email .= $info -> email . ',';

		}
		return $user_email;
	}

	public function get_bcc_notifications() {
		$bcc_emails = "smutheu@clintonhealthaccess.org,tngugi@clintonhealthaccess.org,bwariari@clintonhealthaccess.org,amwaura@clintonhealthaccess.org,eongute@clintonhealthaccess.org,rkihoto@clintonhealthaccess.org";
		return $bcc_emails;
	}

	//
	//gets the emails of users in the facility
	public function get_facility_email($facility_code) {
		$data = Users::get_user_info($facility_code);
		$user_email = "";
		foreach ($data as $info) {
			$user_email .= $info -> email . ',';

		}
		return $user_email;
	}

	public function send_email($email_address, $message, $subject, $attach_file = NULL, $bcc_email = NULL, $cc_email = NULL) {
		//  return true;
		$mail_list = ($this -> test_mode) ? 'kariukijackson@ymail.com,' : 'kariukijackson@gmail.com,';

		$fromm = 'info-noreply@health-cmp.or.ke';
		$messages = $message;
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://host05.safaricombusiness.co.ke';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user'] = 'info-noreply@health-cmp.or.ke';
		$config['smtp_pass'] = 'hcmp@#2012';
		//healthkenya //hcmpkenya@gmail.com
		$config['charset'] = 'utf-8';
		$config['newline'] = "\r\n";
		$config['mailtype'] = 'html';
		// or html
		$config['validation'] = TRUE;
		// bool whether to validate email or not
		$this -> load -> library('email', $config);
		$mail_header = '<html>
				<style>
#outlook a{padding:0}body{width:100%!important;min-width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}.ExternalClass{width:100%}.ExternalClass,.ExternalClass div,.ExternalClass font,.ExternalClass p,.ExternalClass span,.ExternalClass td{line-height:100%}#backgroundTable{margin:0;padding:0;width:100%!important;line-height:100%!important}img{outline:0;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;float:left;clear:both;display:block}center{width:100%;min-width:580px}a img{border:none}table{border-spacing:0;border-collapse:collapse}td{word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important}table,td,tr{padding:0;vertical-align:top;text-align:left}hr{color:#d9d9d9;background-color:#d9d9d9;height:1px;border:none}table.body{height:100%;width:100%}table.container{width:580px;margin:0 auto;text-align:inherit}table.row{padding:0;width:100%;position:relative}table.container table.row{display:block}td.wrapper{padding:10px 20px 0 0;position:relative}table.column,table.columns{margin:0 auto}table.column td,table.columns td{padding:0 0 10px}table.column td.sub-column,table.column td.sub-columns,table.columns td.sub-column,table.columns td.sub-columns{padding-right:10px}td.sub-column,td.sub-columns{min-width:0}table.container td.last,table.row td.last{padding-right:0}table.one{width:30px}table.two{width:80px}table.three{width:130px}table.four{width:180px}table.five{width:230px}table.six{width:280px}table.seven{width:330px}table.eight{width:380px}table.nine{width:430px}table.ten{width:480px}table.eleven{width:530px}table.twelve{width:580px}table.one center{min-width:30px}table.two center{min-width:80px}table.three center{min-width:130px}table.four center{min-width:180px}table.five center{min-width:230px}table.six center{min-width:280px}table.seven center{min-width:330px}table.eight center{min-width:380px}table.nine center{min-width:430px}table.ten center{min-width:480px}table.eleven center{min-width:530px}table.twelve center{min-width:580px}table.one .panel center{min-width:10px}table.two .panel center{min-width:60px}table.three .panel center{min-width:110px}table.four .panel center{min-width:160px}table.five .panel center{min-width:210px}table.six .panel center{min-width:260px}table.seven .panel center{min-width:310px}table.eight .panel center{min-width:360px}table.nine .panel center{min-width:410px}table.ten .panel center{min-width:460px}table.eleven .panel center{min-width:510px}table.twelve .panel center{min-width:560px}.body .column td.one,.body .columns td.one{width:8.333333%}.body .column td.two,.body .columns td.two{width:16.666666%}.body .column td.three,.body .columns td.three{width:25%}.body .column td.four,.body .columns td.four{width:33.333333%}.body .column td.five,.body .columns td.five{width:41.666666%}.body .column td.six,.body .columns td.six{width:50%}.body .column td.seven,.body .columns td.seven{width:58.333333%}.body .column td.eight,.body .columns td.eight{width:66.666666%}.body .column td.nine,.body .columns td.nine{width:75%}.body .column td.ten,.body .columns td.ten{width:83.333333%}.body .column td.eleven,.body .columns td.eleven{width:91.666666%}.body .column td.twelve,.body .columns td.twelve{width:100%}td.offset-by-one{padding-left:50px}td.offset-by-two{padding-left:100px}td.offset-by-three{padding-left:150px}td.offset-by-four{padding-left:200px}td.offset-by-five{padding-left:250px}td.offset-by-six{padding-left:300px}td.offset-by-seven{padding-left:350px}td.offset-by-eight{padding-left:400px}td.offset-by-nine{padding-left:450px}td.offset-by-ten{padding-left:500px}td.offset-by-eleven{padding-left:550px}td.expander{visibility:hidden;width:0;padding:0!important}table.column .text-pad,table.columns .text-pad{padding-left:10px;padding-right:10px}table.column .left-text-pad,table.column .text-pad-left,table.columns .left-text-pad,table.columns .text-pad-left{padding-left:10px}table.column .right-text-pad,table.column .text-pad-right,table.columns .right-text-pad,table.columns .text-pad-right{padding-right:10px}.block-grid{width:100%;max-width:580px}.block-grid td{display:inline-block;padding:10px}.two-up td{width:270px}.three-up td{width:173px}.four-up td{width:125px}.five-up td{width:96px}.six-up td{width:76px}.seven-up td{width:62px}.eight-up td{width:52px}h1.center,h2.center,h3.center,h4.center,h5.center,h6.center,table.center,td.center{text-align:center}span.center{display:block;width:100%;text-align:center}img.center{margin:0 auto;float:none}.hide-for-desktop,.show-for-small{display:none}body,h1,h2,h3,h4,h5,h6,p,table.body,td{color:#222;font-family:Helvetica,Arial,sans-serif;font-weight:400;padding:0;margin:0;text-align:left;line-height:1.3}h1,h2,h3,h4,h5,h6{word-break:normal}h1{font-size:40px}h2{font-size:36px}h3{font-size:32px}h4{font-size:28px}h5{font-size:24px}h6{font-size:20px}body,p,table.body,td{font-size:14px;line-height:19px}p.lead,p.lede,p.leed{font-size:18px;line-height:21px}p{margin-bottom:10px}small{font-size:10px}a{color:#2ba6cb;text-decoration:none}a:active,a:hover{color:#2795b6!important}a:visited{color:#2ba6cb!important}h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#2ba6cb}h1 a:active,h1 a:visited,h2 a:active,h2 a:visited,h3 a:active,h3 a:visited,h4 a:active,h4 a:visited,h5 a:active,h5 a:visited,h6 a:active,h6 a:visited{color:#2ba6cb!important}.panel{background:#f2f2f2;border:1px solid #d9d9d9;padding:10px!important}.sub-grid table{width:100%}.sub-grid td.sub-columns{padding-bottom:0}table.button,table.large-button,table.medium-button,table.small-button,table.tiny-button{width:100%;overflow:hidden}table.button td,table.large-button td,table.medium-button td,table.small-button td,table.tiny-button td{display:block;width:auto!important;text-align:center;background:#2ba6cb;border:1px solid #2284a1;color:#fff;padding:8px 0}table.tiny-button td{padding:5px 0 4px}table.small-button td{padding:8px 0 7px}table.medium-button td{padding:12px 0 10px}table.large-button td{padding:21px 0 18px}table.button td a,table.large-button td a,table.medium-button td a,table.small-button td a,table.tiny-button td a{font-weight:700;text-decoration:none;font-family:Helvetica,Arial,sans-serif;color:#fff;font-size:16px}table.tiny-button td a{font-size:12px;font-weight:400}table.small-button td a{font-size:16px}table.medium-button td a{font-size:20px}table.large-button td a{font-size:24px}table.button:active td,table.button:hover td,table.button:visited td{background:#2795b6!important}table.button:active td a,table.button:hover td a,table.button:visited td a{color:#fff!important}table.button:hover td,table.large-button:hover td,table.medium-button:hover td,table.small-button:hover td,table.tiny-button:hover td{background:#2795b6!important}table.button td a:visited,table.button:active td a,table.button:hover td a,table.large-button td a:visited,table.large-button:active td a,table.large-button:hover td a,table.medium-button td a:visited,table.medium-button:active td a,table.medium-button:hover td a,table.small-button td a:visited,table.small-button:active td a,table.small-button:hover td a,table.tiny-button td a:visited,table.tiny-button:active td a,table.tiny-button:hover td a{color:#fff!important}table.secondary td{background:#e9e9e9;border-color:#d0d0d0;color:#555}table.secondary td a{color:#555}table.secondary:hover td{background:#d0d0d0!important;color:#555}table.secondary td a:visited,table.secondary:active td a,table.secondary:hover td a{color:#555!important}table.success td{background:#5da423;border-color:#457a1a}table.success:hover td{background:#457a1a!important}table.alert td{background:#c60f13;border-color:#970b0e}table.alert:hover td{background:#970b0e!important}table.radius td{-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}table.round td{-webkit-border-radius:500px;-moz-border-radius:500px;border-radius:500px}body.outlook p{display:inline!important}@media only screen and (max-width:600px){table[class=body] img{width:auto!important;height:auto!important}table[class=body] center{min-width:0!important}table[class=body] .container{width:95%!important}table[class=body] .row{width:100%!important;display:block!important}table[class=body] .wrapper{display:block!important;padding-right:0!important}table[class=body] .column,table[class=body] .columns{table-layout:fixed!important;float:none!important;width:100%!important;padding-right:0!important;padding-left:0!important;display:block!important}table[class=body] .wrapper.first .column,table[class=body] .wrapper.first .columns{display:table!important}table[class=body] table.column td,table[class=body] table.columns td{width:100%!important}table[class=body] .column td.one,table[class=body] .columns td.one{width:8.333333%!important}table[class=body] .column td.two,table[class=body] .columns td.two{width:16.666666%!important}table[class=body] .column td.three,table[class=body] .columns td.three{width:25%!important}table[class=body] .column td.four,table[class=body] .columns td.four{width:33.333333%!important}table[class=body] .column td.five,table[class=body] .columns td.five{width:41.666666%!important}table[class=body] .column td.six,table[class=body] .columns td.six{width:50%!important}table[class=body] .column td.seven,table[class=body] .columns td.seven{width:58.333333%!important}table[class=body] .column td.eight,table[class=body] .columns td.eight{width:66.666666%!important}table[class=body] .column td.nine,table[class=body] .columns td.nine{width:75%!important}table[class=body] .column td.ten,table[class=body] .columns td.ten{width:83.333333%!important}table[class=body] .column td.eleven,table[class=body] .columns td.eleven{width:91.666666%!important}table[class=body] .column td.twelve,table[class=body] .columns td.twelve{width:100%!important}table[class=body] td.offset-by-eight,table[class=body] td.offset-by-eleven,table[class=body] td.offset-by-five,table[class=body] td.offset-by-four,table[class=body] td.offset-by-nine,table[class=body] td.offset-by-one,table[class=body] td.offset-by-seven,table[class=body] td.offset-by-six,table[class=body] td.offset-by-ten,table[class=body] td.offset-by-three,table[class=body] td.offset-by-two{padding-left:0!important}table[class=body] table.columns td.expander{width:1px!important}table[class=body] .right-text-pad,table[class=body] .text-pad-right{padding-left:10px!important}table[class=body] .left-text-pad,table[class=body] .text-pad-left{padding-right:10px!important}table[class=body] .hide-for-small,table[class=body] .show-for-desktop{display:none!important}table[class=body] .hide-for-desktop,table[class=body] .show-for-small{display:inherit!important}}table.facebook td{background:#3b5998;border-color:#2d4473}table.facebook:hover td{background:#2d4473!important}table.twitter td{background:#00acee;border-color:#0087bb}table.twitter:hover td{background:#0087bb!important}table.google-plus td{background-color:#DB4A39;border-color:#C00}table.google-plus:hover td{background:#C00!important}.template-label{color:#000;font-weight:700;font-size:11px}.callout .wrapper{padding-bottom:20px}.callout .panel{background:#ECF8FF;border-color:#b9e5ff}.header{background:#F0F2F3}.footer .wrapper{background:#ebebeb}.footer h5{padding-bottom:10px}table.columns .text-pad{padding-left:10px;padding-right:10px}table.columns .left-text-pad{padding-left:10px}table.columns .right-text-pad{padding-right:10px}@media only screen and (max-width:600px){table[class=body] .right-text-pad{padding-left:10px!important}table[class=body] .left-text-pad{padding-right:10px!important}}

  </style><body>';
		$mail_tail = '<table class="row footer">
                  <tr>
                    <td class="wrapper">
                    </td>
                    <td class="wrapper last">
                      <table class="six columns">
                        <tr>
                          <td class="last right-text-pad">
                            <h5>Contact Info:</h5>
                            <p>Phone: </p>
                            <p>Email: <a href="mailto:hcmpkenya@gmail.com">hcmpkenya@gmail.com</a></p>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
               <table class="row">
                  <tr>
                    <td class="wrapper last">
                      <table class="twelve columns">
                        <tr>
                          <td align="center">
                            <center>
                              <p style="text-align:center;"><a href="#">Terms</a> | <a href="#">Privacy</a> | <a href="#">Unsubscribe</a></p>
                            </center>
                          </td>
                          <td class="expander"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              <!-- container end below -->
              </td>
            </tr>
          </table>
        </center>
			</td>
		</tr>
	</table>
		</body></html>';
		$this -> email -> initialize($config);

		$this -> email -> set_newline("\r\n");
		$this -> email -> from($fromm, 'Health Commodities Management Platform');
		// change it to yours
		$this -> email -> to($email_address);
		// change it to yours

		isset($cc_email) ? $this -> email -> cc($cc_email) : //

		(isset($bcc_email)) ? $this -> email -> bcc($mail_list . $bcc_email) : $this -> email -> bcc(substr($mail_list, 0, -1));

		if (isset($attach_file)) :
			$files = explode("(more)", $attach_file . '(more)');
			$items = count($files) - 1;
			foreach ($files as $key => $files) {
				if ($key != $items) {
					$this -> email -> attach($files);
				}
			}

		endif;

		$this -> email -> subject($subject);
		$this -> email -> message($mail_header . $message . $mail_tail);

		if ($this -> email -> send()) {
			return TRUE;
			ob_end_flush();
			unlink($files);
		} else {
			echo $this -> email -> print_debugger();
			exit ;

		}

	}

	public function send_stock_decommission_email($message, $subject, $attach_file) {
		$facility_code = $this -> session -> userdata('facility_id');
		$data = Users::getUsers($facility_code) -> toArray();
		$email_address = $this -> get_facility_email($facility_code);
		$email_address .= $this -> get_ddp_email($data[0]['district']);

		$this -> send_email(substr($email_address, 0, -1), $message, $subject, $attach_file);

	}

	public function potential_expiries_report() {
		//Set the current year
		$year = date("Y");
		$picurl = base_url() . 'assets/img/coat_of_arms-resized1.png';
		//Get all the district id that are using hcmp
		$districts = Facilities::get_all_using_HCMP();
		$html_potential = "";
		$html_attachment = "";
		for ($i = 0; $i < count($districts); $i++) {

			$district_id = $districts[$i]['district'];
			$district_name = $districts[$i]['name'];

			///$this->get_ddp_email($district_id);

			$facilities = Facilities::getFacilities_for_email($district_id);

			//Potential Expiries
			$html_potential .= "
   	 	<style>
   	 	table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
		table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
		table.data-table td, table th {padding: 4px;}
		table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
		</style>
   	 		<div align=center><img src=" . $picurl . " height='70' width='70'style='vertical-align: top;'> </img></div>
   	 		<div align=center>
			<h5 style='font-family: arial,helvetica,clean,sans-serif;text-align: centre;'>Summary of Potential Expiries in " . $district_name . " SubCounty for the week ending " . date('Y-M-D') . "</h5></div>
			<table class='data-table' align='center'>
				  <thead>
				  <tr>
				    <th>District Name</th>
				    <th>MFL Code</th>
				    <th>Facility Name</th>
				    <th>Total Cost</th>
				  </tr>
				  </thead>
   	 		<tbody>";
			$html_attachment .= "<style>
   	 	table.data-table 
		{
			table-layout: fixed;
			width: 700px;
			border-collapse:collapse;
			border:1px solid black;
			text-align:center;
			font-family: arial,helvetica,clean,sans-serif;
		}
		table.data-table td, th 
		{
			width: 100px;
			border: 1px solid black;
		}
		.leftie{
			text-align: left !important;
		}
		.right{
			text-align: right !important;
		}
		.center{
			text-align: center !important;
		}

   	 	</style>
			<h4 style='font-family: arial,helvetica,clean,sans-serif;text-align: center;'>Potential Expiries for " . $district_name . " SubCounty for the week ending " . date('Y-M') . "</h4>
			<table class='data-table'>
				  <thead>
				  <tr>
				  	<th>MFL Code</th>
				  	<th>Facility Name</th>
				    <th>Commodity Description</th>
				    <th>Manufacturer</th>
				    <th>Expiry Date</th>
				    <th># Days to Expiry</th>
				    <th>Unit size</th>
				    <th>Stock Expired (Packs)</th>
				    <th>Unit Cost (KSH)</th>
				    <th>Total Cost(KSH)</th>
				  </tr>
				  </thead>
   	 		<tbody>";
			/*echo "<pre>";
			 print_r($facilities);
			 echo "<pre>";
			 exit;*/
			foreach ($facilities as $facilities_) :
				$facility_code = $facilities_ -> facility_code;

				//First get the potential expiries in the facility
				$potential_expiries = Facility_stocks::get_potential_expiry_summary(null, 3, $district_id, $facility_code);
				$potential_exp = Facility_stocks::potential_expiries_email($district_id, $facility_code);

				if (!empty($potential_expiries)) {
					for ($j = 0; $j < count($potential_expiries); $j++) {
						$Name = $potential_expiries[$j]['district'];
						$MFL = $potential_expiries[$j]['facility_code'];
						$facility_name_potential = $potential_expiries[$j]['facility_name'];
						$potential_total = $potential_expiries[$j]['total'];

						$html_potential .= " <tr>
	                	        <td> " . $Name . "</td>
	              				<td>" . $MFL . ".</td>
				              <td>" . $facility_name_potential . "</td>
				              <td>" . $potential_total . " </td>
				              
				            </tr>";

					}
				}
				if (!empty($potential_exp)) {
					for ($k = 0; $k < count($potential_exp); $k++) {
						//$unitS=$stock_commodity->unit_size;
						$unitC = $potential_exp[$i]['unit_cost'];
						$total_units = $potential_exp[$k]['units'];
						$total_packs = $potential_exp[$k]['packs'];
						$calculated = $potential_exp[$k]['unit_cost'];
						$total_cost = $potential_exp[$k]['total_ksh'];
						$expired_packs = round($calculated / $total_units, 1);
						$total_exp_cost = $expired_packs * $unitC;
						$formatdate = new DateTime($potential_exp[$i]['expiry_date']);
						$formated_date = $formatdate -> format('d M Y');
						$ts1 = strtotime(date('d M Y'));
						$ts2 = strtotime(date($potential_exp[$k]['expiry_date']));
						$seconds_diff = $ts2 - $ts1;
						//$total=$total+ $total_exp_cost;
						$html_attachment .= "        
				            <tr>
				           	  <td>" . $potential_exp[$k]['facility_code'] . " </td>
				           	  <td>" . $potential_exp[$k]['facility_name'] . " </td>
				              <td>" . $potential_exp[$k]['commodity_name'] . " </td>
				              <td>" . $potential_exp[$k]['manufacture'] . "</td>
				              <td>" . $formated_date . "</td>
				              <td>" . floor($seconds_diff / 3600 / 24) . "</td>
				              <td>" . $potential_exp[$k]['unit_size'] . "</td>
				              <td>" . $total_packs . "</td>
				              <td>" . $calculated . "</td>
				              <td>" . number_format($total_cost, 2, '.', ',') . "</td>
				            </tr>";
					}
				}

				//end foreach for facilities
			endforeach;
			$html_attachment .= "</tbody></table>";
			$html_potential .= "</tbody></table>";
			$html_potential .= "<p align=center>Find attached a PDF file with the detailed report</p>";

			$pdf_data = $html_attachment;
			$this -> create_pdf($pdf_data, $district_id, $html_potential);

		}

	}

	public function weekly_potential_expiries_report() {
		//Set the current year
		$year = date("Y");
		$picurl = base_url() . 'assets/img/coat_of_arms-resized1.png';
		//get the facilities in the district
		$counties = Facilities::get_counties_all_using_HCMP();

		foreach ($counties as $counties) {
			//holds the dat for the entire county
			//once it is done executing for one county it is reset to zero
			$county_total = array();
			//pick the county nae and county ID accordingly
			$county_id = $counties['county'];
			$county_name = $counties['county_name'];

			//Get all the ddistricts in that  particular county
			$districts = Facilities::get_all_using_HCMP($county_id);
			//holds the data for all the districts in a particular county
			$district_total = array();

			foreach ($districts as $districts) {

				$district_id = $districts['district'];
				$district_name = $districts['name'];
				//get all facilities in that district
				$facilities = Facilities::getFacilities_for_email($district_id);
				//holds all the data for all facilities in a particular district
				$facility_total = array();

				foreach ($facilities as $facilities_) :
					//holds the total value of expiries for that particular facility in that district
					$facility_potential_expiries_total = 0;
					//$facility_potential_expiries = array();
					$facility_code = $facilities_ -> facility_code;
					$facility_name = Facilities::get_facility_name2($facility_code);
					$facility_name = $facility_name['facility_name'];

					//get potential expiries in that particular facility
					$facility_potential_expiries = Facility_stocks::potential_expiries_email($district_id, $facility_code);

					//push the result into another array that will be used by the distrct
					(array_key_exists($facility_name, $facility_total)) ? $facility_total[$facility_name] = array_merge($facility_total[$facility_name], array($facility_potential_expiries)) : $facility_total = array_merge($facility_total, array($facility_name => array($facility_potential_expiries)));
					//Start buliding the excel file
					$excel_data = array();
					$excel_data = array('doc_creator' => $facility_name, 'doc_title' => 'facility potential expiries weekly report ', 'file_name' => 'facility weekly report');
					$row_data = array();
					$column_data = array("County", "Subcounty", "Facility Code", "Facility Name", "Commodity Name", "Manufacturer", "Expiry Date", "Unit Cost", "Unit Size", "Units", "Packs", "Total KSH");
					$excel_data['column_data'] = $column_data;

					foreach ($facility_potential_expiries as $facility_potential_expiries) :
						array_push($row_data, array($facility_potential_expiries["county"], $facility_potential_expiries["subcounty"], $facility_potential_expiries["facility_code"], $facility_potential_expiries["facility_name"], $facility_potential_expiries["commodity_name"], $facility_potential_expiries["manufacture"], $facility_potential_expiries["expiry_date"], $facility_potential_expiries["unit_cost"], $facility_potential_expiries["unit_size"], $facility_potential_expiries["units"], $facility_potential_expiries["packs"], $facility_potential_expiries["total_ksh"]));
						$facility_potential_expiries_total += $facility_potential_expiries["total_ksh"];
					endforeach;

					$excel_data['row_data'] = $row_data;
					$excel_data['report_type'] = "download_file";
					$excel_data['file_name'] = $facility_name . "_Potential_Expiries_Report";
					$message = $facility_name . " has a total of " . $facility_potential_expiries_total . " KSH worth of potential expiries.";
					$message .= "Find attached an excel sheet with the breakdown for the Potential Expiries in the facility";
					$this -> hcmp_functions -> create_excel($excel_data);
					$handler = "./print_docs/excel/excel_files/" . $excel_data['file_name'] . ".xls";
					$subject = $facility_name . " Weekly Report";
					$email_address = "collinsojenge2014@gmail.com";
					// $email_address = $this->get_facility_email($facility_code);

					$this -> hcmp_functions -> send_email($email_address, $message, $subject, $handler);

					//End foreach for facility
				endforeach;

				(array_key_exists($district_name, $district_total)) ? $district_total[$district_name] = array_merge($district_total[$district_name], array($facility_total)) : $district_total = array_merge($district_total, array($district_name => array($facility_total)));
				//Building the excel sheet to be sent to the district admin
				$excel_data = array();
				$excel_data = array('doc_creator' => $district_name, 'doc_title' => 'district potential expiries weekly report ', 'file_name' => 'district weekly report');
				$row_data = array();
				$column_data = array("County", "Subcounty", "Facility Code", "Facility Name", "Commodity Name", "Manufacturer", "Expiry Date", "Unit Cost", "Unit Size", "Units", "Packs", "Total KSH");
				$excel_data['column_data'] = $column_data;

				foreach ($facility_total as $facility_total_1) :
					foreach ($facility_total_1 as $facility_total_2) :
						foreach ($facility_total_2 as $facility_total1) :
							array_push($row_data, array($facility_total1["county"], $facility_total1["subcounty"], $facility_total1["facility_code"], $facility_total1["facility_name"], $facility_total1["commodity_name"], $facility_total1["manufacture"], $facility_total1["expiry_date"], $facility_total1["unit_cost"], $facility_total1["unit_size"], $facility_total1["units"], $facility_total1["packs"], $facility_total1["total_ksh"]));
							//$facility_potential_expiries_total += $facility_potential_expiries["total_ksh"];
						endforeach;
					endforeach;
				endforeach;
				$excel_data['row_data'] = $row_data;
				$excel_data['report_type'] = "download_file";
				$excel_data['file_name'] = $district_name . "_Weekly_District_Potential_Expiries_Report";
				$this -> hcmp_functions -> create_excel($excel_data);
				$handler = "./print_docs/excel/excel_files/" . $excel_data['file_name'] . ".xls";
				$subject = $district_name . " Weekly Report";
				$message = $district_name . "'s Weekly Potential Expiries Report";
				$message .= "Find attached an excel sheet with the breakdown for the Potential Expiries for the district";
				$email_address = "collinsojenge2014@gmail.com";
				//$email_address = $this->get_ddp_email($district_id);

				$this -> hcmp_functions -> send_email($email_address, $message, $subject, $handler);

			}

			//Building the excel sheet to be sent to the district admin
			$excel_data = array();
			$excel_data = array('doc_creator' => $district_name, 'doc_title' => 'district potential expiries weekly report ', 'file_name' => 'district weekly report');
			$row_data = array();
			$column_data = array("County", "Subcounty", "Facility Code", "Facility Name", "Commodity Name", "Manufacturer", "Expiry Date", "Unit Cost", "Unit Size", "Units", "Packs", "Total KSH");
			$excel_data['column_data'] = $column_data;

			foreach ($district_total as $facility_total_1) :
				foreach ($facility_total_1 as $facility_total_2) :
					foreach ($facility_total_2 as $facility_total_3) :
						foreach ($facility_total_3 as $facility_total_4) :
							foreach ($facility_total_4 as $facility_total1) :
								array_push($row_data, array($facility_total1["county"], $facility_total1["subcounty"], $facility_total1["facility_code"], $facility_total1["facility_name"], $facility_total1["commodity_name"], $facility_total1["manufacture"], $facility_total1["expiry_date"], $facility_total1["unit_cost"], $facility_total1["unit_size"], $facility_total1["units"], $facility_total1["packs"], $facility_total1["total_ksh"]));

							endforeach;
						endforeach;
					endforeach;
				endforeach;
			endforeach;

			$excel_data['row_data'] = $row_data;
			$excel_data['report_type'] = "download_file";
			$excel_data['file_name'] = $county_name . "_Weekly_County_Potential_Expiries_Report";
			$this -> hcmp_functions -> create_excel($excel_data);
			$handler = "./print_docs/excel/excel_files/" . $excel_data['file_name'] . ".xls";
			$subject = $county_name . "'s Weekly Report";
			$message = $county_name . "'s Weekly Potential Expiries Report";
			$message .= "Find attached an excel sheet with the breakdown for the Potential Expiries for the county";
			$email_address = "collinsojenge@gmail.com,smutheu@clintonhealthaccess.org,kelvinmwas@gmail.com";
			//$email_address = $this->get_county_email($county_id);
			//$bcc = $this->get_bcc_notifications();
			// $cc_email = "";

			$this -> hcmp_functions -> send_email($email_address, $message, $subject, $handler, $bcc, $cc_email);

		}

	}

	public function stockouts_report() {
		//Set the current year
		$year = date("Y");
		//Get all the district id that are using hcmp
		$districts = Facilities::get_all_using_HCMP();

		$html_stock_outs = "";
		foreach ($districts as $districts_) {
			$district_id = $districts_['district'];
			$district_name = $districts_['name'];
			$facilities = Facilities::getFacilities($district_id);

			//For stockouts
			$html_stock_outs = "
		<style>
   	 	table.data-table 
		{
			table-layout: fixed;
			width: 700px;
			border-collapse:collapse;
			border:1px solid black;
			text-align:center;
			font-family: arial,helvetica,clean,sans-serif;
		}
		table.data-table td, th 
		{
			width: 100px;
			border: 1px solid black;
		}
		.leftie{
			text-align: left !important;
		}
		.right{
			text-align: right !important;
		}
		.center{
			text-align: center !important;
		}

   	 	</style>
			<h4 style='font-family: arial,helvetica,clean,sans-serif;text-align: center;'>Stock Outs for " . $district_name . " SubCounty for the week ending " . date('Y') . "</h3>
			<table class='data-table'>
				  <thead style='background-color: white;'>
				  <tr>
				    <th>District</th>
				    <th>MFL Code</th>
				    <th>Facility Name</th>
				    <th>Commodity Code</th>
				    <th>Commodity Name</th>
				    <th>Last Day</th>
				    <th>Current Balance</th>
				  </tr>
				  </thead>
   	 		<tbody>";

			//loop through all the district picking their respective stock outs, expiries and potential expiries and orders
			//Get facilities in that particular district
			$facilities = Facilities::get_Facilities_using_HCMP(null, $district_id, null);

			foreach ($facilities as $facilities_) :
				$facility_code = $facilities_ -> facility_code;
				$stock_outs = Facility_stocks::get_items_that_have_stock_out_in_facility($facility_code, $district_id, null);
				if (!empty($stock_outs)) {
					foreach ($stock_outs as $stock_outs_) {
						$stock_district = $stock_outs_['district'];
						$stock_mfl = $stock_outs_['facility_code'];
						$stock_facility_name = $stock_outs_['facility_name'];
						$stock_commodity_code = $stock_outs_['commodity_code'];
						$stock_commodity_name = $stock_outs_['commodity_name'];
						$stock_last_day = $stock_outs_['last_day'];
						$stock_current_balance = $stock_outs_['current_balance'];

						$html_stock_outs .= "<tr>
                	        <td> " . $stock_district . "</td>
              				<td>" . $stock_mfl . ".</td>
              				<td>" . $stock_facility_name . "</td>
              				<td>" . $stock_commodity_code . "</td>
              				<td>" . $stock_commodity_name . "</td>
              				<td>" . $stock_last_day . "</td>
              				<td>" . $stock_current_balance . "</td>
              				</tr>";
					}
				}
				//end foreach for facilities
			endforeach;

			$html_stock_outs .= "</tbody></table>";
			$pdf_data = $html_stock_outs;

			$this -> create_pdf($pdf_data);

		}

	}

	public function expiries_report() {
		//Set the current year
		$year = date("Y");
		$picurl = base_url() . 'assets/img/coat_of_arms-resized1.png';
		//Get all the district id that are using hcmp
		$districts = Facilities::get_all_using_HCMP();
		$html_potential = "";
		$html_attachment = "";
		for ($i = 0; $i < count($districts); $i++) {
			$district_id = $districts[$i]['district'];
			//$district_id = 88;
			$district_name = $districts[$i]['name'];
			//$district_name = "Lari";
			//$facilities = Facilities::getFacilities($districts[$i]);
			$facilities = Facilities::getFacilities_for_email($district_id);
			//For the expired commodities
			$html_body .= "
			<style>
   	 	table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
		table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
		table.data-table td, table th {padding: 4px;}
		table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
		</style>
   	 		<div align=center><img src=" . $picurl . " height='70' width='70'style='vertical-align: top;'> </img></div>
   	 		<div align=center>
			<h5 style='font-family: arial,helvetica,clean,sans-serif;text-align: centre;'>Summary of Expiries in " . $district_name . " SubCounty for the week ending " . date('Y-M-D') . "</h5></div>
			<table class='data-table' align='center'>
				  <thead>
				  <tr>
				    <th>District Name</th>
				    <th>MFL Code</th>
				    <th>Facility Name</th>
				    <th>Total Cost</th>
				  </tr>
				  </thead>
   	 		<tbody>";
			//For the pdf that will be attched to the email
			$html_attachment .= "
		<style>
   	 	table.data-table {table-layout: fixed;width: 700px;border-collapse:collapse;border:1px solid black;text-align:center;font-family: arial,helvetica,clean,sans-serif;}
		table.data-table td, th {width: 100px;border: 1px solid black;}
		.leftie{text-align: left !important;}.right{text-align: right !important;}.center{text-align: center !important;}
   	 	</style>
		<h4 style='font-family: arial,helvetica,clean,sans-serif;text-align: center;'>Expiries for " . $district_name . " SubCounty for the week ending " . date('Y') . "</h4>
			<table class='data-table'>
				  <thead>
					 <tr>
					    <th>MFL Code</th>
					    <th>Facility Name</th>
					    <th>Commodity Name</th>
					    <th>Commodity Code</th>
					    <th>Batch Number</th>
					    <th>Expiry Date</th>
					    <th>Current Balance</th>
					 </tr>
				  </thead>
   	 		<tbody>";
			$facilities = Facilities::get_Facilities_using_HCMP(null, $district_id, null);
			foreach ($facilities as $facilities_) :
				$facility_code = $facilities_ -> facility_code;
				$expiries = Facility_stocks::get_county_expiries(null, $year, $district_id, $facility_code);

				$attachment_expiries = Facility_stocks::All_expiries_email($facility_code, 'all');

				if (!empty($expiries)) {
					foreach ($expiries as $expiries_) {
						$Expiries_Name = $expiries_['district'];
						$expiries_MFL = $expiries_['facility_code'];
						$expiries_facility_name = $expiries_['facility_name'];
						$expiries_total = $expiries_['total'];
						//Checks if it is a null then makes it a zero
						$expiries_total = ($expiries_total == NULL) ? 0 : $expiries_total;

						$html_body .= " <tr>
	                	        <td> " . $Expiries_Name . "</td>
	              				<td>" . $expiries_MFL . ".</td>
				              	<td>" . $expiries_facility_name . "</td>
				              	<td>" . $expiries_total . " </td>
				              
				            </tr>";
					}
					for ($i = 0; $i < count($attachment_expiries); $i++) {
						$html_attachment .= " <tr>
	                	        <td> " . $attachment_expiries[$i]['facility_code'] . "</td>
	                	        <td> " . $attachment_expiries[$i]['facility_name'] . "</td>
	                	        <td> " . $attachment_expiries[$i]['commodity_name'] . "</td>
	                	        <td> " . $attachment_expiries[$i]['commodity_code'] . "</td>
	              				<td>" . $attachment_expiries[$i]['batch_no'] . ".</td>
				              	<td>" . $attachment_expiries[$i]['expiry_date'] . "</td>
				              	<td>" . $attachment_expiries[$i]['current_balance'] . " </td>
				              
				            </tr>";
					}

				}
			endforeach;
			$html_body .= "</tbody></table>";
			$html_attachment .= "</tbody></table>";
			$html_body .= "<p align=center>Find attached a PDF file with the detailed report</p>";

			$pdf_data = $html_attachment;

			$this -> create_pdf($pdf_data, $district_id, $html_body);

		}
	}

	public function create_excel($excel_data = NUll) {

		//check if the excel data has been set if not exit the excel generation

		if (count($excel_data) > 0) :

			$objPHPExcel = new PHPExcel();
			$objPHPExcel -> getProperties() -> setCreator("HCMP");
			$objPHPExcel -> getProperties() -> setLastModifiedBy($excel_data['doc_creator']);
			$objPHPExcel -> getProperties() -> setTitle($excel_data['doc_title']);
			$objPHPExcel -> getProperties() -> setSubject($excel_data['doc_title']);
			$objPHPExcel -> getProperties() -> setDescription("");

			$objPHPExcel -> setActiveSheetIndex(0);

			$rowExec = 1;

			//Looping through the cells
			$column = 0;

			foreach ($excel_data['column_data'] as $column_data) {
				$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($column, $rowExec, $column_data);
				$objPHPExcel -> getActiveSheet() -> getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($column)) -> setAutoSize(true);
				//$objPHPExcel->getActiveSheet()->getStyle($column, $rowExec)->getFont()->setBold(true);
				$objPHPExcel -> getActiveSheet() -> getStyleByColumnAndRow($column, $rowExec) -> getFont() -> setBold(true);
				$column++;
			}
			$rowExec = 2;

			foreach ($excel_data['row_data'] as $row_data) {
				$column = 0;
				foreach ($row_data as $cell) {
					//Looping through the cells per facility
					$objPHPExcel -> getActiveSheet() -> setCellValueByColumnAndRow($column, $rowExec, $cell);

					$column++;
				}
				$rowExec++;
			}

			$objPHPExcel -> getActiveSheet() -> setTitle('Simple');

			// Save Excel 2007 file
			//echo date('H:i:s') . " Write to Excel2007 format\n";
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

			// We'll be outputting an excel file
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
			header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			// It will be called file.xls
			header("Content-Disposition: attachment; filename=" . $excel_data['file_name'] . ".xlsx");

			// Write file to the browser
			$objWriter -> save('php://output');
			$objPHPExcel -> disconnectWorksheets();
			unset($objPHPExcel);
		// Echo done
		endif;
	}

	public function create_pdf($pdf_data = NULL, $district_id = NULL, $html_body = NULL) {
		//echo $district_id;
		//exit;
		if (count($pdf_data) > 0) :
			$url = base_url() . 'assets/img/coat_of_arms.png';
			$html_title = "<div align=center><img src='$url' height='70' width='70'style='vertical-align: top;'> </img></div>
		<div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
		Ministry of Health</div>
		<div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>
		Health Commodities Management Platform</div>
		<div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>
		Weekly Reports</div><hr/>";

			$table_style = '<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
		table.data-table th {border: none;color: #036;text-align: center;border: 1px solid #DDD;border-top: none;max-width: 450px;}
		table.data-table td, table th {padding: 4px;}
		table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
		</style>';
			//$name=$this -> session -> userdata('full_name');

			$this -> mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
			$this -> mpdf -> ignore_invalid_utf8 = true;
			$this -> mpdf -> WriteHTML($html_title);
			$this -> mpdf -> defaultheaderline = 1;
			$this -> mpdf -> simpleTables = true;
			$this -> mpdf -> WriteHTML($table_style . $pdf_data);
			$this -> mpdf -> SetFooter("{DATE D j M Y }|{PAGENO}/{nb}|Prepared by: HCMP");
			//$this -> mpdf -> Output($report_name, 'I');
			//exit;
			$report_name = "Weekly Report.pdf";
			$path = $_SERVER["DOCUMENT_ROOT"];
			$handler = $path . "/HCMPv2/pdf/" . $report_name;
			write_file($handler, $this -> mpdf -> Output($report_name, 'S'));
			//$email_address = "collinsojenge@gmail.com";
			$message = $html_body;
			//echo $html_body;
			//exit;
			$subject = "Weekly Reports";
			//Get the email address of the dpp to whom the email is going to
			$email_address = $this -> get_ddp_email($district_id);
			//$email_address = "collinsojenge@gmail.com";
			$this -> hcmp_functions -> send_email($email_address, $message, $subject, $handler);
		endif;
	}

	function email_sender($report_name) {

		//setting the connection variables
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.googlemail.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = stripslashes('hcmpkenya.test@gmail.com');
		$config['smtp_pass'] = stripslashes('verystrongpassword');
		ini_set("SMTP", "ssl://smtp.gmail.com");
		ini_set("smtp_port", "465");
		ini_set("max_execution_time", "50000");

		$emails = "collinsojenge@gmail.com";

		//pulling emails from the DB
		$this -> load -> library('email', $config);
		$path = $_SERVER["DOCUMENT_ROOT"];
		$file = $path . "/HCMPv2/application/assets/pdf/" . $report_name;
		//puts the path where the pdf's are stored

		foreach ($emails as $email) {
			$this -> email -> attach($file);
			$address = $email['email'];
			$this -> email -> set_newline("\r\n");
			$this -> email -> from('hcmpkenya.test@gmail.com', "HCMP Kenya");
			//user variable displays current user logged in from sessions
			$this -> email -> to("$address");
			$this -> email -> subject('Weekly HCMP Report ');
			$this -> email -> message('Please find the Report Attached');

			//success message else show the error
			if ($this -> email -> send()) {
				echo 'Your email was sent, successfully to ' . $address . '<br/>';
				//unlink($file);
				$this -> email -> clear(TRUE);

			} else {
				show_error($this -> email -> print_debugger());
			}

		}
		ob_end_flush();
		unlink($file);
		//delete the attachment after sending to avoid clog up of pdf'ss
	}

}
