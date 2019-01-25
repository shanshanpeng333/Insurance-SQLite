<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Simple Database App</title>

<link href="./public/css/bootstrap.min.css" rel="stylesheet">
<link href="./public/Roboto/Roboto-Black.ttf" rel="stylesheet">
<link rel="stylesheet" href="./public/css/style.css">
<script type="text/javascript" src="./jquery/jquery-2.1.3.min.js"></script>

<script>
    $(document).ready(function() {
	$("#Developers").click(function(event) {
	    $.getJSON('result.json', function(jd) {
		$('#stage').html('<p> Developers: ' + jd.name1 +', '+ jd.name2 +', ' + jd.name3 +'</p>');
	    });
	});
    });
</script>

</head>

<body>
	<h1>Fred Cohen Company</h1>
	<h3><em><q>Leading Through Perspiration</q></em></h3>
</body>