//All CART FUNCTIONS

if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready)
} else {
    ready()
}

function ready() {	
	
	var removeCartItemButtons = document.getElementsByClassName('remove')
	for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i]
        button.addEventListener('click', removeCartItem)
    }
	
	var quantityInputs = document.getElementsByClassName('cart-quantity-input')
	for (var i = 0; i < quantityInputs.length; i++) {
		var input = quantityInputs[i]
		input.addEventListener('change' , quantityChanged)
	}
	
	var addToCartButtons = document.getElementsByClassName('item-button')
	for (var i = 0; i < addToCartButtons.length; i++) {
		var button = addToCartButtons[i]
		button.addEventListener('click' , addToCartClicked )
	
	}
	
	var showHidden = document.getElementsByClassName('show-hidden')
	for (var i = 0; i < showHidden.length; i++) {
		var button = showHidden[i]
		button.addEventListener('click' , showHiddenClicked)
	}
	
	var editCategoryBtns = document.getElementsByName('edit-ctg')
	for (var i = 0; i < editCategoryBtns.length; i++) {
        var button = editCategoryBtns[i]
        button.addEventListener('click', editCategory)
    }
	
	var editItemBtns = document.getElementsByName('edit-itm')
	for (var i = 0; i < editItemBtns.length; i++) {
        var button = editItemBtns[i]
        button.addEventListener('click', editItem)
    }
	

	
}


function removeCartItem(event) {
	var buttonClicked = event.target
	buttonClicked.parentElement.parentElement.remove()
	updateCartTotal()
}


function quantityChanged(event) {
	
	var input = event.target
	var x = input.value
	if (isNaN(input.value) || input.value <=0 || input.value > 5){
		input.value= 1
	}
	updateCartTotal()
}

function addToCartClicked(event) {
	
	var currentitems = document.getElementsByClassName('floatbtn')[0].innerText
	if ( currentitems == 0 ) 
	{
		openNav()
	}
	
	var button = event.target
	var shopItem = button.parentElement.parentElement
	var title = shopItem.getElementsByClassName('item-title')[0].innerText
	var price = shopItem.getElementsByClassName('item-price')[0].innerText.replace('Price:','')
	var ammount = shopItem.getElementsByClassName('item-ammount')[0].value
	
	if ( ammount < 1 || ammount > 5 ) {
		alert("Item quantity should be between 1-5!")
		shopItem.getElementsByClassName('item-ammount')[0].value = 1
		return
	}
	
	var imageSrc =  shopItem.getElementsByClassName('item-image')[0].src

	addItemToCart(title,price,ammount,imageSrc)
	updateCartTotal()
}
	
function addItemToCart(title , price , ammount, imageSrc){
	
	var cartRow = document.createElement('div')
	cartRow.classList.add('cart-row')
	var cartItems = document.getElementsByClassName('cart-items')[0]
	var cartItemNames = cartItems.getElementsByClassName('cart-item-title')
	
	for (var i = 0; i< cartItemNames.length; i++) {
		if (cartItemNames[i].innerText == title) {
			alert("This item is already added to the cart! \n You can change the ammount in the cart.")
			return
		}
	} 
	
	var cartRowContents = `
					<div class="cart-item cart-column">
                        <img class="cart-item-image" src="${imageSrc}" >
						<input type="text" name="order-item-photo[]" value="${imageSrc}" style="display:none">
                        <span class="cart-item-title" name="itemname" value="${title}">${title}</span>
						<input type="text" name="order-item-name[]" value="${title}" style="display:none">
                    </div>
                    <span class="cart-price cart-column">${price}</span>
					<input type="text" name="order-item-price[]" value="${price}" style="display:none"> 
                    <div class="cart-quantity cart-column">
                        <input class="cart-quantity-input" name="itemquantity" type="number" min="1" max="5" value="${ammount}">
						<input type="text" name="order-item-ammount[]" class="bought-item-ammoount" value="${ammount}" style="display:none">
                        <button class="remove" type="button">X</button>
                    </div>`
	cartRow.innerHTML = cartRowContents
	cartItems.append(cartRow)
	cartRow.getElementsByClassName('remove')[0].addEventListener('click',removeCartItem)
	cartRow.getElementsByClassName('cart-quantity-input')[0].addEventListener('change',quantityChanged)
	
}

	

