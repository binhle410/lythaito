<!-- BEGIN: main -->
<ul id="{BLOCK_ID}">
	<!-- BEGIN: loop_album -->
	<li>
		<a class="images" href="{ALBUM.link}" title="{ALBUM.name}">
			<img src="{ALBUM.thumb}" alt="{ALBUM.name}" class="img-responsive"/>
		</a>
		<a href="{ALBUM.link}" title="{ALBUM.name}"><span><strong>{ALBUM.name}</strong></span></a>
		<p>{ALBUM.description}</p>
	</li>
	<!-- END: loop_album -->
</ul>
<!-- END: main -->