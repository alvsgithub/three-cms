<div id="content">
	<div id="innerContent">
		<h1>Dashboard</h1>
		<!--
			TODO: Add custom blocks based on content. For instance: Content=news, children=news items
		-->
		<?php
			/*				
				Dashboard functionality:
				
				The dashboard is to add functionality to the CMS to do specific actions quickly.
				For instance: If someone would like to add a news item, instead of creating a new content-object under 'news',
				this can be done instantly from within the dashboard.
				
				Cases:
				1) News items: A news page has different news items. These are children of the news page itself. The dashboard
				widget should show the latest news items, with options to add a new news item or to edit or delete the news
				items shown in the list.
				
				2) Blog: A blog has multiple posts. The posts are children of the blog. Users can react on blog posts. The
				reactions are children of the post. The dashboard widget should show the latest reactions in the blog and to
				which article the reactions are posted. Also, each reaction should have the options to delete or approve the reaction.		
				
				3) Statistics: A content type stores IP-addresses, date, and pagevisits to track site statistics. When a user
				enters a page, data is inserted or updated in the database according to the IP-address. The widget should show the
				total site visits, ordered distinctly by date.
				
				To work with the mentioned cases, dashboard widgets should have the following functionality:				
				
				- Which parent is used as container
				- Which template is used for a new item in this container
				- How many items are shown in this widget
				- Which options can be changed in the widget (for example: 'approved'-checkbox)
				- The level to retrieve content from (for example: the reactions on the blog posts -> blog->post->reaction = 2 levels, news->newsitem = 1 level)
				- The actions which are allowed (delete, modify, add)
				- How to order te results (default=id) (for statistics case)
				- Use distinct values when ordering? (for statistics case, only show a single date once)
				- When distinct, which options should be cummulicative (for statistics case, only show a single date once, but get the total of the hits)
			*/
			
			$left  = $dashboard['left'];
			$right = $dashboard['right'];
		?>
		<div id="dashboard">
			<div class="left">
				<?php
					foreach($left as $item) {
						include('item.php');
					}
				?>
			</div>
			<div class="right">
				<?php
					foreach($right as $item) {
						include('item.php');						
					}
				?>
			</div>
		</div>
	</div>
</div>