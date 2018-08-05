<?php
/**
 * The template for search result.
 *
 * @package WordPress
 * @subpackage ThemePile
 * @since Scriptor
 */
?>
<script type="text/html" id='site-search-result'>
	<div class="site-search-result">
		<ul class="site-search-result-list">
			<% if (items.not_found) { %>
				<li class="site-search-result-list-item">
					<div class="site-search-result-list-item-content">
						<%= items.not_found %>
					</div>
				</li>
			<% } else { %>
				<% _.each(items, function(item) { %>
					<li class="site-search-result-list-item">
						<header class="site-search-result-list-item-header">
							<h3><a href="<%= item.url %>"><%= item.title %></a></h3>
						</header>
						<div class="site-search-result-list-item-content">
							<%= item.content %>
						</div>
						<div class="entry-meta site-search-result-list-item-meta">
								<span class="entry-meta-item author vcard">
									<em class="entry-meta-item-label"><?php _e('by', THEMEPILE_LANGUAGE)?></em>
										<a rel="author" href="<%= item.author_url %>" class="url fn n">
											<span class="author-title"><%= item.author_display_name %></span>
										</a>
									</span><span class="entry-meta-item date">
									<em class="entry-meta-item-label"><?php _e('on', THEMEPILE_LANGUAGE)?></em>
									<a rel="bookmark" href="<%= item.url %>">
										<time datetime="<%= item.date %>" class="entry-date"><%= item.format_date %></time>
									</a>
								</span>
						</div>
					</li>
			<% }); %>
			<% } %>
		</ul><!-- .site-search-result-list -->
	</div><!-- .site-search-result -->
</script>