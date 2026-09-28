<?php
class Inc_prom_pun_model extends CI_Model{
	
	
	function __construct()
	{
		parent::__construct();
		
		/* Standard Libraries */
		$this->load->model('log_model');
	}

	function increment_entry_brows()
	{
		// $emp_id = array(11000026);

		$emp_id = array(11000001,11000026,11000041,11000051,11000065,11000078,11000086,11000120,11000165,11000169,11000203,11000231,11000258,11000262,11000263,11000276,11000277,11000283,11000343,11000359,11000385,11000388,11000398,11000408,11000410,11000422,11000439,11000440,11000445,11000473,11000490,11000491,11000498,11000517,11000525,11000534,11000555,11000564,11000566,11000568,11000573,11000574,11000581,11000586,11000594,11000595,11000597,11000598,11000600,11000601,11000627,11000632,11000635,11000636,11000639,11000640,11000643,11000648,11000651,11000654,11000656,11000662,11000663,11000666,11000668,11000670,11000674,11000675,11000677,11000678,11000681,11000682,11000683,11000686,11000687,13010001,13010004,13010006,13010007,13010009,13010199,13010011,13010014,13010015,13010213,13010021,13010023,13010035,13010059,13010117,13010151,13010176,13010190,13010215,13010446,13010244,13010259,13010270,13010284,13010294,13010296,13010347,13010321,13010331,13010358,13010365,13010392,13010413,13010426,13010454,13010460,13010473,13010479,13010505,13010515,13010520,13010522,13010529,13010541,13010542,13010549,13010550,13010560,13010567,13010575,13010577,13010580,13010598,13010601,13010604,13010606,13010625,13010624,13010631,13010641,13010646,13010650,13010651,13010653,13010654,13010662,13010666,13010672,13010674,13010677,13010682,13010688,13010693,13010695,13010700,13010702,13010710,13010712,13010714,13010716,13010724,13010732,13010733,13010737,13010726,13010739,13010727,13010730,13010740,13010734,13010735,13010743,13010746,13010747,13010751,13010755,13010759,13010758,13020460,13020017,13020067,13020068,13020515,13020154,13020180,13020188,13020198,13020226,13020240,13020241,13020255,13020274,13020282,13020326,13020387,13020397,13020409,13020411,13020412,13020428,13020425,13020438,13020468,13020504,13020532,13020536,13020542,13020543,13020554,13020562,13020572,13020574,13020581,13020586,13020599,13020606,13020610,13020619,13020626,13020640,13020643,13020644,13020651,13020660,13020674,13020681,13020685,13020683,13020689,13020692,13020701,13020702,13020703,13020706,13020721,13020723,13020726,13020738,13020745,13020747,13020748,13020749,13020753,13020755,13020758,13020761,13020763,13020766,13020767,13020769,13020773,13020778,13020780,13020781,13020783,13020789,13020790,13020795,13020793,13020797,13020799,13020803,13020808,13020810,13020811,13020812,13020813,13020822,13020817,13020818,13020820,13020823,13020819,13020824,13020821,13020825,13020826,13020831,13030003,13030024,13030188,13030346,13030187,13030066,13030075,13030071,13030084,13030104,13030119,13030162,13030157,13030176,13030199,13030222,13030240,13030246,13030263,13030264,13030308,13030325,13030331,13030339,13030348,13030349,13030354,13030356,13030366,13030372,13030379,13030382,13030386,13030398,13030399,13030412,13030425,13030440,13030443,13030441,13030448,13030458,13030456,13030460,13030465,13030466,13030469,13030479,13030482,13030485,13030484,13030496,13030498,13030504,13030506,13030507,13030508,13030509,13030510,13030516,13030518,13030523,13030530,13030535,13030538,13030541,13030545,13030546,13030548,13030550,13030551,13030558,13030562,13030563,13030565,13030567,13030577,13030571,13030573,13030576,13030584,13030587,13030589,13030590,13030591,13030596,13030592,13030603,12010005,12010010,12010011,12010014,12010019,12010028,12010162,12010170,12010173,12010190,12010201,12010237,12010247,12010254,12010277,12010292,12010293,12010309,12010324,12010327,12010329,12010337,12010338,12010340,12010341,12010348,12010355,12010361,12010364,12010372,12010375,12010376,12010377,12010382,12010385,12010387,12010389,12010392,12010393,12010398,12010400,12010401,12020002,12020008,12020010,12020013,12020016,12020021,12020037,12020086,12020111,12020121,12020137,12020162,12020228,12020269,12020274,12020279,12020285,12020286,12020288,12020300,12020306,12020311,12020322,12020324,12020325,12020332,12020333,12020340,12020344,12020345,12020348,12020352,12020358,12020366,12020367,12020368,12020376,12030010,12030036,12030095,12030194,12030196,12030230,12030242,12030256,12030261,12030266,12030276,12030282,12030293,12030300,12030303,12030304,12030305,12030316,12030317,12030328,12030327,12030329,12030333,12030335,12030338,12030342,12030344,12030350,12030349,12030351,12030352,12030353,12030355,12030356,12030376,12040131,12040192,12040209,12040222,12040273,12040293,12040300,12040337,12040338,12040346,12040353,12040355,12040354,12040367,12040373,12040376,12040382,12040397,12040403,12040405,12040406,12040414,12040410,12040411,12040417,12040420,12040425,12040423,12040426,12040429,12040433,12040437,12040442,12040438,12040443,12040444,12040445,12050009,12050028,12050057,12050085,12050123,12050195,12050129,12050147,12050179,12050183,12050194,12050204,12050210,12050213,12050217,12050222,12050224,12050225,12050234,12050238,12050254,12050266,12050279,12050285,12050303,12050307,12050308,12050309,12050311,12050310,12050313,12050315,12050320,12050321,12050331,12050334,12050341,12050343,12050344,12050345,12050347,12050348,12050350,12050351,12060005,12060007,12060015,12060095,12060166,12060221,12060229,12060241,12060253,12060259,12060309,12060312,12060331,12060349,12060353,12060356,12060363,12060364,12060365,12060368,12060369,12060359,12060372,12060360,12060374,12060378,12060379,12060381,12060383,12060384,12060389,12060387,12060388,12060396,12060397,12060398,12060400,12070006,12070010,12070090,12070148,12070187,12070193,12070197,12070244,12070236,12070264,12070286,12070308,12070321,12070331,12070338,12070341,12070344,12070357,12070358,12070360,12070366,12070368,12070376,12070377,12070384,12070382,12070387,12070390,12070392,12070403,12070404,12080007,12080123,12080017,12080189,12080078,12080114,12080127,12080131,12080135,12080163,12080220,12080225,12080242,12080266,12080267,12080284,12080297,12080304,12080430,12080346,12080343,12080345,12080350,12080358,12080360,12080361,12080364,12080366,12080373,12080375,12080380,12080383,12080394,12080396,12080408,12080413,12080414,12080418,12080419,12080424,12080425,12080427,12080428,12090035,12090017,12090041,12090150,12090220,12090235,12090248,12090256,12090267,12090272,12090279,12090291,12090300,12090302,12090309,12090330,12090333,12090335,12090339,12090341,12090343,12090344,12090345,12090348,12090350,12090351,12090357,12090368,12090372,12090375,12090377,12090379,12090380,12100006,12100047,12100134,12100169,12100201,12100218,12100223,12100224,12100252,12100257,12100280,12100284,12100288,12100307,12100311,12100312,12100318,12100322,12100323,12100327,12100329,12100334,12100347,12100350,12100358,12100364,12100367,12100379,12100380,12100381,12100385,12100398,12100394,12100400,12100403,12100405,12100411,12110004,12110178,12110087,12110143,12110151,12110160,12110164,12110223,12110297,12110340,12110351,12110353,12110354,12110367,12110373,12110375,12110377,12110378,12110382,12110412,12110397,12110400,12110404,12110406,12110409,12110410,12110414,12110416,12110421,12110424,12110427,12110437,12110438,12110442,12110443,12110446,12110454,12110455,12120124,12120143,12120196,12120199,12120242,12120256,12120301,12120306,12120350,12120354,12120368,12120377,12120392,12120393,12120395,12120399,12120401,12120402,12120412,12120414,12120415,12120419,12120421,12120425,12120427,12120434,12120431,12120433,12130049,12130014,12130075,12130059,12130165,12130116,12130091,12130102,12130120,12130205,12130210,12130214,12130223,12130242,12130250,12130254,12130264,12130267,12130263,12130270,12130271,12130276,12130278,12130279,12130280,12130282,12130284,12130285,12130286,12130288,12130290,12130292,12130295,12130297,12130298,12130302,12130303,12130305,12130312,12130314,12130316,12130317,12140127,12140043,12140086,12140088,12140148,12140149,12140154,12140167,12140225,12140235,12140337,12140363,12140374,12140379,12140388,12140389,12140405,12140408,12140409,12140419,12140420,12140421,12140422,12140424,12140425,12140428,12140426,12140429,12140430,12140431,12140435,12140434,12140437,12140439,12140441,12140442,12150102,12150098,12150100,12150091,12150069,12150073,12150108,12150128,12150135,12150170,12150171,12150190,12150195,12150196,12150198,12150201,12150203,12150226,12150241,12150249,12150250,12150255,12150260,12150261,12150263,12150268,12150270,12150271,12150273,12150274,12150278,12150283,12150286,12150287,12150290,12150293,12150294,12150295,12160114,12160104,12160012,12160021,12160075,12160087,12160088,12160085,12160134,12160136,12160143,12160149,12160163,12160190,12160215,12160222,12160224,12160228,12160230,12160231,12160233,12160236,12160243,12160253,12160256,12160259,12160272,12160271,12160275,12160279,12160280,12160282,12160287,12160285,12160289,12160291,12160292,12160293,12160296,12160298,12160300,12160301,12170019,12170020,12170056,12170054,12170053,12170073,12170077,12170127,12170144,12170146,12170178,12170193,12170194,12170195,12170207,12170209,12170217,12170218,12170219,12170222,12170228,12170231,12170235,12170250,12170253,12170257,12170258,12170268,12170264,12170265,12170266,12170267,12170271,12170275,12170277,12170279,12170280,12170284,12170286,12170287,12180046,12180106,12180144,12180154,12180157,12180158,12180159,12180171,12180185,12180206,12180212,12180220,12180251,12180249,12180252,12180253,12180257,12180258,12180259,12180260,12180261,12180263,12180266,12180262,12180268,12180271,12180272,12180277,12180273,12180275,12180276,12180278,12180282,12180287,12180284,12180288,12180290,12180292,15010017,15010129,15010407,15010473,15010596,15010632,15010668,15010669,15010682,15010683,15010678,15010692,15010693,15010716,15010753,15010766,14010053,14010103,14010208,14010241,14010267,14010295,14010424,14010436,14010452,14010524,14010525,14010526,14010538,14010539,14010548,14010563,14010565,14010575,14010578,14010580,14010581,14010584,15010696,14010066,14010157,14010200,14010250,14010432,14010444,14010502,14010569,14010570,14010571,14010033,14010133,14010201,14010309,14010377,14010477,14010494,14010508,14010522,14010558,14010564,14010457,14010316,14010555,14010003,14010537,14010011,14010068,14010357,14010411,14010440,14010460,14010493,14010535,14010536,14010332,14010338,14010510,14010573,14010492,14010264,15020057,15020199,15020410,15020461,15020469,15020478,15020531,15020540,15020563,15020591,15020598,15020604,15020630,14020120,14020288,14020404,14020417,14020443,14020470,14020489,14020501,14020502,14020504,14020513,14020523,14020525,14020536,14020553,14020562,14020568,14020574,14020581,14020582,14020592,14020594,14020597,14020598,14020602,14020606,14020607,14020611,14020565,15020500,14020088,14020351,14020414,14020424,14020511,14020524,14020532,14020540,14020550,14020567,14020570,14020578,14020588,14020603,15020641,14020020,14020006,14020007,14020025,14020036,14020043,14020394,14020398,14020411,14020426,14020451,14020493,14020494,14020512,14020528,14020529,14020534,14020537,14020538,14020545,14020551,14020566,14020593,14020604,14020608,15020643,15020644,14020331,14020486,14020092,14020231,14020413,14020435,14020530,14020542,14020546,14020571,14020586,14020055,14020180,14020563,14020589,14020416,14020554,15030101,15030244,15030279,15030337,15030343,15030351,15030362,15030410,15030371,15030383,15030388,15030395,15030402,15030408,15030424,15030438,15030442,14030150,14030055,14030077,14030087,14030096,14030325,14030334,14030336,14030356,14030381,14030390,14030393,14030398,14030416,14030424,14030425,14030426,14030437,14030438,14030440,14030444,14030160,14030088,14030072,14030158,14030159,14030289,14030331,14030368,14030373,14030374,14030387,14030430,14030305,14030001,14030022,14030100,14030176,14030217,14030226,14030239,14030290,14030342,14030375,14030388,14030400,14030404,14030427,14030421,14030418,14030447,14030423,14030174,14030299,14030031,14030250,14030279,14030365,14030369,14030399,14030021,14030109,14030267,14030056,14030366,15010001,15010450,15010550,15010610,15010615,15010687,15010690,15010704,15010783,15010717,15010721,15010731,15010737,15010738,15010751,15010752,15010758,15010761,15010763,15010764,15010769,15010774,15020013,15020022,15020029,15020386,15020451,15020502,15020535,15020541,15020545,15020568,15020577,15020580,15020618,15020620,15020623,15020624,15020635,15020638,15020639,15020640,15030106,15030112,15030168,15030187,15030246,15030247,15030262,15030306,15030356,15030368,15030376,15030386,15030389,15030423,15030426,15030428,15030431,15030434,15030436,15030437,15030439,15030441,15030443,15030445,15030444,15030451,16000001,16000090,16000003,16000007,16000008,16000012,16000025,16000052,16000058,16000062,16000064,16000073,16000088,16000101,16000112,16000123,16000124,16000126,16000139,16000141,16000144,16000147,16000149,16000152,16010024,16010032,16010050,16010071,16010045,16010048,16010056,16010073,16010077,16010079,16010080,16010081,16010082,16010084,16010086,16010090,16010095,16010098,16010100,16010105,16010106,16010110,16010119,16010120,16010121,16010122,16010123,16010124,16010125,18010008,18010018,18010047,18010048,18010055,18010054,18010059,18010061,18010065,18010066,18010067,18010068,15090568,15090579,15090580,15090611,15090608,15090616,15090617,15090618,15090620,15100543,15100546,15100551,15100556);
		
		$emp_com_info = $this->emp_com_info_data_brows($emp_id);

		// echo "hi";

		foreach($emp_com_info->result() as $rows)
		{
			$empid 			= $rows->emp_id;
			$emp_dept_id 	= $rows->emp_dept_id;
			$emp_sec_id 	= $rows->emp_sec_id;
			$emp_line_id 	= $rows->emp_line_id;
			$emp_desi_id 	= $rows->emp_desi_id;
			$emp_sal_gra_id = $rows->emp_sal_gra_id;
			$gross_sal 		= $rows->gross_sal;
			$com_gross_sal 	= $rows->com_gross_sal;

			// exit;
		// echo $sgross_sal;
		$new_emp_sal_gra_id	= $emp_sal_gra_id;
		$percent = 5;
		$minus_1850 = $gross_sal - 1850;
		$five_percen_inc = round((($minus_1850*$percent)/100),0);
		$new_gross_sal 	= $gross_sal + $five_percen_inc;

		$entdate 			= '01-12-2019';
		$new_entry_date 	= date("Y-m-d", strtotime($entdate));
		
		$new_gross_sal_com 	= $com_gross_sal + $five_percen_inc;
		// exit;
		$data = array(
				'prev_emp_id'		=> $empid,
				'prev_dept' 		=> $emp_dept_id,
				'prev_section' 		=> $emp_sec_id,
				'prev_line' 		=> $emp_line_id,
				'prev_desig' 		=> $emp_desi_id,
				'prev_grade'  		=> $emp_sal_gra_id,
				'prev_salary'  		=> $gross_sal,
				'prev_com_salary'	=> $com_gross_sal,
				'new_emp_id'  		=> $empid,
				'new_dept'  		=> $emp_dept_id,
				'new_section'		=> $emp_sec_id,
				'new_line' 			=> $emp_line_id,
				'new_desig'			=> $emp_desi_id,
				'new_grade'			=> $new_emp_sal_gra_id,
				'new_salary'		=> $new_gross_sal,
				'new_com_salary'	=> $new_gross_sal_com,
				'effective_month'	=> $new_entry_date,
				'ref_id'			=> $empid,
				'status'			=> 1
		);
		
		$this->db->insert('pr_incre_prom_pun', $data);						
		$data2 = array(
				
				'emp_sal_gra_id'	=> $new_emp_sal_gra_id,
				'gross_sal'  		=> $new_gross_sal,
				'com_gross_sal'  	=> $new_gross_sal_com,
		);

		$this->db->where('emp_id',$empid);
		$this->db->update('pr_emp_com_info', $data2);
		// return "true";
		}
		
	}
	
