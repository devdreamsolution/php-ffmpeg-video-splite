<!DOCTYPE html>

<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="stylesheet" href="./src/css.css">

	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 25px; margin-bottom: 25px;">
			<div class="col-md-6">
				<h3>WE : DO</h3>
			</div>
			<div class="col-md-6" align="right">
				<h6>Description</h6>
			</div>
		
		<form method="POST" enctype="multipart/form-data" id="videoform" class="col-md-12">
			<div class="col-md-12" align="center">
				<video id="video" name="video" controls width="100%" autoplay>
					<source src="./src/devstories.mp4" type="video/webm">
				</video>
				<input type="hidden" value="devstories.mp4" name="filename" />
				<input type="hidden" value="0" id="curfrom" name="curfrom" />
				<input type="hidden" value="0" name="targetid" id="targetid" />
			</div>
		</form>
		<div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;" align="center">
			<button class="btn btn-danger" style="width: 100%; height: 45px;" onclick="addShow();">Add Event</button>
		</div>
		<div class="col-md-12" align="right" style="margin-bottom: 10px;">
			<button class="btn btn-success" onclick="exportTableToExcel('tblData', 'members-data')">Export</button>
		</div>
		
		<table id="tblData" class="table table-hover">
			<thead>
				<tr>
			        <th>ID</th>
			        <th>Time</th>
			        <th>Event</th>
			        <th>Reason</th>
			        <th>Action</th>
		    	</tr>
			</thead>
		    <tbody>

		    </tbody>
		</table>
		</div>
	</div>

	<!-- Add Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addModalLabel">Add Event</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="addEvent">Event</label>
						<input type="text" class="form-control" id="addEvent" placeholder="Enter event" name="addEvent">
					</div>
					<div class="form-group">
						<label for="addReason">Reason</label>
						<input type="text" class="form-control" id="addReason" placeholder="Enter reason" name="addReason">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="addRow();">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal -->


	<!-- edit Modal -->
	<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editModalLabel">Edit Event</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="editEvent">Event</label>
						<input type="text" class="form-control" id="editEvent" placeholder="Enter event" name="editEvent">
					</div>
					<div class="form-group">
						<label for="editReason">Reason</label>
						<input type="text" class="form-control" id="editReason" placeholder="Enter reason" name="editReason">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="editRow();">Save</button>
				</div>
			</div>
		</div>
	</div>
	<!-- end modal -->

	<script>
		var id = 1;
		var editID = '';
		var video = document.getElementById("video");



		function exportTableToExcel(tableID, filename = ''){
		    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
		    var textRange; var j=0;
		    tab = document.getElementById(tableID); // id of table
		    for(j = 0 ; j < tab.rows.length ; j++) 
		    {
		        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
		        //tab_text=tab_text+"</tr>";
		    }

		    tab_text=tab_text+"</table>";
		    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
		    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

		    var ua = window.navigator.userAgent;
		    var msie = ua.indexOf("MSIE "); 

		    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
		    {
		        txtArea1.document.open("txt/html","replace");
		        txtArea1.document.write(tab_text);
		        txtArea1.document.close();
		        txtArea1.focus(); 
		        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
		    }  
		    else                 //other browser not tested on IE 11
		        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

		    return (sa);
		}

		function addShow() {
			video.pause();
			$('#addEvent').val('');
			$('#addReason').val('');
			$("#addModal").modal('show');
		}

		function addRow() {
			var event = $('#addEvent').val();
			var reason = $('#addReason').val();
			if(event == '')
			{
				$('#addEvent').focus();
				return false;
			} else if(reason == '')
			{
				$('#addReason').focus();
				return false;
			}

			var curTime = video.currentTime;
			$('#curfrom').val(curTime);
			$("#targetid").val(id);
			///Ajax submit
			$.post('process.php', $('#videoform').serialize(), function(res)
			{
				if(res != "")
				{
					var myHtmlContent = "<td>"+ id +"</td><td>"+ curTime +"</td><td>"+ event +"</td><td>"+ reason +"</td><td><a href='#' onclick='editShow("+ id +");'>edit</a> / <a href='#' onclick='delRow(this);'>delete</a> / <a href='/video/"+res+"' download>download</a></td>";
					var tableRef = document.getElementById('tblData').getElementsByTagName('tbody')[0];

					var newRow   = tableRef.insertRow(tableRef.rows.length);
					newRow.innerHTML = myHtmlContent;
					newRow.id = id;
					
					$("#addModal").modal('hide');
					video.play();

					id ++;
				}

			});

		}

		function editShow(id) {
			var event = $("#"+id).find("td:eq(2)").text();
			var reason = $("#"+id).find("td:eq(3)").text();
			editID = id;

			$('#editEvent').val(event);
			$('#editReason').val(reason);

			$("#editModal").modal('show');
		}

		function editRow() {
			var event = $('#editEvent').val();
			var reason = $('#editReason').val();
			$("#"+editID).find("td:eq(2)").text(event);
			$("#"+editID).find("td:eq(3)").text(reason);

			$("#editModal").modal('hide');
		}

		function delRow(curRow) {
			$(curRow).parent().parent().remove();
		}
	</script>
</body>
</html>
