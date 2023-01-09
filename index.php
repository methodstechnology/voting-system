<?php // include 'includes/session.php'; ?>
<?php
	include 'includes/conn.php';
	// session_start();

	if(isset($_SESSION['voter'])){
		$sql = "SELECT * FROM voters WHERE id = '".$_SESSION['voter']."'";
		$query = $conn->query($sql);
		$voter = $query->fetch_assoc();
	}
	else{
	//	header('location: index.php');
		// exit();
	}

?>



<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar2.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content" style="background-color:#a28557;">
	      	<?php
	      		$parse = parse_ini_file('admin/config.ini', FALSE, INI_SCANNER_RAW);
    			$title = $parse['election_title'];
	      	?>
			<div class="text-center">
			<img src="images/rise.png" style="height: 60%; width: 60%;"/>
</div>
	      	<h3 class="page-header text-center "><b><?php echo strtoupper($title); ?></b></h3>
	        <div class="row">
	        	<div class="col-sm-10 col-sm-offset-1">
	        		<?php
				    /*     if(isset($_SESSION['error'])){
				        	?>
				        	<div class="alert alert-danger alert-dismissible">
				        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					        	<ul>
					        		<?php
					        			foreach($_SESSION['error'] as $error){
					        				echo "
					        					<li>".$error."</li>
					        				";
					        			}
					        		?>
					        	</ul>
					        </div>
				        	<?php
				         	unset($_SESSION['error']);

				        } */


				    /*     if(isset($_SESSION['success'])){
				          	echo "
				            	<div class='alert alert-success alert-dismissible'>
				              		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				              		<h4><i class='icon fa fa-check'></i> Success!</h4>
				              	".$_SESSION['success']."
				            	</div>
				          	";
				          	unset($_SESSION['success']);
				        } */
						if(isset($_POST['message'])){
$mess = $_POST['message'];
echo "message";
echo $mess;
						}
				    ?>
 
				    <div class="alert alert-danger alert-dismissible" id="alert" style="display:none;">
		        		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			        	<span class="message"></span>
				
			        </div>
					<div class="text-center">
					<?php
