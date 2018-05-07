$(document).ready(function() {
	$("#ctgForm").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type : "POST",
			url : "saveCtg.php",
			data : $("#ctgForm").serialize(),
			beforeSend : function() {
			  //$(".post_submitting").show().html("<center><img src='images/loading.gif'/></center>");
			},
			success : function(response) {
				alert(response);
			}
		});
		e.preventDefault();
	});
	$("#voteForm").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type : "POST",
			url : "saveVote.php",
			data : $("#voteForm").serialize(),
			beforeSend : function() {
			  //$(".post_submitting").show().html("<center><img src='images/loading.gif'/></center>");
			},
			success : function(response) {
				$("#tmpDis").html(response);
			}
		});
		e.preventDefault();
	});
});