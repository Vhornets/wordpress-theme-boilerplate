<ul class="sidebar">
	<li>
		Sidebar
	</li>	

	<?php if(!dynamic_sidebar('sidebar-main')): ?>
			<!-- Контент при отсутствии сайдбара -->
	<?php endif; ?>
</ul>