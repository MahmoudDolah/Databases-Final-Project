<!DOCTYPE HTML>
<!--Mahindra Persaud-->
<?php 
	require("publicInfo.php");
?>
<html>
	<head>
		<title>Database Final</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">	
		<style>
			.interest{
				color:black;
			}
		</style>
    </head>
    <body>
        <!-- See occuring meetups all -->
		<div class="well">
			<div class="row">
				<div class="col-md-6">
					<?php 
						$result = viewMeetups();
						// Store data in variables, attach them to html objects
						while ($row = $result->fetch_assoc()) {
							echo "<ul class='list-group'>";
						    echo "<li class='list-group-item h3'>".$row["title"]."</li>";
							echo "<li class='list-group-item'>".$row["description"]."</li>";
							echo "<li class='list-group-item'>Starts at: ".$row["start_time"]."</li>";
							echo "<li class='list-group-item'>Ends at: ".$row["end_time"]."</li>";
							echo "<li class='list-group-item'>Zipcode: ".$row["zip"]."</li>";
							echo "</ul>";
						} 
					?>
				</div>
			<!-- Search for specific dates -->
			<div class="col-md-6">
				<div class="search input-group">
					<p class="h4">Enter dates in the form of DateTimes to search for ongoing events</p>
					<input type="text" name="start_time" class="form-control" placeholder="yyyy-mm-dd or yyyy-mm-dd hh-mm-ss">
					<input type="text" name="end_time" class="form-control" placeholder="yyyy-mm-dd or yyyy-mm-dd hh-mm-ss">
					<div class="input-group-btn"><input class="submit btn" type="submit"></div>
				</div>
				<div id="test"></div>
			</div>
		</div>
		<hr>
		<div class="row">
			<!-- display list of interests on left -->
			<div class="col-md-6">
				<div class="h3 text-center">Interests</div>
				<?php
					$result = viewInterests();
					echo "<ul class='list-group'>";
					while ($row = $result->fetch_assoc()) {
						echo "<li class='list-group-item btn-info btn interest'>".$row["interest_name"]."</li>";
					}
					echo "</ul>";
				 ?>
			</div>
			<div class="col-md-6">
				<div class="h3 text-center">Groups</h3>
				<ul class="groups list-group"></ul>
			</div>
		</div>
	
	
		<script type="text/javascript">
		$('.submit').click(function() {
			$.ajax({
				type: "POST",
				url: "publicInfo.php",
				data: { 
					start_time: $('input[name="start_time"]').val(), // "2017-04-30 00:00:00",
					end_time: $('input[name="end_time"]').val() // "2017-05-01 00:00:00"
				},
				success: function(data){
						data = JSON.parse(data);
						$('#test').empty();
						$('#test').append($('<p class="h3">Results</p>'));
						for(i = 0; i < data.length; i++){
							// create the lists
							var list = $("<ul class='list-group'>'");
							list.append("<li class='list-group-item h3'>" + data[i].title + "</li>");
							list.append("<li class='list-group-item'>" + data[i].description + "</li>");
							list.append("<li class='list-group-item'>" + data[i].start_time + "</li>");
							list.append("<li class='list-group-item'>" + data[i].end_time + "</li>");
							list.append("<li class='list-group-item'>" + data[i].zip + "</li>");
							list.append("</ul>");
							$('#test').append(list);
						}
				},
				error: function (xhr, ajaxOptions, thrownError) {
			        alert(xhr.status);
			        alert(thrownError);
			    }
			})
		});
		
		$('.interest').click(function(){
				var value = $(this).html();
				$.ajax({
					type: "POST",
					url: "publicInfo.php",
					data: {
						interest_name: value
					},
					success: function(data){
						data = JSON.parse(data);
						$('.groups').empty();
						alert(data);
						for(i = 0; i < data.length; i++){
							// create the lists
							var list = $(".groups");
							list.append("<li class='list-group-item h3'>" + data[i].group_name + "</li>");
							list.append("<li class='list-group-item'>" + data[i].description + "</li>");
							list.append(list);
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
				        alert(xhr.status);
				        alert(thrownError);
				    }
				});
		});
		</script>	
        
    </body>
</html>