function updateCartTotal() {
	var cartItemContainer = document.getElementsByClassName('cart-items')[0]
	var cartRows = cartItemContainer.getElementsByClassName('cart-row')
	var itemsInCart= 0 
	var total= 0
	for (var i = 0; i < cartRows.length; i++) {
		var cartRow =  cartRows[i]
		var priceElement =  cartRow.getElementsByClassName('cart-price')[0]
		var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]
		var quantityamm = cartRow.getElementsByClassName('cart-quantity-input')[0].value
		document.getElementsByClassName('bought-item-ammoount')[i].value = quantityamm
		var price = parseFloat(priceElement.innerText.replace('Price:',''))
		var quantity = quantityElement.value
		total = total + (price * quantity)	
		itemsInCart = itemsInCart + ( 1 * quantity )
	}
	total = (Math.round(total * 100) / 100).toFixed(2)
	document.getElementsByClassName('floatbtn')[0].innerText =  itemsInCart
	document.getElementsByClassName('floatbtn')[0].style.fontSize = "35px" ;
	
	document.getElementsByClassName('totalitemscart')[0].value =  itemsInCart;
		//This value is for passing total price in php
	
	if ( itemsInCart == 0 ) {
		document.getElementsByClassName('floatbtn')[0].innerHTML =  "<img src='cart.png' />" ;
	}
	
	document.getElementsByClassName('cart-total-price')[0].innerText =  total + '  \u20AC' ;
	document.getElementsByClassName('cart-total-price')[0].style.fontWeight = "700";
	document.getElementsByClassName('cart-total-price')[0].style.fontSize = "25px";
	document.getElementsByClassName('cart-total-price')[0].style.color = "#008B8B";
}
	
 

//------------------------------------------------------------------


//function to add random items in cart
function myRandom() {
	
	var myrandom=Math.round(Math.random()*5)
	var myrandom2=Math.round((Math.random()*4)+1)
	
	//var cartItems = document.getElementsByClassName('cart-items')[0]
	//var cartItemNames = cartItems.getElementsByClassName('cart-item-title')
	//var randomname = document.getElementsByClassName('item-title')[myrandom]
	
	
	//for (var i = 0; i< cartItemNames.length; i++) {
	//	if (cartItemNames[i].innerText == randomname.innerText) {
	//		myrandom=Math.round(Math.random()*5)
	//		i = 0;
	//	}
	//} 
	
	var randombtn = document.getElementsByClassName('item-button')[myrandom].id	
	var randomamm = document.getElementsByClassName('item-ammount')[myrandom].value = myrandom2
	
	var currentitems = document.getElementsByClassName('floatbtn')[0].innerText
	if ( currentitems == 0 ) 
	{
		openNav()
	}
	
	document.getElementById(document.getElementsByClassName('item-button')[myrandom].id).click();
	
	
	var randomamm = document.getElementsByClassName('item-ammount')[myrandom].value = 1 
	
}


//Functions for the sidebar
function openNav() {
  document.getElementById("mySidebar").style.width = "450px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
}

//functions for step 2
function openInformation() {
	
	var currentitems = document.getElementsByClassName('floatbtn')[0].innerText
	
	if ( currentitems > 0 ) {
		var x = document.getElementById("information");
		if (x.style.display === "none") {
			x.style.display = "block";
			disableCart()
			closeNav()
		}
	}else {
		alert("You haven't selected any items to purchase!")
	}
}


function disableCart() {
	
	var addToCartButtons = document.getElementsByClassName('item-button')
	
	for (var i = 0; i < addToCartButtons.length; i++) {
		document.getElementsByClassName('item-button')[i].disabled= true	
		document.getElementsByClassName('item-ammount')[i].disabled = true
		document.getElementsByClassName('item-ammount')[i].style.cursor = "default";
		document.getElementsByClassName('item-button')[i].style.cursor = "default";
	}
	
	
	var disbtn = document.getElementsByClassName('remove')
	for (var i = 0; i < disbtn.length; i++) {
        document.getElementsByClassName('remove')[i].disabled=true
        document.getElementsByClassName('cart-quantity-input')[i].disabled=true
		document.getElementsByClassName('remove')[i].style.cursor = "default";
		document.getElementsByClassName('cart-quantity-input')[i].style.cursor = "default";
    }
	
	document.getElementsByClassName('random-button')[0].disabled = true
	document.getElementsByClassName('random-button')[0].style.cursor = "default";
	
	document.getElementsByClassName('purchase')[0].style.cursor = "default";
	
	
}

function closeInformation() {
	var x = document.getElementById("information");
	if (x.style.display === "block") 
	{
		x.style.display = "none";
		enableCart()
		openNav()
    } 
}


