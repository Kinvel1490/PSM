document.addEventListener('DOMContentLoaded', function(){
	
	let y = document.querySelector("#qty-pak");							// Поле упаковок
	let x = document.querySelector("form.cart .quantity input.qty");	// Поле количества товара
	
	let price = document.querySelector(".wpcr-price");					// Цена товара 1 единицы
	let sumPrice = document.querySelector(".wpcr-sum-price");			// Общая цена упаковок
	
	function updateSumPrice (){						// Обновить Общая цену
		sumPrice.innerHTML = ( x.value * price.innerHTML ).toFixed(2);
	}
	
	updateSumPrice();
 
	// При изменении упаковок (y) изменить количество товара (x)
	function upgradeXbyY(){
 
		x.value = (y.value * x.step).toFixed(2);
		
		let event = new Event('change');	// обновить поле количества товара событием 'change'
		x.dispatchEvent(event);
 
		updateSumPrice();
	}
 
	y.addEventListener('input', upgradeXbyY);
 
	// При изменении количество товара (x) изменить упаковки (y)
	function upgradeYbyX(){
		
		// Округляем в большую сторону упаковку, т.к. если в 1 упаковке 
		// 1,33м, то 1,34м это уже 2 упаковки (неполные)
		y.value = Math.ceil(x.value*1000 / x.step/1000); // */1000 из-за образования дробного хвоста в следствии деления
		updateSumPrice ();
	}
	
	x.addEventListener('input', upgradeYbyX);
});