let next = document.querySelector(".next");
let prev = document.querySelector(".prev");
let slider = document.querySelector(".slider");

next.addEventListener("click", function () {
	let slide = document.querySelectorAll(".slide");
	slider.appendChild(slide[0]);
});

prev.addEventListener("click", function () {
	let slide = document.querySelectorAll(".slide");
	slider.prepend(slide[slide.length - 1]);
});
/