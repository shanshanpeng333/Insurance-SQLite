<script>
    $(document).ready(function() {
	$("#Tcost").click(function(event) {
	   $.ajax({
		   success : function(data) {
		    $('#stage').html('<p> Total cost is: '+<?php echo escape($Totalcost["total"]); ?> +'</p>');
		}
	    });
	});
    });
</script>