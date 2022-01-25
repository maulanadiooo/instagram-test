<?php

require '../../lib/function.php';
require '../../lib/admin-session.php';



if($_GET['action'] === "table_data"){
 
 
	$columns = array( 
							 0 =>'photo', 
							 1 =>'name',
							 2=> 'username',
							 3=> 'email',
                             4=> 'phone',
                             5=> 'gender',
                             6=> 'birthday',
                             7=> 'id'
						 );

	$querycount = mysqli_query($db, "SELECT * from users");

	$totalData = mysqli_num_rows($querycount);
	  $totalFiltered = $totalData;

	  $limit = $_POST['length'];
	  $start = $_POST['start'];
	  $order = $columns[$_POST['order']['0']['column']];
	  $dir = $_POST['order']['0']['dir'];
		   
	  if(empty($_POST['search']['value']))
	  {   
          
        
		$query = mysqli_query($db, "SELECT * FROM users
				ORDER by $order $dir
				LIMIT $limit
				OFFSET $start");
	  }
	  else {
		  $search = $_POST['search']['value']; 
		  $query = mysqli_query($db, "SELECT * FROM users
				WHERE username LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%'  OR phone LIKE '%$search%' 
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
			 
              if($r['gender'] === 'P'){
                $gender = 'Female';
              } else {
                $gender = 'Male';  
              }
              $birthday = format_date($r['birthday']);

              
			  $nestedData['photo'] = $r['photo'];
			  $nestedData['name'] = $r['name'];
			  $nestedData['username'] = $r['username'];
			  $nestedData['email'] = $r['email'];
              $nestedData['phone'] = $r['phone'];
              $nestedData['gender'] = $gender;
              $nestedData['birthday'] = $birthday;
              $nestedData['id'] = $r['id'];
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