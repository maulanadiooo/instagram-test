<?php

require '../../lib/function.php';
require '../../lib/admin-session.php';



if($_GET['action'] === "table_data"){
 
 
	$columns = array( 
							 0 =>'id', 
							 1 =>'username',
							 2=> 'photo',
							 3=> 'caption',
							 4=> 'caption'
						 );

	$querycount = $db->query("SELECT count(id) as jumlah FROM feeds");
	$datacount = $querycount->fetch_array();
  
 
	  $totalData = $datacount['jumlah'];
		   
	  $totalFiltered = $totalData; 

	  $limit = $_POST['length'];
	  $start = $_POST['start'];
	  $order = $columns[$_POST['order']['0']['column']];
	  $dir = $_POST['order']['0']['dir'];
		   
	  if(empty($_POST['search']['value']))
	  {            
	   $query = $db->query("SELECT feeds.*, users.username FROM feeds 
													join users ON users.id = feeds.user_id
													order by $order $dir
													LIMIT $limit
													OFFSET $start");
	  }
	  else {
		  $search = $_POST['search']['value']; 
		  $query = $db->query("SELECT feeds.*, users.username FROM feeds
		  											   join users ON users.id = feeds.user_id
													   WHERE username LIKE '%$search%'
													   or caption LIKE '%$search%'
													   order by $order $dir
													   LIMIT $limit
													   OFFSET $start");


		 $querycount = $db->query("SELECT count(id) as jumlah FROM feeds 
		 												join users ON users.id = feeds.user_id 
														WHERE users.username LIKE '%$search%'
														or caption LIKE '%$search%'");
	   $datacount = $querycount->fetch_array();
		 $totalFiltered = $datacount['jumlah'];
	  }

	  $data = array();
	  if(!empty($query))
	  {
		  
		  while ($r = $query->fetch_array())
		  {
			  $idPost = $r['id'];
			  $nestedData['id'] = $r['id'];
			  $nestedData['username'] = $r['username'];
			  $nestedData['photo'] = $r['photo'];
			  $nestedData['caption'] = $r['caption'];
			  $nestedData['action'] = "<a v-on:click='viewPost($idPost)' type='button' class='btn-warning btn-sm'>View</a>&nbsp; <a href='#' class='btn-danger btn-sm'>Delete</a>";
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
