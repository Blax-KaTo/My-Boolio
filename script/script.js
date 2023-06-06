
//______________________________________Variables__________________________________________//

// var toolTipBtn = document.querySelector("#tooltip-btn");
var toolTipBtn = document.querySelector("#tooltip-btn");
var pannel = document.querySelector(".bg-pannel");
var cancelBtn = document.querySelector("#cancel-btn");
// var searchBtn = document.querySelector("#search-btn");
// var searchBackBtn = document.querySelector("#search-back-btn");
// var searchCancelBtn = document.querySelector("#search-cancel-btn");
var popUpSearch = document.querySelector(".pop-up_search");
var popUp = document.querySelector(".pop-up");
// var cartBtn = document.querySelector("#cart-btn");
var accountBtn = document.querySelector("#account-btn");

//____________________________________Event Listeners______________________________________//

toolTipBtn.addEventListener("click", function()
{
	pannel.style.display = "block";
	cancelBtn.addEventListener("click", function()
	{
		pannel.style.display = "none";
	});

	// searchBtn.addEventListener("click", function() {
	// 	popUp.style.display = "none";
	// 	popUpSearch.style.display = "block";

	// 	searchBackBtn.addEventListener("click", function()
	// 	{
	// 		popUpSearch.style.display = "none";
	// 		popUp.style.display = "block";
	// 	});

	// 	searchCancelBtn.addEventListener("click", function()
	// 	{
	// 		popUp.style.display = "block";
	// 		popUpSearch.style.display = "none";
	// 		pannel.style.display = "none";
	// 	});
	// })

	accountBtn.addEventListener("click", function()
	{
		window.location = "account.php";
	});
});
