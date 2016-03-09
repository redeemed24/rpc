$(document).ready(function()
{

	//slides the element with class "menu_body" when paragraph with class "menu_head" is clicked 
	$("#modules p.menu_head").click(function()
        {
	   $(this).next("div.menu_body").slideToggle(100).siblings("div.menu_body").slideUp("fast");
            $(this).siblings();
	});
	
	//fadeout the validation
	setTimeout(function(){
        $("div.valid").fadeOut("slow", function () {
        $("div.valid").remove();
        });}, 3000);
	
	//backup message
	$("#backup").click(function(event) {
                alert("The Database is Succesfully Backup!");
            });
	
	
});