function enableCart() {
	
	
	var addToCartButtons = document.getElementsByClassName('item-button')
	
	for (var i = 0; i < addToCartButtons.length; i++) {
		document.getElementsByClassName('item-button')[i].disabled= false
		document.getElementsByClassName('item-ammount')[i].disabled = false
		document.getElementsByClassName('item-ammount')[i].style.cursor = "pointer";
		document.getElementsByClassName('item-button')[i].style.cursor = "pointer";
	}
	
	
	var disbtn = document.getElementsByClassName('remove')
	for (var i = 0; i < disbtn.length; i++) {
        document.getElementsByClassName('remove')[i].disabled=false
        document.getElementsByClassName('cart-quantity-input')[i].disabled=false
		document.getElementsByClassName('remove')[i].style.cursor = "pointer";
		document.getElementsByClassName('cart-quantity-input')[i].style.cursor = "pointer";
    }
	
	document.getElementsByClassName('random-button').disabled = false
	document.getElementsByClassName('random-button')[0].style.cursor = "pointer";
	
	document.getElementsByClassName('purchase')[0].style.cursor = "pointer";
	
}

function validate() {
	
	var a = document.forms["Form"]["deliverypick"].value
	var b = document.forms["Form"]["firstname"].value
	var c = document.forms["Form"]["lastname"].value
	var d = document.forms["Form"]["address"].value
	var e = document.forms["Form"]["addnum"].value
	var f = document.forms["Form"]["zipcode"].value
	var len = f.length
	var g = document.forms["Form"]["region"].value
	var h = document.forms["Form"]["phonenum"].value
	var i = document.forms["Form"]["email"].value
	
	if ( a == "" || b == "" || c == "" || d == "" || e == "" || f == "" || g == "" || h == "" || i == ""){
		alert("Fill all boxes")
	}
	else{
		if (!/^[a-zA-Z]*$/g.test(b) || !/^[a-zA-Z]*$/g.test(c) || !/^[a-zA-Z]*$/g.test(d) || !/^[a-zA-Z]*$/g.test(g)) {
			alert("Invalid Input , you should use Characters only in some specific fields!");
		}
		else{
			if ( len == 5 ){
				
				deliveryPrice()
			}
			else{
				alert("ZIPCODE must be 5 numbers!");
			}
		}
	}
}

function deliveryPrice() {
	
	document.getElementsByClassName('previous')[0].disabled = true
	var info = document.getElementById("buyinformation");
	if (info.style.display === "none") {
		info.style.display = "block";
	}
	var x = document.getElementsByClassName('cart-total-price')[0].innerText
	var y = parseFloat(x)
	var k = document.getElementById('delivery').value
	if( y > 30 )
	{
		var l = document.getElementsByClassName('cart-total-price')[0].innerText
		var m = parseFloat(l)
		m = (Math.round(m * 100) / 100).toFixed(2)
		document.getElementsByClassName("finalprice")[0].innerText= "Total : " + m + '  \u20AC'
		document.getElementsByClassName('finalprice')[0].style.color = "#008B8B";
		document.getElementsByClassName('totalitemsprice')[0].value = m;
		return
	}
	else{
		
		if( k == "Home Delivery")
		{
			updateCart2()
			
		}
		else if(k == "Express Home Delivery")
		{
			updateCart3()
		}
		else{
			var l = document.getElementsByClassName('cart-total-price')[0].innerText
			var m = parseFloat(l)
			m = (Math.round(m * 100) / 100).toFixed(2)
			document.getElementsByClassName("finalprice")[0].innerText= "Total : " + m + '  \u20AC'
			document.getElementsByClassName('finalprice')[0].style.color = "blue";
			document.getElementsByClassName('totalitemsprice')[0].value = m;
		}
		
	}
}

function updateCart2()
{
	var x = document.getElementsByClassName('cart-total-price')[0].innerText
	var newtotal = parseFloat(x)
	newtotal = newtotal + 2
	newtotal = (Math.round(newtotal * 100) / 100).toFixed(2)
	document.getElementsByClassName('cart-total-price')[0].innerText =  newtotal  + '  \u20AC' ;
	
	document.getElementsByClassName("finalprice")[0].innerText= "Total: " + newtotal + '  \u20AC (+2euro delivery fee)'
	document.getElementsByClassName('finalprice')[0].style.color = "#blue";
	document.getElementsByClassName('totalitemsprice')[0].value = newtotal;
}

