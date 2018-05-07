$(".nav-item a").click(function(e) {
	e.preventDefault();
	$(".nav-item a").removeClass("active");
	$(this).addClass("active");
	$(".ml-sm-auto:visible").hide();
	$("#" + $(this).data("div")).show();
	
});

$("#mapsListDiv input:text").focusout(function() {
	$("#" + $(this).data("parant")).text($(this).val());
});

$("#mapsListDiv button").click(function() {
	$("#variant" + $(this).data("id") + "dis").remove();
	$("#variant" + $(this).data("id")).remove();
});

$("#AddVariant").click(function() {
	var mapCount = Number($("#variantCount").val());
	mapCount++;
	var newHTML = ''+
	'<a id="variant' + mapCount + 'dis" href="#variant' + mapCount + '" data-toggle="collapse" aria-expanded="false" aria-controls="variant' + mapCount + '" class="list-group-item">'+
	'    <div class="variantContent" id="displayNameTop' + mapCount + '">New Map</div>'+
	'    <div class="variantContent" id="typeNameTop' + mapCount + '">New Map</div>'+
	'    <div class="variantContent" id="commandsTop' + mapCount + '">0</div>'+
	'    <div class="variantContent" id="mapsTop' + mapCount + '">0</div>'+
	'</a>'+
	'<div class="container-fluid variantInfo collapse multi-collapse show" id="variant' + mapCount + '">'+
	'    <div class="row">'+
	'        <div class="col-xs-6 col-sm-6 col-md-6">'+
	'            <div class="form-group">'+
	'                <label for="displayName' + mapCount + '">Display Name (Listed on Screen)</label>'+
	'                <input type="text" data-parant="displayNameTop' + mapCount + '" name="displayName' + mapCount + '" id="displayName' + mapCount + '" class="form-control input-sm" value="" required>'+
	'            </div>'+
	'        </div>'+
	'        <div class="col-xs-6 col-sm-6 col-md-6">'+
	'            <div class="form-group">'+
	'                <label for="typeName ' + mapCount + '">Type Name (Name in files)</label>'+
	'                <input type="text" data-parant="typeNameTop' + mapCount + '" name="typeName' + mapCount + '" id="typeName' + mapCount + '" class="form-control input-sm" value="" required>'+
	'            </div>'+
	'        </div>'+
	'    </div>'+
	'    <div class="row">'+
	'        <div class="col-xs-6 col-sm-6 col-md-6">'+
	'            <div class="form-group">'+
	'                <label for="commands' + mapCount + '">Commands</label>'+
	'                <textarea class="form-control" data-parant="commandsTop' + mapCount + '" name="commands' + mapCount + '" id="commands' + mapCount + '" rows="5"></textarea>'+
	'            </div>'+
	'        </div>'+
	'        <div class="col-xs-6 col-sm-6 col-md-6">'+
	'            <div class="form-group">'+
	'                <label for="maps' + mapCount + '">Maps (Filename=Displayname)</label>'+
	'                <textarea class="form-control" data-parant="mapsTop' + mapCount + '" name="maps' + mapCount + '" id="maps' + mapCount + '" rows="5"></textarea>'+
	'            </div>'+
	'        </div>'+
	'    </div>'+
	'<button data-id="' + mapCount + '" type="button" class="btn btn-danger btn-lg btn-block">Delete</button>'+
	'</div>';
	$("#mapsListDiv").append(newHTML);
	$("#mapsListDiv button").click(function() {
		$("#variant" + $(this).data("id") + "dis").remove();
		$("#variant" + $(this).data("id")).remove();
	});
	$("#mapsListDiv input:text").focusout(function() {
		$("#" + $(this).data("parant")).text($(this).val());
	});
	$("#mapsListDiv textarea").focusout(function() {
		$("#" + $(this).data("parant")).text($(this).val().split("\n").length);
	});
	$("#displayName" + mapCount).focus();
	$("#variantCount").val(mapCount);
});

$("#mapsListDiv textarea").focusout(function() {
	$("#" + $(this).data("parant")).text($(this).val().split("\n").length);
});

$("#rconTabControl").click(function(e) {
	
	
});
function fixStyles() {
	var wasVisible = false;
	if (!$('#rconMain').is(":visible"))
		$('#rconMain').show();
	else
		wasVisible = true;
	$('#text-center').height("100%");
	$('#consoleContainer').height($('#rconMain').height() - 50).css({"top": "45px", "position": "relative"});
	$('#messageLog').height($('#consoleContainer').height() - $('#commandContainer').height());
	if (!wasVisible)
		$('#rconMain').hide();
}

$('.slider').slider({
	formatter: function(value) {
		return 'Current value: ' + value;
	}
});

$("#maxplayers").on("slide", function(slideEvt) {
	$("#ex6SliderVal").text(" " + slideEvt.value);
});

$("#votePerc").on("slide", function(slideEvt) {
	$("#votePercDis").text(" " + slideEvt.value + "%");
});

$("#votingTime").on("slide", function(slideEvt) {
	$("#maxVal").text(" " + slideEvt.value);
});

$("#revoteMax").on("slide", function(slideEvt) {
	$("#revoteAllowed").text(" " + slideEvt.value);
});

$("#votingOptions").on("slide", function(slideEvt) {
	$("#votingOptionCount").text(" " + slideEvt.value);
});

$("#vetoingTime").on("slide", function(slideEvt) {
	$("#vetoTime").text(" " + slideEvt.value);
});

$("#vetoAmt").on("slide", function(slideEvt) {
	$("#vetoAmtDis").text(" " + slideEvt.value);
});

$("#vetoTime").on("slide", function(slideEvt) {
	$("#vetoTimeDis").text(" " + slideEvt.value);
});

$("#vetoPerc").on("slide", function(slideEvt) {
	$("#vetoPercDis").text(" " + slideEvt.value + "%");
});

$("#maxplayers").on("click", function(slideEvt) {
	$("#ex6SliderVal").text(" " + slideEvt.value);
});

$("#votePerc").on("click", function(slideEvt) {
	$("#votePercDis").text(" " + slideEvt.value + "%");
});

$("#votingTime").on("click", function(slideEvt) {
	$("#maxVal").text(" " + slideEvt.value);
});

$("#revoteMax").on("click", function(slideEvt) {
	$("#revoteAllowed").text(" " + slideEvt.value);
});

$("#votingOptions").on("click", function(slideEvt) {
	$("#votingOptionCount").text(" " + slideEvt.value);
});

$("#vetoingTime").on("click", function(slideEvt) {
	$("#vetoTime").text(" " + slideEvt.value);
});

$("#vetoAmt").on("click", function(slideEvt) {
	$("#vetoAmtDis").text(" " + slideEvt.value);
});

$("#vetoTime").on("click", function(slideEvt) {
	$("#vetoTimeDis").text(" " + slideEvt.value);
});

$("#vetoPerc").on("click", function(slideEvt) {
	$("#vetoPercDis").text(" " + slideEvt.value + "%");
});
fixStyles();