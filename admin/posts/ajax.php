<?php

require '../../lib/function.php';
require '../../lib/admin-session.php';



if($_GET['action'] === "table_data"){
 
 
	$columns = array( 
							 0 =>'id', 
							 1 =>'username',
							 2=> 'photo',
							 3=> 'caption'
						 );

	$querycount = mysqli_query($db, "SELECT * from feeds");

	$totalData = mysqli_num_rows($querycount);
	  $totalFiltered = $totalData;

	  $limit = $_POST['length'];
	  $start = $_POST['start'];
	  $order = $columns[$_POST['order']['0']['column']];
	  $dir = $_POST['order']['0']['dir'];
		   
	  if(empty($_POST['search']['value']))
	  {            
		$query = mysqli_query($db, "SELECT feeds.*, users.username FROM feeds
				join users ON users.id = feeds.user_id
				ORDER by $order $dir
				LIMIT $limit
				OFFSET $start");
	  }
	  else {
		  $search = $_POST['search']['value']; 
		  $query = mysqli_query($db, "SELECT feeds.*, users.username FROM feeds
		  		join users ON users.id = feeds.user_id
				WHERE users.username LIKE '%$search%' OR feeds.caption LIKE '%$search%' 
				ORDER by $order $dir
				LIMIT $limit
				OFFSET $start");

		
		 $totalFiltered = mysqli_num_rows($query);
	  }

	  $data = array();
	  if(mysqli_num_rows($query) != 0)
	  {
		  
		  while ($r = mysqli_fetch_assoc($query))
		  {
			  if(strlen($r['caption']) > 80){
				$caption = substr($r['caption'],0, 80)."...";
			  } else {
				$caption = $r['caption'];
			  }
			  
			  $idPost = $r['id'];
			  $nestedData['id'] = $r['id'];
			  $nestedData['username'] = $r['username'];
			  $nestedData['photo'] = $r['photo'];
			  $nestedData['caption'] = $caption;
			  $data[] = $nestedData;
			  
		  }
	  }
		 
	  $json_data = array(
				  "draw"            => intval($_POST['draw']),  
				  "recordsTotal"    => intval($totalData),  
				  "recordsFiltered" => intval($totalFiltered), 
				  "data"            => $data  
				  );
		   
	  echo json_encode($json_data); 

}

if($_GET['action'] === "commentData"){
	$idFeed = $db->real_escape_string(trim(htmlspecialchars($_GET['q'])));
	$columns = array( 
					0 =>'id', 
					1 =>'username',
					2=> 'comment',
				);

	$querycount = mysqli_query($db, "SELECT * from comments");

	$totalData = mysqli_num_rows($querycount);
	$totalFiltered = $totalData;

	$limit = $_POST['length'];
	$start = $_POST['start'];
	$order = $columns[$_POST['order']['0']['column']];
	$dir = $_POST['order']['0']['dir'];

	if(empty($_POST['search']['value']))
	{            
		$query = mysqli_query($db, "SELECT comments.*, users.username FROM comments
		join users ON users.id = comments.user_id
		WHERE feed_id = '$idFeed'
		ORDER by $order $dir
		LIMIT $limit
		OFFSET $start");
	}
	else {
		$search = $_POST['search']['value']; 
		$query = mysqli_query($db, "SELECT comments.*, users.username FROM comments
		join users ON users.id = comments.user_id
		WHERE feed_id = '$idFeed' AND (users.username LIKE '%$search%' OR feeds.caption LIKE '%$search%') 
		ORDER by $order $dir
		LIMIT $limit
		OFFSET $start");


	$totalFiltered = mysqli_num_rows($query);
	}

	$data = array();
	if(mysqli_num_rows($query) != 0)
	{

	while ($r = mysqli_fetch_assoc($query))
	{

	$nestedData['id'] = $r['id'];
	$nestedData['username'] = $r['username'];
	$nestedData['comment'] =  $r['comment'];
	$data[] = $nestedData;

	}
	}

	$json_data = array(
	"draw"            => intval($_POST['draw']),  
	"recordsTotal"    => intval($totalData),  
	"recordsFiltered" => intval($totalFiltered), 
	"data"            => $data  
	);

	echo json_encode($json_data); 


}
?>
