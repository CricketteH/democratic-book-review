window.onload = function(){
	$("apocalyptic").click(list("apocalyptic"));
	$(".genre-button").click(list);
	$(".book-div").click(show);
}

function list(){
	$.post("genreSearch.php", {genre: this.id}, 
		function(data){
			
		}
	);		
}

function show(){
	$.post("book.php", {title: this.id},
		
		function(data){
			
		}
	);
}
