var js = {};
! function(n) {
	n(document).on("click", ".s-acitve", function() {
		var e = n(this).parents(".se-c"),
		s = e.find(".episodes-desactive"),
		o = e.find(".se-t");
		s.slideToggle(200), o.hasClass("se-o") ? o.removeClass("se-o") : o.addClass("se-o")
	})
}(jQuery);