	function increment_entry()
	{
		$empid 				=  $this->input->post('empid');
		$emp_com_info = $this->emp_com_info_data($empid);
		foreach($emp_com_info->result() as $rows)
		{
			$emp_dept_id 	= $rows->emp_dept_id;
			$emp_sec_id 	= $rows->emp_sec_id;
			$emp_line_id 	= $rows->emp_line_id;
			$emp_desi_id 	= $rows->emp_desi_id;
			$emp_sal_gra_id = $rows->emp_sal_gra_id;
			$gross_sal 		= $rows->gross_sal;
			$com_gross_sal 	= $rows->com_gross_sal;
		}
		
		
		
		$new_emp_sal_gra_id	= $this->input->post('salg');
		$new_gross_sal 		= $this->input->post('text8');
		$entdate 			= $this->input->post('entdate');
		$new_entry_date 	= date("Y-m-d", strtotime($entdate));
		
		$diff_gross_salary 	= $new_gross_sal - $gross_sal;
		$new_gross_sal_com 	= $com_gross_sal + $diff_gross_salary;
			
		$data = array(
				'prev_emp_id'		=> $empid,
				'prev_dept' 		=> $emp_dept_id,
				'prev_section' 		=> $emp_sec_id,
				'prev_line' 		=> $emp_line_id,
				'prev_desig' 		=> $emp_desi_id,
				'prev_grade'  		=> $emp_sal_gra_id,
				'prev_salary'  		=> $gross_sal,
				'prev_com_salary'	=> $com_gross_sal,
				'new_emp_id'  		=> $empid,
				'new_dept'  		=> $emp_dept_id,
				'new_section'		=> $emp_sec_id,
				'new_line' 			=> $emp_line_id,
				'new_desig'			=> $emp_desi_id,
				'new_grade'			=> $new_emp_sal_gra_id,
				'new_salary'		=> $new_gross_sal,
				// 'new_com_salary'	=> $new_gross_sal_com,
				'new_com_salary'	=> $new_gross_sal,
				'effective_month'	=> $new_entry_date,
				'ref_id'			=> $empid,
				'status'			=> 1
		);
		
		$this->db->insert('pr_incre_prom_pun', $data);						
		$data2 = array(
				
				'emp_sal_gra_id'	=> $new_emp_sal_gra_id,
				'gross_sal'  		=> $new_gross_sal,
				'com_gross_sal'  	=> $new_gross_sal,
				// 'com_gross_sal'  	=> $new_gross_sal_com,
		);
		$this->db->where('emp_id',$empid);
		$v1 = $this->db->update('pr_emp_com_info', $data2);
		return "true";
	/*	if( $v1) 
		{
			// PROFILE LOG Generate
			$log_username = $this->session->userdata('username');
			$log_emp_id   = $this->input->post('empid');
			$this->log_model->log_profile_update($log_username, $log_emp_id);
			//echo "Updated successfully";
			return true;
		}
		else
		{
			return false;
		}*/
	}
	
