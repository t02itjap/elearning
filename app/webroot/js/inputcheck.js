(function(exports) {
       	function valOrFunction(val, ctx, args) {
               	if (typeof val == "function") {
                       	return val.apply(ctx, args);
               	} else {
                       	return val;
               	}
       	}
       	function InvalidInputHelper(input, options) {

               	input.addEventListener("input", function(evt) {
                       	if (evt.target.value == "") {
                               	evt.target.setCustomValidity(valOrFunction(options.emptyText,
                                               	window, [ input ]));
                       	} else {
                               	evt.target.setCustomValidity("");
                       	}
               	});

       	}
       	exports.InvalidInputHelper = InvalidInputHelper;
})(window);
