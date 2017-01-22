
/* menu in mobile mode */
var collapse_icon = document.getElementById("collapse_icon");
var side_nav = document.getElementById("side_nav");
collapse_icon.addEventListener("click",function(){
	
	var left = side_nav.style.left;
	if(left == "0px"){
		side_nav.style.transition = "left 0s";
		side_nav.style.left = "-300px";
	}
	else{
		side_nav.style.transition = "left 1s";
		var scrollTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
		scrollTop +="px";
		side_nav.style.left = "0px";
		side_nav.style.top = scrollTop;
	}
});

/* when clicking on the aside menu items --> close the menu */

var aside_menu_items  = document.querySelectorAll(".side_nav li");
aside_menu_items.forEach(function(item){
	item.addEventListener("click", function(){
		side_nav.style.transition = "left 0s";
		side_nav.style.left = "-300px";
	});
});

//google map
function myMap() {
  var myCenter= new google.maps.LatLng(-37.810503, 144.963572);	
  var mapCanvas = document.getElementById("map");
  var mapOptions = {
    center: myCenter, 
    zoom: 12
  }
  var map = new google.maps.Map(mapCanvas, mapOptions);
  var marker = new google.maps.Marker({position:myCenter});
  marker.setMap(map);
}
