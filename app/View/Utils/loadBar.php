<?php 
	global $memcache;
	$memcache = new Memcached();
	$memcache->addServer('localhost', 11211);

	if(!$memcache->get('current_progress'))
	{
		$memcache->add('current_progress',0,0);
	}
	if(!$memcache->get('limit_progress'))
	{
		$memcache->add('limit_progress',100,0);
	}

	if(!empty($_GET["request"])){
		getNumbers();
	}
	elseif (!empty($_GET["reset"])) {
		resetNumbers();
	}

	function getNumbers()
	{
		global $memcache;
		echo $memcache->get('current_progress')."|".$memcache->get('limit_progress')."|";
		//error_log($memcache->get('current_progress')."|".$memcache->get('limit_progress')."|");
}
	function resetNumbers()
	{
		global $memcache;
		$memcache->set('current_progress', 0, 0);
		$memcache->set('limit_progress', 100, 0);
		//error_log("Reset Numbers: ".$memcache->get('current_progress')."|".$memcache->get('limit_progress')."|");
	}

	function writeNumbers($limit)
	{
		global $memcache;
		$memcache->set('current_progress', 0, 0);
		$memcache->set('limit_progress', $limit, 0);
		//error_log("LimitProgress: ".$limit);
	}

	function updateProgress($updated_progress)
	{
		global $memcache;
		$memcache->set('current_progress', $updated_progress, 0);
	}

	function addProgress()
	{
		global $memcache;
		$current = $memcache->get('current_progress');
		$memcache->set('current_progress', $current + 1, 0);
	}
?>