if(isset($_GET['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
             <a href='index.php'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> </a>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_GET['success']."
            </div>
          ";
         unset($_GET['success']);
        }
?>
		<?php
if(isset($_GET['failed'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
             <a href='index.php'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> </a>
              <h4><i class='icon fa '>&times;</i> Failed!</h4>
              ".$_GET['failed']."
            </div>
          ";
         unset($_GET['success']);
        }
?>
					<a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>Add a Vote</a>
					<a href="#addnew5" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>Add 5 Vote</a>
					<a href="#addnew10" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>Add 10 Vote</a>
						</div> <?php

				    	//$sql = "SELECT * FROM votes WHERE voters_id = '".$voter['id']."'";
						$sql = "SELECT * FROM `candidates`";
				    	$vquery = $conn->query($sql);
				    	if($vquery->num_rows < 1){
				    		?>
				    		<div class="text-center">
					    		<h3>No Contestants</h3>
					    		<!-- <a href="#view" data-toggle="modal" class="btn btn-flat btn-primary btn-lg">View Ballot</a> -->
					    	</div>
				    		<?php
				    	}

				    	else{
				    		?>
			    			<!-- Voting Ballot -->
						    <form method="POST" id="ballotForm" action="submit_ballot.php">
				        		<?php
				        			include 'includes/slugify.php';

				        			$candidate = '';
				        			$sql = "SELECT * FROM positions ORDER BY priority ASC";
									$query = $conn->query($sql);
									while($row = $query->fetch_assoc()){
										$sql = "SELECT * FROM candidates WHERE position_id='".$row['id']."' ORDER BY votes DESC";
										$cquery = $conn->query($sql);
										while($crow = $cquery->fetch_assoc()){
											$slug = slugify($row['description']);
											$checked = '';
											if(isset($_SESSION['post'][$slug])){
												$value = $_SESSION['post'][$slug];

												if(is_array($value)){
													foreach($value as $val){
														if($val == $crow['id']){
															$checked = 'checked';
														}
													}
												}
												else{
													if($value == $crow['id']){
														$checked = 'checked';
													}
												}
											}
											$input = ($row['max_vote'] > 1) ? '<input type="checkbox" class="flat-red '.$slug.'" name="'.$slug."[]".'" value="'.$crow['id'].'" '.$checked.'>' : '<input type="radio" class="flat-red '.$slug.'" name="'.slugify($row['description']).'" value="'.$crow['id'].'" '.$checked.'>';
											$image = (!empty($crow['photo'])) ? 'images/'.$crow['photo'] : 'images/profile.jpg';
											$candidate .= '
												<div style="box-shadow: 0 1px 1px rgba(0,0,0,0.1);border-top-left-radius: 0;"><li style="font-size: 115%; font-weight: 900;">
												 '.$crow['votes'].' Votes	<button type="button" class="btn btn-primary btn-sm btn-flat clist platform" data-platform="<h1>Voting ID For '.$crow['firstname'].' is '.$crow['id'].'</h1>" data-fullname="'.$crow['firstname'].' '.$crow['lastname'].'"><i class="fa fa-search"></i> View ID</button><img style="border-top-right-radius: 0;
												 border-bottom-right-radius: 3px;
												 border-bottom-left-radius: 3px;" src="'.$image.'" height="100px" width="100px" class="clist"><span class="cname clist">'.$crow['firstname'].' '.$crow['lastname'].'</span>
												</li></div>
											';
										}

										$instruct = ($row['max_vote'] > 1) ? 'You may vote upto '.$row['max_vote'].' times' : 'Select only one candidate';

										echo '
											<div class="row">
												<div class="col-xs-12">
													<div style="background-color:rgb(234,224,200);" class="box box-solid" id="'.$row['id'].'">
														<div class="box-header with-border">
															<h3 class="box-title"><b>'.$row['description'].'</b></h3>
														</div>
														<div class="box-body">
															<p>'.$instruct.'
																<span class="pull-right">
																	<a href="index.php"><button type="button" class="btn btn-success btn-sm btn-flat reset" ><i class="fa fa-refresh"></i> Refresh</button></a>
																</span>
															</p>
															<div id="candidate_list">
																<ul>
																	'.$candidate.'
																</ul>
															</div>
														</div>
													</div>
												</div>
											</div>
										';

										$candidate = '';

									}	

				        		?>
				        		<div class="text-center">
								<a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>Add a Vote</a>
					<a href="#addnew5" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>Add 5 Vote</a>
					<a href="#addnew10" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i>Add 10 Vote</a>
					
					        		
					        	</div>
				        	</form>
				        	<!-- End Voting Ballot -->
				    		<?php
				    	}

				    ?>

	        	</div>
	        </div>
	      </section>
		  
	     
	    </div>
	  </div>
	  <?php include 'includes/positions_modal.php'; ?>
  	<?php include 'includes/footer.php'; ?>
  	<?php include 'includes/ballot_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
	$('.content').iCheck({
		checkboxClass: 'icheckbox_flat-green',
		radioClass: 'iradio_flat-green'
	});

	$(document).on('click', '.reset', function(e){
	    e.preventDefault();
	    var desc = $(this).data('desc');
	    $('.'+desc).iCheck('uncheck');
	});

	$(document).on('click', '.platform', function(e){
		e.preventDefault();
		$('#platform').modal('show');
		var platform = $(this).data('platform');
		var fullname = $(this).data('fullname');
		$('.candidate').html(fullname);
		$('#plat_view').html(platform);
	});

	$('#preview').click(function(e){
		e.preventDefault();
		var form = $('#ballotForm').serialize();
		if(form == ''){
			$('.message').html('You must vote atleast one candidate');
			$('#alert').show();
		}
		else{
			$.ajax({
				type: 'POST',
				url: 'preview.php',
				data: form,
				dataType: 'json',
				success: function(response){
					if(response.error){
						var errmsg = '';
						var messages = response.message;
						for (i in messages) {
							errmsg += messages[i]; 
						}
						$('.message').html(errmsg);
						$('#alert').show();
					}
					else{
						$('#preview_modal').modal('show');
						$('#preview_body').html(response.list);
					}
				}
			});
		}
		
	});

});
</script>
<?php
/*  $a = 250;
$b = 0;
echo "INSERT INTO `1_voting_code` (`id`, `code`) VALUES";
while ($b != $a){
	$str = rand(2,7);
	$ran=($str);

	$code = "100".$ran."".(rand(9999999, 99999999) . "<br>");
	echo "(NULL, '".$code."'),";
	$b = $b + 1;
}  */ 
?>
</body>
</html>
