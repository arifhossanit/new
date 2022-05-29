<div class="content-wrapper">
	<iframe src="<?=base_url('assets/file_manager/index.php'); ?>" style="width:100%;border:none;" id="file_manager"></iframe> 
</div>
<script>
$('document').ready(function(){
	var content_height = $(".content-wrapper").height();
	$("#file_manager").height(content_height);
})
</script>