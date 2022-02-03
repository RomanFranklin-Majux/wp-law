<div class="taxonomy-list">

	<?php if (!empty($taxonomies)): ?>
		<?php foreach($taxonomies as $taxonomy): ?>
			<?php if ($taxonomy->parent == 0): ?>

				<div id="taxonomy-<?php echo $taxonomy->cat_ID ?>" class="taxonomy-item">
					
					<a class="name" href="<?php echo get_term_link($taxonomy) ?>">
						<?php if($show_count && $before): ?>
							 (<?php echo $taxonomy->count ?>)
						<?php endif; ?>
						<?php echo $taxonomy->name ?>
						<?php if($show_count && !$before): ?>
							 (<?php echo $taxonomy->count ?>)
						<?php endif; ?>
					</a>

					<div class="children">
						
						
						<?php foreach($taxonomies as $taxonomy_2): ?>
							<?php if ($taxonomy_2->parent == $taxonomy->term_id): ?>

								<div id="taxonomy-<?php echo $taxonomy_2->cat_ID ?>" class="taxonomy-item">
									
									<a class="name" href="<?php echo get_term_link($taxonomy_2) ?>">
										<?php if($show_count && $before): ?>
											(<?php echo $taxonomy_2->count ?>)
										<?php endif; ?>
										<?php echo $taxonomy_2->name ?>
										<?php if($show_count && !$before): ?>
											(<?php echo $taxonomy_2->count ?>)
										<?php endif; ?>
									</a>

									<div class="children">


										<?php foreach($taxonomies as $taxonomy_3): ?>
											<?php if ($taxonomy_3->parent == $taxonomy_2->term_id): ?>

												<div id="taxonomy-<?php echo $taxonomy_3->cat_ID ?>" class="taxonomy-item">
													
													<a class="name" href="<?php echo get_term_link($taxonomy_3) ?>">
														<?php if($show_count && $before): ?>
															(<?php echo $taxonomy_3->count ?>)
														<?php endif; ?>
														<?php echo $taxonomy_3->name ?>
														<?php if($show_count && !$before): ?>
															(<?php echo $taxonomy_3->count ?>)
														<?php endif; ?>
													</a>

													<div class="children">
														

														<?php foreach($taxonomies as $taxonomy_4): ?>
															<?php if ($taxonomy_4->parent == $taxonomy_3->term_id): ?>

																<div id="taxonomy-<?php echo $taxonomy_4->cat_ID ?>" class="taxonomy-item">
																	
																	<a class="name" href="<?php echo get_term_link($taxonomy_4) ?>">
																		<?php if($show_count && $before): ?>
																			(<?php echo $taxonomy_4->count ?>)
																		<?php endif; ?>
																		<?php echo $taxonomy_4->name ?>
																		<?php if($show_count && !$before): ?>
																			(<?php echo $taxonomy_4->count ?>)
																		<?php endif; ?>
																	</a>

																</div>

															<?php endif ?>
														<?php endforeach ?>



													</div>

												</div>

											<?php endif ?>
										<?php endforeach ?>


									</div>

								</div>

							<?php endif ?>
						<?php endforeach ?>
							

					</div>

				</div>

			<?php endif ?>
		<?php endforeach ?>
	<?php endif ?>
	
</div>