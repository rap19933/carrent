 $(document).ready(function() {
    $("li").on("click", function() { 
   		var id = $(this).attr("id");
    	document.cookie = "cookie_navbar=" + id;
    });
});