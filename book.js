var data = <?php echo json_encode($wordArray)?>;
			
var options = {
	list : data, 
	weightFactor: 5, 
	rotateRatio: .5
}//options
			
WordCloud(document.getElementById('my_canvas'), options);