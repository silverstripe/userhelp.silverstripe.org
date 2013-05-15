<div id="sidebar">
	<% if Menu(2) %>	
		<ul id="sub-navigation">
			<% loop Menu(2) %>
				<li class="$LinkingMode">
					<a href="$Link">$MenuTitle</a>
					
					<% if LinkOrSection = section %>
						<% if Children %>
							<ul>
								<% loop Children %>
									<li class="$LinkingMode">
										<a href="$Link">$MenuTitle</a>
										
										
										<% if LinkOrSection = section %>
											<% if Children %>
												<ul>
													<% loop Children %>
														<li class="$LinkingMode">
															<a href="$Link">$MenuTitle</a>
														</li>
													<% end_loop %>
												</ul>
											<% end_if %>
										<% end_if %>
									</li>	
								<% end_loop %>
							</ul>
						<% end_if %>
					<% end_if %>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
</div>