	function promotion_entry()
	{
		
		$empid 				= $this->input->post('empid');
		$new_empid 			= $this->input->post('new_empid');
		$new_dept 			= $this->input->post('dept');
		$new_section 		= $this->input->post('sec');
		$new_line 			= $this->input->post('line');
		$new_desig 			= $this->input->post('desig');
		$new_emp_sal_gra_id	= $this->input->post('salg');
		$emp_category 		= $this->input->post('empstat');
		$new_gross_sal 		= $this->input->post('text8');
		$entdate 			= $this->input->post('entdate');
		$new_entry_date 	= date("Y-m-d", strtotime($entdate));
		$new_year 			= date("Y", strtotime($new_entry_date));
		$new_month 			= date("m", strtotime($new_entry_date));
		
		
	
		$emp_com_info = $this->emp_com_info_data($empid);
		foreach($emp_com_info->result() as $rows)
		{
			$emp_unit_id 		= $rows->unit_id;
			$emp_floor_id 		= $rows->floor_id;
			$emp_dept_id 		= $rows->emp_dept_id;
			$emp_sec_id 		= $rows->emp_sec_id;
			$wk_type_id 		= $rows->wk_type_id;
			$work_process_id 	= $rows->work_process_id;
			$emp_line_id 		= $rows->emp_line_id;
			$emp_desi_id 		= $rows->emp_desi_id;
			$emp_operation_id 	= $rows->emp_operation_id;
			$emp_position_id 	= $rows->emp_position_id;
			$emp_sts_id 		= $rows->emp_sts_id;
			$emp_sal_gra_id 	= $rows->emp_sal_gra_id;
			$emp_cat_id 		= $rows->emp_cat_id;
			$emp_shift 			= $rows->emp_shift;
			$weekend 			= $rows->weekend;
			$gross_sal 			= $rows->gross_sal;
			$com_gross_sal 		= $rows->com_gross_sal;
			$ot_entitle 		= $rows->ot_entitle;
			$ot_show_in 		= $rows->ot_show_in;
			$transport 			= $rows->transport;
			$lunch 				= $rows->lunch;
			$att_bonus 			= $rows->att_bonus;
			$salary_draw 		= $rows->salary_draw;
			$salary_type 		= $rows->salary_type;
			$emp_join_date 		= $rows->emp_join_date;
		}
		$diff_gross_salary 	= $new_gross_sal - $gross_sal;
		$new_gross_sal_com 	= $com_gross_sal + $diff_gross_salary;
		
	 	$this->db->trans_start();
		
		if($new_empid == "")
		{
			$data_update = array(
				
				'emp_dept_id' 		=> $new_dept,
				'emp_sec_id' 		=> $new_section,
				'emp_line_id' 		=> $new_line,
				'emp_desi_id' 		=> $new_desig,
				'emp_sal_gra_id'	=> $new_emp_sal_gra_id,
				'gross_sal'  		=> $new_gross_sal,
				'com_gross_sal'  	=> $new_gross_sal,
				// 'com_gross_sal'  	=> $new_gross_sal_com,
			);
			$this->db->where('emp_id',$empid);
			$v1 = $this->db->update('pr_emp_com_info', $data_update);
			
			$new_empid = $empid ;
		}
		else
		{
			$data_insert = array(

				'emp_id' 			=> $new_empid,
				'unit_id' 			=> $emp_unit_id,
				'floor_id' 			=> $emp_floor_id,
				'emp_dept_id' 		=> $new_dept,
				'emp_sec_id' 		=> $new_section,
				'wk_type_id' 		=> $wk_type_id,
				'work_process_id' 	=> $work_process_id,
				'emp_line_id' 		=> $new_line,
				'emp_desi_id' 		=> $new_desig,
				'emp_operation_id'	=> $emp_operation_id,
				'emp_position_id'  	=> $emp_position_id,
				'emp_sts_id'  		=> $emp_sts_id,
				'emp_sal_gra_id' 	=> $new_emp_sal_gra_id,
				'emp_cat_id' 		=> $emp_cat_id,
				'emp_shift' 		=> $emp_shift,
				'weekend' 			=> $weekend,
				'gross_sal' 		=> $new_gross_sal,
				'com_gross_sal'  	=> $new_gross_sal,
				// 'com_gross_sal'  	=> $new_gross_sal_com,
				'ot_entitle'		=> $ot_entitle,
				'ot_show_in'		=> $ot_show_in,
				'transport'  		=> $transport,
				'lunch'  			=> $lunch,
				'att_bonus'  		=> $att_bonus,
				'salary_draw'  		=> $salary_draw,
				'salary_type'  		=> $salary_type,
				'emp_join_date'  	=> $emp_join_date
				
			);
			$this->db->insert('pr_emp_com_info', $data_insert);
			
			$data_update1 = array(
			'emp_cat_id' 		=> 6
			);
			$this->db->where('emp_id',$empid);
			$v1 = $this->db->update('pr_emp_com_info', $data_update1);
			
			//***********used for personal info table ********
			$this->db->select("*");
			$this->db->where('emp_id',$empid);
			$emp_per_info = $this->db->get("pr_emp_per_info");
			
			foreach($emp_per_info->result() as $rows)
			{
				$emp_full_name 		= $rows->emp_full_name;
				$bangla_nam 		= $rows->bangla_nam;
				$identificatiion_marks = $rows->identificatiion_marks;
				$national_brn_id = $rows->national_brn_id;
				$emp_fname 			= $rows->emp_fname;
				$emp_fname_bn 		= $rows->emp_fname_bn;
				$emp_mname 			= $rows->emp_mname;
				$emp_mname_bn 		= $rows->emp_mname_bn;
				$spouse_name 		= $rows->spouse_name;
				$no_child 			= $rows->no_child;
				$emp_dob 			= $rows->emp_dob;
				$emp_religion 		= $rows->emp_religion;
				$emp_sex 			= $rows->emp_sex;
				$emp_marital_status = $rows->emp_marital_status;
				$emp_blood 			= $rows->emp_blood;
				$bank_ac_no 		= $rows->bank_ac_no;
				$img_source 		= $rows->img_source;
			}
			
			$data_emp_per_info = array(
				
				'emp_id' 				=> $new_empid,
				'emp_full_name' 		=> $emp_full_name,
				'bangla_nam' 			=> $bangla_nam,
				'identificatiion_marks' => $identificatiion_marks,
				'national_brn_id' 		=> $national_brn_id,
				'emp_fname' 			=> $emp_fname,
				'emp_fname_bn' 			=> $emp_fname_bn,
				'emp_mname' 			=> $emp_mname,
				'emp_mname_bn' 			=> $emp_mname_bn,
				'spouse_name' 			=> $spouse_name,
				'no_child' 				=> $no_child,
				'emp_dob'				=> $emp_dob,
				'emp_religion'  		=> $emp_religion,
				'emp_sex' 				=> $emp_sex,
				'emp_marital_status' 	=> $emp_marital_status,
				'emp_blood' 			=> $emp_blood,
				'bank_ac_no' 			=> $bank_ac_no,
				'img_source' 			=> $img_source
				
			);
			$this->db->insert('pr_emp_per_info', $data_emp_per_info);
			
			//************ used for employee address table *********
			$this->db->select("*");
			$this->db->where('emp_id',$empid);
			$pr_emp_add = $this->db->get("pr_emp_add");
			
			foreach($pr_emp_add->result() as $rows)
			{
				$emp_pre_add 		= $rows->emp_pre_add;
				$emp_par_add 		= $rows->emp_par_add;
				$emp_par_dis 		= $rows->emp_par_dis;
				$emp_pre_add_ban 	= $rows->emp_pre_add_ban;
				$emp_par_add_ban 	= $rows->emp_par_add_ban;
				$mobile 			= $rows->mobile;
			}
			
			$data_pr_emp_add = array(
				
				'emp_id' 			=> $new_empid,
				'emp_pre_add' 		=> $emp_pre_add,
				'emp_par_add' 		=> $emp_par_add,
				'emp_par_dis' 		=> $emp_par_dis,
				'emp_pre_add_ban' 	=> $emp_pre_add_ban,
				'emp_par_add_ban' 	=> $emp_par_add_ban,
				'mobile' 			=> $mobile
				
			);
			$this->db->insert('pr_emp_add', $data_pr_emp_add);
			
			//************ used for employee education table *********
			$this->db->select("*");
			$this->db->where('emp_id',$empid);
			$pr_emp_edu = $this->db->get("pr_emp_edu");
			
			foreach($pr_emp_edu->result() as $rows)
			{
				$emp_degree 		= $rows->emp_degree;
				$emp_pass_yr 		= $rows->emp_pass_yr;
				$emp_ins 			= $rows->emp_ins;
			}
			
			$data_pr_emp_edu = array(
				
				'emp_id' 			=> $new_empid,
				'emp_degree' 		=> $emp_degree,
				'emp_pass_yr' 		=> $emp_pass_yr,
				'emp_ins' 			=> $emp_ins
			);

			$this->db->insert('pr_emp_edu', $data_pr_emp_edu);
			
			//************ used for employee puncg card table *********
			$this->db->select("*");
			$this->db->where('emp_id',$empid);
			$pr_id_proxi = $this->db->get("pr_id_proxi");
			
			foreach($pr_id_proxi->result() as $rows)
			{
				$proxi_id  		= $rows->proxi_id ;
			}
			
			/*$data_pr_id_proxi = array(
				
				'emp_id' 			=> $new_empid,
				'proxi_id ' 		=> $proxi_id 			
			);*/
			$data_pr_id_proxi = array(
				
				'emp_id' 			=> $new_empid,
				'proxi_id ' 		=> $new_empid 			
			);
			$this->db->insert('pr_id_proxi', $data_pr_id_proxi);
			
			//************ used for employee skill table *********
			$this->db->select("*");
			$this->db->where('emp_id',$empid);
			$pr_id_proxi = $this->db->get("pr_emp_skill");
			
			foreach($pr_id_proxi->result() as $rows)
			{
				$emp_skill  		= $rows->emp_skill ;
				$emp_yr_skill  		= $rows->emp_yr_skill ;
				$emp_com_name  		= $rows->emp_com_name ;
			}
			
			$data_pr_emp_skill = array(
				
				'emp_id' 			=> $new_empid,
				'emp_skill' 		=> $emp_skill,
				'emp_yr_skill' 		=> $emp_yr_skill,
				'emp_com_name' 		=> $emp_com_name,
							
			);
			$this->db->insert('pr_emp_skill', $data_pr_emp_skill);
			
			//************Copy temp table**********************
			//$old_table = "temp_$empid";
			//$new_table = "temp_$new_empid";
			//$this->db->query("CREATE TABLE $new_table AS (SELECT * FROM $old_table)");
			$this->load->dbforge();	
				$temp_table = "temp_$new_empid";
				$temp_fields = array(
				'att_id' 	=> array( 'type' => 'INT','constraint' => '11',  'auto_increment' => TRUE),
				'device_id' => array( 'type' => 'INT','constraint' => '11'),
				'proxi_id'  => array( 'type' => 'INT','constraint' => '11'),
				'date_time' => array( 'type' => 'datetime')
			);
			$this->dbforge->add_field($temp_fields);
			$this->dbforge->add_key('att_id', TRUE);
			$this->dbforge->create_table($temp_table);
			
			
		}
		
		$data = array(
				'prev_emp_id'		=> $empid,
				'prev_dept' 		=> $emp_dept_id,
				'prev_section' 		=> $emp_sec_id,
				'prev_line' 		=> $emp_line_id,
				'prev_desig' 		=> $emp_desi_id,
				'prev_grade'  		=> $emp_sal_gra_id,
				'prev_salary'  		=> $gross_sal,
				'prev_com_salary'	=> $com_gross_sal,
				'new_emp_id'  		=> $new_empid,
				'new_dept'  		=> $new_dept,
				'new_section'		=> $new_section,
				'new_line' 			=> $new_line,
				'new_desig'			=> $new_desig,
				'new_grade'			=> $new_emp_sal_gra_id,
				'new_salary'		=> $new_gross_sal,
				'new_com_salary'	=> $new_gross_sal,
				// 'new_com_salary'	=> $new_gross_sal_com,
				'effective_month'	=> $new_entry_date,
				'ref_id'			=> $new_empid,
				'status'			=> 2
		);
		$this->db->insert('pr_incre_prom_pun', $data);
		
		$refid_update = array(
			'ref_id' 		=> $new_empid
			);
			$this->db->where('ref_id',$empid);
			$v3 = $this->db->update('pr_incre_prom_pun', $refid_update);
		$this->db->trans_complete();										
		return "true";
	
	}