function updateCart3()
{
	var x = document.getElementsByClassName('cart-total-price')[0].innerText
	var newtotal = parseFloat(x)
	newtotal = newtotal + 6
	newtotal = (Math.round(newtotal * 100) / 100).toFixed(2)
	document.getElementsByClassName('cart-total-price')[0].innerText =  newtotal  + '  \u20AC' ;
	
	document.getElementsByClassName("finalprice")[0].innerText= "Total: " + newtotal + '  \u20AC (+6euro delivery fee)'
	document.getElementsByClassName('finalprice')[0].style.color = "blue";
	document.getElementsByClassName('totalitemsprice')[0].value = newtotal;
}
	

function closeInformation2() {
	var x = document.getElementById("buyinformation");
	document.getElementsByClassName('previous')[0].disabled = false
	if (x.style.display === "block") 
	{
		x.style.display = "none";
		enableInfo()
		
    } 
}


function enableInfo() {	
	
	//Remove delivery fees from total price
	var x = document.getElementsByClassName('cart-total-price')[0].innerText
	var y = parseFloat(x)
	var k = document.getElementById('delivery').value
	if( y > 30 )
	{
		return
	}
	else{
		
		if( k == "Home Delivery")
		{
			var x = document.getElementsByClassName('cart-total-price')[0].innerText
			var newtotal = parseFloat(x)
			newtotal = newtotal - 2
			newtotal = (Math.round(newtotal * 100) / 100).toFixed(2)
			document.getElementsByClassName('cart-total-price')[0].innerText =  newtotal  + '  \u20AC' ;
			
		}
		else if(k == "Express Home Delivery")
		{
			var x = document.getElementsByClassName('cart-total-price')[0].innerText
			var newtotal = parseFloat(x)
			newtotal = newtotal - 6
			newtotal = (Math.round(newtotal * 100) / 100).toFixed(2)
			document.getElementsByClassName('cart-total-price')[0].innerText =  newtotal  + '  \u20AC' ;
		}
		
	}
}


//function for showing credit card information
function credit() {
	var checkBox = document.getElementById("myCheck");
	var text = document.getElementById("text");
	text.style.display = checkBox.checked ? "block" : "none";
	if (text.style.display === "block") {
		document.getElementsByClassName("visa")[0].setAttribute("required","")
		document.getElementsByClassName("visa2")[0].setAttribute("required","")
		document.getElementsByClassName("visa3")[0].setAttribute("required","")
		document.getElementsByClassName("visa4")[0].setAttribute("required","")
		document.getElementsByClassName("visa5")[0].setAttribute("required","")
		document.getElementsByClassName("visa6")[0].setAttribute("required","")
		
	}
	else if (text.style.display === "none"){
		document.getElementsByClassName("visa")[0].removeAttribute("required")
		document.getElementsByClassName("visa2")[0].removeAttribute("required")
		document.getElementsByClassName("visa3")[0].removeAttribute("required")
		document.getElementsByClassName("visa4")[0].removeAttribute("required")
		document.getElementsByClassName("visa5")[0].removeAttribute("required")
		document.getElementsByClassName("visa6")[0].removeAttribute("required")
		
	}

}


//Shows hidden items in order history
function showHiddenClicked() {
	var button = event.target
	var hiddenItem = button.parentElement.parentElement.parentElement
	
	var item = hiddenItem.getElementsByClassName('hidden-items')[0]
	
	if (item.style.display === "none"){
		item.style.display = "block"
	}
	else{
		item.style.display = "none"
	}
	
}


function editCategory(event){
	var button = event.target
	var Category = button.parentElement.parentElement
	var categoryId = Category.getElementsByClassName('hidden-id')[0].value
	document.getElementsByName('edit-category-id')[0].value = categoryId
}

function editItem(event){
	var button = event.target
	var Item = button.parentElement.parentElement
	var itemId = Item.getElementsByClassName('hidden-item-id')[0].value
	document.getElementsByName('edit-item-id')[0].value = itemId
}






function popup(){
	var x = document.getElementById('edit-category')
	if ( x.style.display === "none") {
		
		x.style.display = "flex";
	
	}
	else{
		x.style.display = "none";
	}
}
function popup2(){
	var x = document.getElementById('edit-item')
	if ( x.style.display === "none") {
		
		x.style.display = "flex";
	}
	else{
		x.style.display = "none";
	}
}
function popup3(){
	var x = document.getElementById('admin-add-category')
	if ( x.style.display === "none") {
		
		x.style.display = "flex";
	}
	else{
		x.style.display = "none";
	}
}
function popup4(){
	var x = document.getElementById('admin-add-item')
	if ( x.style.display === "none") {
		
		x.style.display = "flex";
	}
	else{
		x.style.display = "none";
	}
}





