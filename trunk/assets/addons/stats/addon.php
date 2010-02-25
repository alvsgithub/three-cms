<?php
class Stats extends AddonBaseModel
{
	var $dbforge;
	
	/**
	 * Initialize
	 */
	function init()
	{
		$this->frontEnd = true;
		$this->results  = array();
	}
	
	/**
	 * This function tells Three CMS on which hook a function needs to be called
	 */
	function getHooks()
	{
		// Since this addon only does something on the frontend, there are no hooks:
		$hooks = array(
			array(
				'hook'=>'PreRenderPage',
				'callback'=>'preRender'
			),
			array(
				'hook'=>'LoadAdmin',
				'callback'=>'loadUtilities'
			),
			array(
				'hook'=>'DashBoardItem',
				'callback'=>'renderDashboard'
			)
		);
		return $hooks;
	}
	
	// Load utilities
	function loadUtilities($context)
	{
		// Load the CI-dbforge library:
		$context['admin']->load->dbforge();
		$this->dbforge = $context['admin']->dbforge;
		// Check if the table exists, otherwise, install it:
		if(!$this->db->table_exists('stats')) {
			$this->install();
		}
	}
	
	// Load stats
	function preRender($context)
	{
		if($this->db->table_exists('stats')) {
			// Save stats for this IP:
			$ip   = $_SERVER['REMOTE_ADDR'];
			$this->db->select('views');
			$this->db->where('ip', $ip);
			$query = $this->db->get('stats');
			if($query->num_rows == 0) {
				$date = date('Y-m-d');
				$this->db->insert('stats', array('ip'=>$ip, 'date'=>$date, 'views'=>1));
			} else {
				$result = $query->result();
				$views  = $result[0]->views + 1;
				$this->db->where('ip', $ip);
				$this->db->update('stats', array('views'=>$views));
			}
			// Save stats for this page:
			$url = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			$this->db->select('views');
			$this->db->where('url', $url);
			$query = $this->db->get('stats_pages');
			if($query->num_rows == 0) {
				$date = date('Y-m-d');
				$name = $context['dataObject']->options['contentName'];
				$this->db->insert('stats_pages', array('url'=>$url, 'name'=>$name, 'date'=>$date, 'views'=>1));
			} else {
				$result = $query->result();
				$views  = $result[0]->views + 1;
				$this->db->where('url', $url);
				$this->db->update('stats_pages', array('views'=>$views));
			}
			// Purge entries which are older than 2 year, preventing an exploding bubble:
			$date = date('Y-m-d', mktime() - (60 * 60 * 24 * 365 * 2));
			$this->db->where('date <', $date);
			$this->db->delete(array('stats', 'stats_pages'));
		}
	}
	
	// Install stats
	function install()
	{
        // Stats table:
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'ip' => array(
                'type' => 'TINYTEXT'
            ),
            'date' => array(
                'type' => 'DATE'
            ),
            'views' => array(
                'type' => 'INT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('stats', true);
		
        // Pages table:
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'auto_increment' => true
            ),
            'name' => array(
                'type' => 'TINYTEXT'
            ),
            'url' => array(
                'type' => 'TINYTEXT'
            ),
            'date' => array(
                'type' => 'DATE'
            ),
            'views' => array(
                'type' => 'INT'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('stats_pages', true);
	}
	
	// Dashboard widget:
	function renderDashBoard($context)
	{
		if($context['item']['source'] == 'stats') {
			// 350 x 200px
			// Get the pageviews:
			// TODO: Optimize this (get TOTAL from MySQL or something)
			$this->db->select('date,views');
			$this->db->order_by('date', 'desc');
			$this->db->where('date >', date('Y-m-d', mktime()-(60*60*24*30)));
			$query = $this->db->get('stats');
			$pageViews      = array();
			$uniqueVisitors = array();
			$currentDate    = '';
			$currentViews   = 0;
			$currentUnique  = 0;
			foreach($query->result() as $result) {				
				if($result->date != $currentDate) {
					// New date:
					$currentViews   = 0;
					$currentUnique  = 0;
					if($currentDate!='') {
						array_push($pageViews, $currentViews);
						array_push($uniqueVisitors, $currentUnique);
					}
					$currentDate = $result->date;
				}
				// Increase values:
				$currentViews   += $result->views;	// Increase views
				$currentUnique  += 1;				// Increase unique visitors
			}
			// Last one:
			array_push($pageViews, $currentViews);
			array_push($uniqueVisitors, $currentUnique);
			echo '<h2>Results over the last 30 days:</h2>';
			echo '<h4>Unique visitors / pageviews:</h4>';
			print_r($pageViews);
			$max = ceil(max($pageViews) / 20) * 20;
			$min = floor(min($pageViews) / 20) * 20;
			$min = 0;
			// Convert data for google:			
			echo '
				<img src="http://chart.apis.google.com/chart?chs=350x200&amp;cht=lc&amp;chxt=x,y&chxr=0,0,30,5|1,'.$min.','.$max.'&chg=0,25,1,3&chls=3&chco=004488&chds='.$min.','.$max.'&chd=t:'.implode(',', $pageViews).'"/>
			';
			echo '<h4>Visited pages:</h4>';
		}
	}
}
?>