	/*function emp_com_info_data_brows($empid)
	{
		$this->db->select("*");
		$this->db->where_in('emp_id',$empid);
		$query = $this->db->get("pr_emp_com_info");
		return $query;
	}*/
	
	
	function emp_com_info_data($empid)
	{
		$this->db->select("*");
		$this->db->where('emp_id',$empid);
		$query = $this->db->get("pr_emp_com_info");
		return $query;
	}
	
	function get_old_entry_date($empid, $entdate)
	{
		
		$new_entry_date = date("Y-m-d", strtotime($entdate));
		$new_year = date("Y", strtotime($new_entry_date));
		$new_month = date("m", strtotime($new_entry_date));
		$new_year_month = $new_year."-".$new_month;
				
		$this->db->select("effective_month");
		$this->db->where('new_emp_id',$empid);
		$this->db->limit(1);
		$this->db->order_by('effective_month',"desc");
		$query = $this->db->get("pr_incre_prom_pun");
		//echo $empid."--".$query->num_rows();
		if($query->num_rows() > 0)
		{
			//echo "hello";
			foreach($query->result() as $row)
			{		
				$old_entry_date = $row->effective_month;
				
				
				$old_year = date("Y", strtotime($old_entry_date));
				$old_month = date("m", strtotime($old_entry_date));
				$old_year_month = $old_year."-".$old_month;
				
				$uni_new_year_month = strtotime($new_year_month);
				$uni_old_year_month = strtotime($old_year_month);		
			}
			
			if($uni_new_year_month <= $uni_old_year_month)
			{
					return false;
			}
			else
			{
				return true;
			}
		}
		else
		{
				return true;
		}		
	}
	
