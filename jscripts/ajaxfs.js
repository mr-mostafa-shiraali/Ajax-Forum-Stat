 var fsXHR = false; 
 var tuXHR = false;

      if (window.XMLHttpRequest) {
        fsXHR = new XMLHttpRequest();
		tuXHR = new XMLHttpRequest();
      } else if (window.ActiveXObject) {
        fsXHR = new ActiveXObject("Microsoft.XMLHTTP");
		tuXHR = new ActiveXObject("Microsoft.XMLHTTP");
      }


$(function() {$( "#tabs" ).tabs();});
    $(function() {
        $( "#userrules" ).accordion();
    });






//tooltip
function tooltip(e)
{

		x = 20;
		y = 10;	
  x=e.currentTarget;
   pid=x.id;		
		$("#userrules").append("<div  id='tooltip'></div>");
		document.getElementById('tooltip').style.left = (e.pageX + x)+'px' ;
		document.getElementById('tooltip').style.top = (e.pageY - y)+'px';
		var act="tooltip";
    var request = $.ajax({
        url: "xmlhttp.php",
        type: "POST",
        data: {
		action:act,
            pid: pid
        },
        dataType: "html"
    });
    request.done(function(msg) {
		document.getElementById('tooltip').innerHTML=msg;
    });
			$("#tooltip").fadeIn("fast");		

}
function tooltipmove(e)
{

		x = 20;
		y = 10;		
		
		document.getElementById('tooltip').style.left = (e.pageX + x)+'px' ;
		document.getElementById('tooltip').style.top = (e.pageY - y)+'px';
	

}

function tooltipout()
{

	$("#tooltip").remove();
}

//usertooltip
function usertooltip(e)
{

  x=e.currentTarget;
  uid=x.id;
		x = 300;
		y = 10;		
		$("#userrules").append("<div  id='usertooltip'></div>");
		document.getElementById('usertooltip').style.left = (e.pageX - x)+'px' ;
		document.getElementById('usertooltip').style.top = (e.pageY - y)+'px';
			var act="usertooltip";
		    var request = $.ajax({
        url: "xmlhttp.php",
        type: "POST",
        data: {
		action:act,
            uid: uid
        },
        dataType: "html"
    });
    request.done(function(msg) {
	document.getElementById('usertooltip').innerHTML=msg;
    });
			$("#usertooltip").fadeIn("fast");		

}
function usertooltipmove(e)
{
		x = 300;
		y = 10;		
		
		document.getElementById('usertooltip').style.left = (e.pageX - x)+'px' ;
		document.getElementById('usertooltip').style.top = (e.pageY - y)+'px';
	

}

function usertooltipout()
{

	$("#usertooltip").remove();
}
/************************************************* Refresh Last Post*******************************/
$(function() {$("#ajfs_ref_posts").click(function() {
var opts = {
  lines: 17, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#000', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: '50%', // Top position relative to parent
  left: '50%' // Left position relative to parent
};
var target = document.getElementById('spin');
var spinner = new Spinner(opts).spin(target);
var act="ajxfs_lastpost";
		    var request = $.ajax({
        url: "xmlhttp.php",
        type: "POST",
        data: {
		action:act       
		},
        dataType: "html"
    });
    request.done(function(msg) {
			document.getElementById('lastpost').innerHTML=msg;
		spinner.stop();

    });
	   });

});
/************************************************* Refresh Last Tops*******************************/

$(function() {$("#ajfs_ref_top").click(function() {
var opts = {
  lines: 17, // The number of lines to draw
  length: 20, // The length of each line
  width: 10, // The line thickness
  radius: 30, // The radius of the inner circle
  corners: 1, // Corner roundness (0..1)
  rotate: 0, // The rotation offset
  direction: 1, // 1: clockwise, -1: counterclockwise
  color: '#000', // #rgb or #rrggbb or array of colors
  speed: 1, // Rounds per second
  trail: 60, // Afterglow percentage
  shadow: false, // Whether to render a shadow
  hwaccel: false, // Whether to use hardware acceleration
  className: 'spinner', // The CSS class to assign to the spinner
  zIndex: 2e9, // The z-index (defaults to 2000000000)
  top: '50%', // Top position relative to parent
  left: '50%' // Left position relative to parent
};
var target = document.getElementById('spin');
var spinner = new Spinner(opts).spin(target);
var act="ajxfs_Tops_lastuser";
		    var request = $.ajax({
        url: "xmlhttp.php",
        type: "POST",
        data: {
            action:act      
        },
        dataType: "html"
    });
    request.done(function(msg) {
		document.getElementById('info_lastuser').innerHTML=msg;
		spinner.stop();

    });
});});

function ajfs_ref_top_tooltip(e) {
		x = 120;
		y = -20;	
   x=e.currentTarget;
   text=x.alt;
		$("#userrules").append("<div id=\"ajfs_ref_top_tooltip\"><span>"+text+"</span></div>");
		document.getElementById('ajfs_ref_top_tooltip').style.left = (e.pageX + x)+'px' ;
		document.getElementById('ajfs_ref_top_tooltip').style.top = (e.pageY - y)+'px';
			$("#ajfs_ref_top_tooltip").fadeIn("fast");
}
function ajfs_ref_top_tooltip_out() {
$("#ajfs_ref_top_tooltip").remove();
}
function ajfs_ref_top_tooltip_move(e)
{
		x = 120;
		y = -20;		
		
		document.getElementById('ajfs_ref_top_tooltip').style.left = (e.pageX - x)+'px' ;
		document.getElementById('ajfs_ref_top_tooltip').style.top = (e.pageY - y)+'px';
	

}
function ajfs_ref_post_tooltip(e,text) {
		x = 120;
		y = -20;	
  x=e.currentTarget;
   text=x.alt;
		$("#userrules").append("<div id=\"ajfs_ref_post_tooltip\"><span>"+text+"</span></div>");
		document.getElementById('ajfs_ref_post_tooltip').style.left = (e.pageX + x)+'px' ;
		document.getElementById('ajfs_ref_post_tooltip').style.top = (e.pageY - y)+'px';
			$("#ajfs_ref_post_tooltip").fadeIn("fast");
}
function ajfs_ref_post_tooltip_out() {
$("#ajfs_ref_post_tooltip").remove();
}
function ajfs_ref_post_tooltip_move(e)
{
		x = 120;
		y = -20;		
		
		document.getElementById('ajfs_ref_post_tooltip').style.left = (e.pageX - x)+'px' ;
		document.getElementById('ajfs_ref_post_tooltip').style.top = (e.pageY - y)+'px';
	

}



