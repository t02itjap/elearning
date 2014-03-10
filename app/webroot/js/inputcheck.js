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

//function addfile(){
//    var parenttbl = document.getElementById("1234");
//    var newel = document.createElement('td');
//    //var elementid = document.getElementsByTagName("td").length
//    //newel.setAttribute('id',elementid);
//    newel.innerHTML = "New Inserted"
//    parenttbl.appendChild(newel);
//}