	function get_gross_salary_check_incre($empid, $new_gross_salary)
	{
		$emp_com_info = $this->emp_com_info_data($empid);
		if($emp_com_info->num_rows() > 0)
		{
		  foreach($emp_com_info->result() as $rows)
		  {
			  $old_gross_sal = $rows->gross_sal;
		  }
		  if($new_gross_salary <= $old_gross_sal)
		  {
			  return false;
		  }
		  else
		  {
			  return true;
		  }
		}
	}
	
	function get_gross_salary_check_prom($empid, $new_gross_salary)
	{
		$emp_com_info = $this->emp_com_info_data($empid);
		if($emp_com_info->num_rows() > 0)
		{
		  foreach($emp_com_info->result() as $rows)
		  {
			  $old_gross_sal 		= $rows->gross_sal;
		  }
		  
		  if($new_gross_salary < $old_gross_sal)
		  {
			  return false;
		  }	
		  else
		  {
			  return true;
		  }
		}
	}
	
	function get_any_change_check_prom($empid, $new_dept)
	{
		
		$new_dept 			= $this->input->post('dept');
		$new_section 		= $this->input->post('sec');
		$new_line 			= $this->input->post('line');
		$new_desig 			= $this->input->post('desig');
		$emp_com_info = $this->emp_com_info_data($empid);
		if($emp_com_info->num_rows() > 0)
		{
		  foreach($emp_com_info->result() as $rows)
		  {
			  $emp_dept_id 		= $rows->emp_dept_id;
			  $emp_sec_id 		= $rows->emp_sec_id;
			  $emp_line_id 		= $rows->emp_line_id;
			  $emp_desi_id 		= $rows->emp_desi_id;
		  }
		  if ($emp_dept_id == $new_dept && $emp_sec_id == $new_section && $emp_line_id == $new_line && $emp_desi_id == $new_desig)
		  {
			  return false;
		  }		
		  else
		  {
			  return true;
		  }
		}
	}
	
}
?>