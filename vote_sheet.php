

<?php include('db_connect.php');?>
<?php
	$voting = $conn->query("SELECT * FROM voting_list where  is_default = 1 ");
	foreach ($voting->fetch_array() as $key => $value) {
		$$key = $value;
	}

	$vchk = $conn->query("SELECT distinct(voting_id) from votes where user_id = ".$_SESSION['login_id']."")->num_rows;
	if($vchk > 0){
		header('Location:voting.php?page=view_vote');
	}

	$vote = $conn->query("SELECT * FROM voting_list where id=".$id);
	foreach ($vote->fetch_array() as $key => $value) {
		$$key= $value;
	}
	$opts = $conn->query("SELECT * FROM voting_opt where voting_id=".$id);
	$opt_arr = array();
	$set_arr = array();

	while($row=$opts->fetch_assoc()){
		$opt_arr[$row['category_id']][] = $row;
		$set_arr[$row['category_id']] = array('id'=>'','max_selection'=>1);

	}

	$settings = $conn->query("SELECT * FROM voting_cat_settings where voting_id=".$id);
	while($row=$settings->fetch_assoc()){
		$set_arr[$row['category_id']] = $row;
	}

?>
<style>
	.candidate {
	    margin: 8px;
	    width: 20vw;
	    padding: 0px;
	    cursor: pointer;
	    /* border-radius: 3px; */
	    margin-bottom: 2px;
	}
	.candidate:hover {
	    background-color: rgb(0,123,255);
	    box-shadow: 2.5px 3px #00000063;
	}
	.candidate img {
	    height: 22vh;
	    width: 20vw;
	    margin-top: 1px;
		margin-bottom: 1px;
    	margin-left: 1px;
    	margin-right: 1px;

	}
	span.rem_btn {
	    position: absolute;
	    right: -0.1;
	    /* top: -1em; */
	    z-index: 10;
	    display: none
		
	}
	span.rem_btn.active{
		display: block
	}

	/* First Break to 3 */

	@media screen and (max-width: 910px) {
		.candidate {
	    margin: 3px;
	    width: 25vw;
	    padding: 1px;
	    cursor: pointer;
	    /* border-radius: 3px; */
	    margin-bottom: 2px;
	}
	
	.candidate img {
	    height: 25vh;
	    width: 24vw;
	    margin-top: 2px;
		margin-bottom: 2px;
    	margin-left: 1px;
    	margin-right: 1px;

	}
	span.rem_btn {
	    position: absolute;
	    right: -0.1;
	    /* top: -1em; */
	    z-index: 10;
	    display: none
		
	}
	span.rem_btn.active{
		display: block
	}

	}
	/* Second Break to 2 */

	@media screen and (max-width: 600px) {
		.candidate {
	    margin: 7px;
	    width: 29vw;
	    padding:0px;
	    cursor: pointer;
	    /* border-radius: 3px; */
	    margin-bottom: 2px;
	}
	
	.candidate img {
	    height: 28vh;
	    width: 28vw;
	    margin-top: 1px;
		margin-bottom: 1px;
    	margin-left: 2px;
    	margin-right: 2px;

	}
	span.rem_btn {
	    position: absolute;
	    right: -0.1;
	    /* top: -1em; */
	    z-index: 10;
	    display: none
		
	}
	span.rem_btn.active{
		display: block
	}

	}

</style>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form action="" id="manage-vote">
					<input type="hidden" name="voting_id" value="<?php echo $id ?>">
				<div class="col-lg-12">
					<div class="text-center">
						<h3><b><?php echo $title ?></b></h3>
						<small><b><?php echo $description; ?></b></small>	
					</div>
					
					<?php 
					$cats = $conn->query("SELECT * FROM category_list where id in (SELECT category_id from voting_opt where voting_id = '".$id."' )");
					while($row = $cats->fetch_assoc()):
					?>
						<hr>
						<div class="row mb-4">
							<div class="col-md-12">
									<div class="text-center">
										<h3><b><?php echo $row['category'] ?></b></h3>
									<large>Max Selection : <b><?php echo $set_arr[$row['id']]['max_selection']; ?></b></large>

									</div>
							</div>
						</div>
						<div class="row mt-3">
						<?php foreach ($opt_arr[$row['id']] as $candidate) {
						?>
							<div class="candidate" style="position: relative;" data-cid = '<?php echo $row['id'] ?>'  data-max="<?php echo $set_arr[$row['id']]['max_selection'] ?>" data-name="<?php echo $row['category'] ?>">
									<input type="checkbox" name="opt_id[<?php echo $row['id'] ?>][]" value="<?php echo $candidate['id'] ?>" style="display: none">
								<span class="rem_btn">
									<label for="" class="btn btn-primary"><span class="fa fa-check"></span></label>
								</span>
								<div class="item"  data-id="<?php echo $candidate['id'] ?>">
								<div style="display: flex">
									<img src="assets/img/<?php echo $candidate['image_path'] ?>" alt="">
								</div>
								<br>
								<div class="text-center">
									<small class="text-center"><b><?php echo ucwords($candidate['opt_txt']) ?></b></small>

								</div>
								</div>
							</div>
						<?php } ?>
						</div>
					<?php endwhile; ?>
				</div>
				<hr>
				<button class="btn-block btn-primary">Sumbit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$('.candidate').click(function(){
		var chk = $(this).find('input[type="checkbox"]').prop("checked");
		
		if(chk == true){
			$(this).find('input[type="checkbox"]').prop("checked",false)
		}else{
			var arr_chk = $("input[name='opt_id["+$(this).attr('data-cid')+"][]']:checked").length
			if($(this).attr('data-max') == 1){
			$("input[name='opt_id["+$(this).attr('data-cid')+"][]']").prop("checked",false)
			$(this).find('input[type="checkbox"]').prop("checked",true)
			}else{
			if(arr_chk >= $(this).attr('data-max')){
					alert_toast("Choose only "+$(this).attr('data-max')+" for "+$(this).attr('data-name')+" category","warning")
					return false;
				}
			}
			$(this).find('input[type="checkbox"]').prop("checked",true)
		}
		$('.candidate').each(function(){
			if($(this).find('input[type="checkbox"]').prop("checked") == true){
				$(this).find('.rem_btn').addClass('active')
			}else{
				$(this).find('.rem_btn').removeClass('active')
			}
		})
		
	})
	$('#manage-vote').submit(function(e){
		e.preventDefault()
		start_load();
		$.ajax({
			url:'ajax.php?action=submit_vote',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Vote success fully submitted");
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>