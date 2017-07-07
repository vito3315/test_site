<?php
	class site{
		private $host 		= 'localhost';
		private $user 		= 'marusimg_marcet';
		private $pwd 		= '4815162342';
		private $bd 		= 'marusimg_marcet';
		
		private $user_1		= 'marusimg_mark_1c';
		private $pwd_1 		= '4815162342';
		private $bd_1 		= 'marusimg_mark_1c';
		
		private $link_;
		public  $cash;
		
		function __construct() {
			$this->cash = memcache_connect('127.0.0.1', 11211);
		}
		
		public function connect_open_1(){
			$this->link_ = mysql_connect($this->host, $this->user, $this->pwd) or
				die('Could not connect: ' . mysql_error());
			mysql_select_db($this->bd);
			echo "open_link_market<br />";
		}
		
		public function connect_open_2(){
			$this->link_ = mysql_connect($this->host, $this->user_1, $this->pwd_1) or
				die('Could not connect: ' . mysql_error());
			mysql_select_db($this->bd_1);
			echo "open_link_1c<br />";
		}
		
		public function connect_close(){
			mysql_close($this->link_);
			echo "close_link<br />";
		}
		
		public function start(){
			$this->connect_open_2();
			
			$data['numenklatura'] = $this->get_list('numenklatura_tlt');
			
			if(!empty($data['numenklatura'])){
				foreach($data['numenklatura'] as $num_item){
					mysql_query("INSERT INTO numenklatura_tlt_history VALUES('', '".$num_item['name']."', '".$num_item['art']."', '".$num_item['kod']."', '".$num_item['price']."', '".$num_item['date']."')");
					//echo "INSERT INTO numenklatura_tlt_history VALUES('', '".$num_item['name']."', '".$num_item['art']."', '".$num_item['kod']."', '".$num_item['price']."', '".$num_item['date']."')"."<br />";
				}
				
				mysql_query("TRUNCATE numenklatura_tlt");
				
				echo "wil_get_1c<br />";
				
				$this->connect_close();
				$this->connect_open_1();
				
				//$data['numenklatura'] = $this->get_list('nomenklatura');
				foreach($data['numenklatura'] as $num_item){
					mysql_query("UPDATE items SET price='".$num_item['price']."', type_price=2 WHERE kod='".$num_item['kod']."'");
					//mysql_query("INSERT INTO test VALUES('', '".$num_item['name']."')");
				}
				//return 'true';
				echo "end<br />";
				mysql_query("INSERT INTO test VALUES('', '".date("F j, Y, g:i a")."')");
				
				memcache_flush($this->cash);	
			}
			
			$this->connect_close();
			
			//echo date("F j, Y, g:i a");
		}
		
		public function get_list($table, $id='', $type_id='', $sort='', $is_show=0){
			$type_id = $type_id!=''?"$type_id":'id';
			$query = $id!=''?" WHERE $type_id='$id'":'';
			$sort = $sort!=''?" ORDER BY $sort ASC ":'';
			
			if($is_show==1){
				$is_show = $id!=''?' AND is_show=1 ':' WHERE is_show=1 ';
			}else{
				$is_show = '';
			}
			
			//echo "<br />SELECT * FROM ".$table.$query.$is_show.$sort;
			
			return $this->get_query_list("SELECT * FROM ".$table.$query.$is_show.$sort);
		}
		
		public function get_one($table, $id='', $type_id='', $is_show=0){
			$type_id = $type_id!=''?"$type_id":"id";
			$query = $id!=''?" WHERE $type_id='$id'":"";
			
			if($is_show==1){
				$is_show = $id!=''?' AND is_show=1 ':' WHERE is_show=1 ';
			}else{
				$is_show = '';
			}
			
			return $this->get_query_one("SELECT * FROM ".$table.$query.$is_show);
		}
		
		public function get_query_list($query){
			$query = mysql_query($query);
			$result = array();
			while($row = mysql_fetch_assoc($query)){
				$result[] = $row;
			}
			return $result;
		}
	
		public function get_query_one($query){
			$query = mysql_query($query);			
			return mysql_fetch_assoc($query);
		}
		
	}

	$site = new site();
	$site->start();
	return 'true';
?>	