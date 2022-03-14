<form action="" method="post" class="pok-setting-form">
	<div class="pok-setting">
	
		<?php do_action( 'pok_setting_before', $settings ); ?>
		<div class="setting-section" id="basic">
			<h4 class="section-title">
				<?php esc_html_e( 'Basic Setting', 'pok' ); ?>
			</h4>
			<div class="setting-table">
				<div class="setting-row">
					<div class="setting-index">
						<label for="pok-enable"><?php esc_html_e( 'Enabled', 'pok' ); ?></label>
						<p class="helper"><?php esc_html_e( 'Enable this shipping method?', 'pok' ); ?></p>
					</div>
					<div class="setting-option">
						<div class="toggle">
							<input type="radio" name="pok_setting[enable]" id="pok-enable-no" <?php echo 'no' === $settings['enable'] ? 'checked' : ''; ?> value="no">
							<label for="pok-enable-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
							<input type="radio" name="pok_setting[enable]" id="pok-enable-yes" <?php echo 'yes' === $settings['enable'] ? 'checked' : ''; ?> value="yes">
							<label for="pok-enable-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
						</div>
					</div>
				</div>
				<div class="setting-row">
					<div class="setting-index">
						<label for="pok-base_api"><?php esc_html_e( 'Base API', 'pok' ); ?></label>
						<p class="helper"><?php esc_html_e( 'Use our default premium API, or Rajaongkir API ', 'pok' ); ?></p>
					</div>
					<div class="setting-option">
						<div class="toggle">
							<input type="radio" name="pok_setting[base_api]" id="pok-base_api-nusantara" <?php echo 'nusantara' === $settings['base_api'] ? 'checked' : ''; ?> value="nusantara">
							<label for="pok-base_api-nusantara"><?php esc_html_e( 'Tonjoo', 'pok' ); ?></label>
							<input type="radio" name="pok_setting[base_api]" id="pok-base_api-rajaongkir" <?php echo 'rajaongkir' === $settings['base_api'] ? 'checked' : ''; ?> value="rajaongkir">
							<label for="pok-base_api-rajaongkir"><?php esc_html_e( 'Rajaongkir', 'pok' ); ?></label>
						</div>
						<div class="setting-sub-option rajakongkir-api-fields <?php echo 'rajaongkir' === $settings['base_api'] ? 'show' : ''; ?>">
							<label class="field-type"><?php esc_html_e( 'Type', 'pok' ); ?>
								<select name="pok_setting[rajaongkir_type]">
									<option value="starter" <?php echo 'starter' === $settings['rajaongkir_type'] ? 'selected' : ''; ?>>Starter</option>
									<option value="basic" <?php echo 'basic' === $settings['rajaongkir_type'] ? 'selected' : ''; ?>>Basic</option>
									<option value="pro" <?php echo 'pro' === $settings['rajaongkir_type'] ? 'selected' : ''; ?>>Pro</option>
								</select>
							</label>
							<label class="field-key"><?php esc_html_e( 'API Key', 'pok' ); ?>
								<input type="text" name="pok_setting[rajaongkir_key]" value="<?php echo esc_attr( $settings['rajaongkir_key'] ); ?>">
							</label>
							<div class="check">
								<button type="button" id="set-rajaongkir-key" class="button button-secondary"><?php esc_html_e( 'Check Rajaongkir Status', 'pok' ); ?></button>
								<span class="rajaongkir-key-response <?php echo $settings['rajaongkir_status'][0] ? 'success' : ''; ?>">
									<?php
									if ( $settings['rajaongkir_status'][0] ) {
										esc_html_e( 'API is active', 'pok' );
									} else {
										esc_html_e( 'API is inactive', 'pok' );
									}
									?>
								</span>
							</div>
						</div>
						<p class="helper">
							<?php 
								if ( $this->helper->is_multi_vendor_addon_active() ) {
									esc_html_e( 'Switching the Base API will impact the deletion of previously stored data, including: Store Location (including the location of each vendor), Custom Shipping Costs, Customer Address Data, Courier Service Filters, Custom Service Names and Shipping Cost Data stored in the cache. We did this removal to adjust the chosen API because each API provides different courier and city data. So be wise in switching the Base API, only make changes if it is really needed.', 'pok' );
								} else {
									esc_html_e( 'Switching the Base API will impact the deletion of previously stored data, including: Store Location, Custom Shipping Costs, Customer Address Data, Courier Service Filters, Custom Service Names and Shipping Cost Data stored in the cache. We did this removal to adjust the chosen API because each API provides different courier and city data. So be wise in switching the Base API, only make changes if it is really needed.', 'pok' );
								}
							?>
						</p>
					</div>
				</div>
				<?php if ( $pok_helper->is_admin_active() ) : ?>
					<div class="setting-row <?php echo empty( $settings['store_location'] ) || ! isset( $settings['store_location'][0] ) ? 'setting-error' : ''; ?>">
						<div class="setting-index">
							<label for="pok-store_location"><?php esc_html_e( 'Store Location', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Location of your store', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<?php if ( 'rajaongkir' === $settings['base_api'] ) : ?>
								<select name="pok_setting[store_location][]" id="pok-store_location" class="init-select2" placeholder="<?php esc_attr_e( 'Select city', 'pok' ); ?>">
									<option value=""><?php esc_html_e( 'Select your store location', 'pok' ); ?></option>
									<?php foreach ( $cities as $city ) : ?>
										<option value="<?php echo esc_attr( $city->city_id ); ?>" <?php echo ! empty( $settings['store_location'] ) && $settings['store_location'][0] === $city->city_id ? 'selected' : ''; ?>><?php echo esc_html( ( 'Kabupaten' === $city->type ? 'Kab. ' : 'Kota ' ) . $city->city_name . ', ' . $city->province ); ?></option>
									<?php endforeach; ?>
								</select>
							<?php else : ?>
								<select name="pok_setting[store_location][]" id="pok-store_location" class="select2-ajax" data-action="pok_search_city" data-nonce="<?php echo esc_attr( wp_create_nonce( 'search_city' ) ); ?>" placeholder="<?php esc_attr_e( 'Input city name...', 'pok' ); ?>">
									<?php
									if ( ! empty( $settings['store_location'] ) ) {
										?>
										<option selected value="<?php echo esc_attr( $settings['store_location'][0] ); ?>"><?php echo esc_html( $this->core->get_single_city( $settings['store_location'][0] ) ); ?></option>
										<?php
									}
									?>
								</select>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<?php do_action( 'pok_setting_basic', $settings ); ?>

			</div>
		</div>

		<?php if ( $pok_helper->is_admin_active() ) : ?>
			<div class="setting-section" id="courier">
				<h4 class="section-title">
					<?php esc_html_e( 'Courier', 'pok' ); ?>
				</h4>
				<div class="setting-table">
					<div class="setting-row <?php echo empty( $settings['couriers'] ) ? 'setting-error' : ''; ?>">
						<div class="setting-index">
							<label for="pok-couriers"><?php esc_html_e( 'Couriers', 'pok' ); ?></label>
							<p class="helper">
								<?php
								esc_html_e( 'Select couriers to display', 'pok' );
								?>
							</p>
						</div>
						<div class="setting-option">
							<div class="courier-options pro">
								<?php
								foreach ( $all_couriers as $courier ) {
									?>
									<input type="checkbox" value="<?php echo esc_attr( $courier ); ?>" name="pok_setting[couriers][]" id="setting-cour-<?php echo esc_attr( $courier ); ?>" <?php echo in_array( $courier, $couriers, true ) && in_array( $courier, $settings['couriers'], true ) ? 'checked' : ''; ?> <?php echo ! in_array( $courier, $couriers, true ) ? 'disabled' : ''; ?>>
									<label for="setting-cour-<?php echo esc_attr( $courier ); ?>"><?php echo esc_html( $this->helper->get_courier_name( $courier ) ); ?></label>
									<?php
								}
								?>
							</div>
							<p class="helper">
								<?php
								printf( __( 'Available couriers depends on the base API you choose. <a href="%s">Click here</a> to learn more.', 'pok' ), 'https://pluginongkoskirim.com/kurir/' );
								if ( 'rajaongkir' === $settings['base_api'] && 'starter' !== $settings['rajaongkir_type'] ) {
									echo ' ';
									esc_html_e( 'We recommend to use only 3 of these couriers to optimize the load speed', 'pok' );
								}
								?>
							</p>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Filter Courier Services', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Use specific services for each courier', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[specific_service]" id="pok-specific_service-no" <?php echo 'no' === $settings['specific_service'] ? 'checked' : ''; ?> value="no">
								<label for="pok-specific_service-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[specific_service]" id="pok-specific_service-yes" <?php echo 'yes' === $settings['specific_service'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-specific_service-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
							<div class="setting-sub-option options-specific-service <?php echo 'yes' === $settings['specific_service'] ? 'show' : ''; ?>">
								<?php foreach ( $services as $courier => $courier_services ) : ?>
									<?php asort( $courier_services ); ?>
									<div class="options-specific-service-<?php echo esc_attr( $courier ); ?> courier-options">
										<p><?php echo esc_html( $this->helper->get_courier_name( $courier ) ); ?></p>
										<div class="courier-service-options">
											<?php
											foreach ( $courier_services as $key => $service ) {
												?>
												<input type="checkbox" value="<?php echo esc_attr( $courier . '-' . $key ); ?>" name="pok_setting[specific_service_option][]" id="setting-service-<?php echo esc_attr( $courier . '-' . $key ); ?>" <?php echo in_array( $courier . '-' . $key, $settings['specific_service_option'], true ) ? 'checked' : ''; ?>>
												<label for="setting-service-<?php echo esc_attr( $courier . '-' . $key ); ?>"><?php echo esc_html( $service['long'] ); ?></label>
												<?php
											}
											?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Show Long Service Name on Checkout', 'pok' ); ?></label>
							<p class="helper"><?php echo wp_kses_post( __( 'Show long description for each courier service name', 'pok' ) ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[show_long_description]" id="pok-show_long_description-no" <?php echo 'no' === $settings['show_long_description'] ? 'checked' : ''; ?> value="no">
								<label for="pok-show_long_description-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[show_long_description]" id="pok-show_long_description-yes" <?php echo 'yes' === $settings['show_long_description'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-show_long_description-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
							<p class="helper"><?php echo wp_kses_post( __( "Showing long service name will help visitors who are not familiar with the courier service name. For example: <strong>JNE - YES</strong> becomes <strong>JNE - YES (Yakin Esok Sampai)</strong>", 'pok' ) ); ?></p>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Custom Service Name', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Change courier service name with your custom name.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="setting-repeater-wrapper markup-repeater <?php echo empty( $settings['custom_service_name'][ $settings['base_api'] ] ) ? 'empty' : ''; ?>">
								<div class="repeater-container">
									<div class="repeater-head">
										<div class="repeater-col">
											<?php esc_html_e( 'Courier', 'pok' ) ?>
										</div>
										<div class="repeater-col">
											<?php esc_html_e( 'Service Name', 'pok' ) ?>
										</div>
										<div class="repeater-col">
											<?php esc_html_e( 'Custom Name', 'pok' ) ?>
										</div>
										<div class="repeater-col">
										</div>
									</div>
									<?php foreach ( $settings['custom_service_name'][ $settings['base_api'] ] as $name_key => $name ) : ?>
										<div class="repeater-row" data-id="<?php echo esc_attr( $name_key ) ?>">
											<div class="repeater-col">
												<select name="pok_setting[custom_service_name][<?php echo esc_attr( $settings['base_api'] ) ?>][<?php echo esc_attr( $name_key ) ?>][courier]" class="custom-service-courier">
													<?php foreach ( $couriers as $courier ) : ?>
														<option <?php echo isset( $name['courier'] ) &&  $courier === $name['courier'] ? 'selected' : '' ?> value="<?php echo esc_attr( $courier ) ?>"><?php echo esc_html( $this->helper->get_courier_name( $courier ) ) ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="repeater-col">
												<select name="pok_setting[custom_service_name][<?php echo esc_attr( $settings['base_api'] ) ?>][<?php echo esc_attr( $name_key ) ?>][service]" class="custom-service-service">
													<?php if ( isset( $name['courier'] ) && isset( $services[ $name['courier'] ] ) ) : ?>
														<?php foreach ( $services[ $name['courier'] ] as $key => $service ) : ?>
															<option <?php echo isset( $name['service'] ) &&  $key === $name['service'] ? 'selected' : '' ?> value="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $service['long'] ) ?></option>
														<?php endforeach; ?>
													<?php endif; ?>
												</select>
											</div>
											<div class="repeater-col">
												<input type="text" name="pok_setting[custom_service_name][<?php echo esc_attr( $settings['base_api'] ) ?>][<?php echo esc_attr( $name_key ) ?>][name]" value="<?php echo isset( $name['name'] ) ? esc_attr( $name['name'] ) : '' ?>">
											</div>
											<div class="repeater-col nowrap">
												<button type="button" class="delete-repeater-row button button-small"><?php esc_html_e( 'Remove', 'pok' ) ?></button>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
								<div class="repeater-base">
									<div class="repeater-col">
										<select name="pok_setting[custom_service_name][<?php echo esc_attr( $settings['base_api'] ) ?>][{id}][courier]" class="custom-service-courier" disabled>
											<option value=""><?php esc_html_e( 'Select Courier', 'pok' ) ?></option>
											<?php foreach ( $couriers as $courier ) : ?>
												<option value="<?php echo esc_attr( $courier ) ?>"><?php echo esc_html( $this->helper->get_courier_name( $courier ) ) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="repeater-col">
										<select name="pok_setting[custom_service_name][<?php echo esc_attr( $settings['base_api'] ) ?>][{id}][service]" class="custom-service-service" disabled>
											<option value=""><?php esc_html_e( 'Select Service', 'pok' ) ?></option>
										</select>
									</div>
									<div class="repeater-col">
										<input type="text" name="pok_setting[custom_service_name][<?php echo esc_attr( $settings['base_api'] ) ?>][{id}][name]" value="" disabled>
									</div>
									<div class="repeater-col nowrap">
										<button type="button" class="delete-repeater-row button button-small"><?php esc_html_e( 'Remove', 'pok' ) ?></button>
									</div>
								</div>
								<button type="button" id="add-custom-service" class="add-repeater-row button"><?php esc_html_e( 'Add Custom Name', 'pok' ) ?></button>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Enable International Shipping', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Show international shipping costs on checkout page', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<?php if ( 'rajaongkir' === $settings['base_api'] && 'starter' !== $settings['rajaongkir_type'] ) : ?>
								<div class="toggle">
									<input type="radio" name="pok_setting[international_shipping]" id="pok-international_shipping-no" <?php echo 'no' === $settings['international_shipping'] ? 'checked' : ''; ?> value="no">
									<label for="pok-international_shipping-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
									<input type="radio" name="pok_setting[international_shipping]" id="pok-international_shipping-yes" <?php echo 'yes' === $settings['international_shipping'] ? 'checked' : ''; ?> value="yes">
									<label for="pok-international_shipping-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
								</div>
							<?php else: ?>
								<p class="helper" style="margin:0;"><?php esc_html_e( 'International shipping costs only available on API Rajaongkir with Basic or Pro type.', 'pok' ) ?></p>
							<?php endif; ?>
						</div>
					</div>

					<?php do_action( 'pok_setting_courier', $settings ); ?>

				</div>
			</div>

			<div class="setting-section" id="shipping">
				<h4 class="section-title">
					<?php esc_html_e( 'Shipping Weight', 'pok' ); ?>
				</h4>
				<div class="setting-table">
					<div class="setting-row">
						<div class="setting-index">
							<label for="pok-default_weight"><?php esc_html_e( 'Default Shipping Weight (kg)', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Default shipping weight if total weight is unknown.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<input id="pok-default_weight" type="number" name="pok_setting[default_weight]" value="<?php echo esc_attr( $settings['default_weight'] ); ?>" step="0.1" min="0.1">
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Round Shipping Weight', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'How shipping weight will be rounded', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<?php if ( 'rajaongkir' === $settings['base_api'] ) : ?>
									<input type="radio" name="pok_setting[round_weight]" id="pok-round_weight-no" <?php echo 'no' === $settings['round_weight'] ? 'checked' : ''; ?> value="no">
									<label for="pok-round_weight-no"><?php esc_html_e( "Don't Round", 'pok' ); ?></label>
								<?php endif; ?>
								<input type="radio" name="pok_setting[round_weight]" id="pok-round_weight-auto" <?php echo 'auto' === $settings['round_weight'] ? 'checked' : ''; ?> value="auto">
								<label for="pok-round_weight-auto"><?php esc_html_e( 'Auto Round', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[round_weight]" id="pok-round_weight-ceil" <?php echo 'ceil' === $settings['round_weight'] ? 'checked' : ''; ?> value="ceil">
								<label for="pok-round_weight-ceil"><?php esc_html_e( 'Round Up', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[round_weight]" id="pok-round_weight-floor" <?php echo 'floor' === $settings['round_weight'] ? 'checked' : ''; ?> value="floor">
								<label for="pok-round_weight-floor"><?php esc_html_e( 'Round Down', 'pok' ); ?></label>
							</div>
							<div class="setting-sub-option options-round-weight <?php echo 'auto' === $settings['round_weight'] ? 'show' : ''; ?>">
								<label for="pok-round_weight_tolerance"><?php esc_html_e( 'Weight Tolerance (gram)', 'pok' ); ?></label>
								<input id="pok-round_weight_tolerance" name="pok_setting[round_weight_tolerance]" type="number" value="<?php echo esc_attr( $settings['round_weight_tolerance'] ); ?>" min="0" max="1000">
								<p class="helper"><?php esc_html_e( 'If shipping weight is less equal to the limit, it will rounding down. Otherwise, it will be rounding up.', 'pok' ); ?></p>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Use Volume Metric Calculation', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Calculate shipping weight using product dimension. If the dimension is not set, it will use weight instead.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[enable_volume_calculation]" id="pok-enable_volume_calculation-no" <?php echo 'no' === $settings['enable_volume_calculation'] ? 'checked' : ''; ?> value="no">
								<label for="pok-enable_volume_calculation-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[enable_volume_calculation]" id="pok-enable_volume_calculation-yes" <?php echo 'yes' === $settings['enable_volume_calculation'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-enable_volume_calculation-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
							<p class="helper"><?php esc_html_e( 'The weight of the product will calculated with the formula:', 'pok' ); ?> <code>( <?php esc_html_e( 'length', 'pok' ); ?> * <?php esc_html_e( 'width', 'pok' ); ?> * <?php esc_html_e( 'height', 'pok' ); ?> ) / 6000</code></p>
						</div>
					</div>

					<?php do_action( 'pok_setting_shipping_weight', $settings ); ?>

				</div>
			</div>
			<div class="setting-section" id="shipping">
				<h4 class="section-title">
					<?php esc_html_e( 'Shipping Costs', 'pok' ); ?>
				</h4>
				<div class="setting-table">
					<div class="setting-row">
						<div class="setting-index">
							<label for="pok-enable_insurance"><?php esc_html_e( 'Shipping Insurance', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Add insurance fee to shipping cost', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<select name="pok_setting[enable_insurance]" id="pok-enable_insurance">
								<option <?php echo 'set' === $settings['enable_insurance'] ? 'selected' : ''; ?> value="set"><?php esc_html_e( 'Only apply on specific product (can be set via edit product)', 'pok' ); ?></option>
								<option <?php echo 'yes' === $settings['enable_insurance'] ? 'selected' : ''; ?> value="yes"><?php esc_html_e( 'Apply to all products', 'pok' ); ?></option>
								<option <?php echo 'no' === $settings['enable_insurance'] ? 'selected' : ''; ?> value="no"><?php esc_html_e( 'Do not add insurance fee', 'pok' ); ?></option>
							</select>
							<div class="setting-sub-option options-enable-insurance <?php echo 'set' === $settings['enable_insurance'] || 'yes' === $settings['enable_insurance'] ? 'show' : ''; ?>">
								<label for="pok-insurance_application"><?php esc_html_e( 'How insurance fee will be applied to the cost?', 'pok' ); ?></label>
								<select name="pok_setting[insurance_application]" id="pok-insurance_application">
									<option <?php echo 'by_user' === $settings['insurance_application'] ? 'selected' : ''; ?> value="by_user"><?php esc_html_e( 'Let user decide', 'pok' ); ?></option>
									<option <?php echo 'force' === $settings['insurance_application'] ? 'selected' : ''; ?> value="force"><?php esc_html_e( 'Always apply insurance fee', 'pok' ); ?></option>
								</select>
								<p class="helper">
									<?php esc_html_e( 'If you let user to decide, a checkbox will be shown on checkout page to let user to choose to add insurance fee or not.', 'pok' ); ?>
								</p>
							</div>
							<p class="helper"><?php printf( __( 'Each courier applies different rules for insurance calculations. For more info, <a href="%s">check here</a>.', 'pok' ), 'http://pustaka.tonjoostudio.com/plugins/woo-ongkir-manual/#section-shipping-insurance' ); ?></p>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label for="pok-enable_timber_packing"><?php esc_html_e( 'Timber Packing Fee', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Add timber packing fee to shipping cost.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<select name="pok_setting[enable_timber_packing]" id="pok-enable_timber_packing">
								<option <?php echo 'set' === $settings['enable_timber_packing'] ? 'selected' : ''; ?> value="set"><?php esc_html_e( 'Only apply on specific product (can be set via edit product)', 'pok' ); ?></option>
								<option <?php echo 'yes' === $settings['enable_timber_packing'] ? 'selected' : ''; ?> value="yes"><?php esc_html_e( 'Apply to all products', 'pok' ); ?></option>
								<option <?php echo 'no' === $settings['enable_timber_packing'] ? 'selected' : ''; ?> value="no"><?php esc_html_e( 'Do not add timber packing fee', 'pok' ); ?></option>
							</select>
							<div class="setting-sub-option options-enable-timber_packing <?php echo 'set' === $settings['enable_timber_packing'] || 'yes' === $settings['enable_timber_packing'] ? 'show' : ''; ?>">
								<label for="pok-timber_packing_multiplier"><?php esc_html_e( 'Shipping cost multiplier', 'pok' ); ?></label>
								<input type="number" name="pok_setting[timber_packing_multiplier]" id="pok-timber_packing_multiplier" value="<?php echo esc_attr( $settings['timber_packing_multiplier'] ); ?>" step="0.1" min="0">
								<p class="helper">
									<?php esc_html_e( 'The shipping cost multiplier is used to determine how much the timber packing fee is. The value "1" means the timber packing fee is equal to the selected shipping cost.', 'pok' ); ?>
								</p>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Shipping Cost Markup', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'You can mark-up/mark-down your shipping cost based on your need.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="setting-repeater-wrapper markup-repeater <?php echo empty( $settings['markup'] ) ? 'empty' : ''; ?>">
								<div class="repeater-container">
									<div class="repeater-head">
										<div class="repeater-col">
											<?php esc_html_e( 'Courier', 'pok' ) ?>
										</div>
										<div class="repeater-col">
											<?php esc_html_e( 'Service', 'pok' ) ?>
										</div>
										<div class="repeater-col">
											<?php esc_html_e( 'Cost Markup', 'pok' ) ?>
										</div>
										<div class="repeater-col">
										</div>
									</div>
									<?php foreach ( $settings['markup'] as $markup_key => $markup ) : ?>
										<div class="repeater-row" data-id="<?php echo esc_attr( $markup_key ) ?>">
											<div class="repeater-col">
												<select name="pok_setting[markup][<?php echo esc_attr( $markup_key ) ?>][courier]" class="markup-courier">
													<option <?php echo ! isset( $markup['courier'] ) || '' === $markup['courier'] ? 'selected' : '' ?> value=""><?php esc_html_e( 'All Courier', 'pok' ) ?></option>
													<?php foreach ( $settings['couriers'] as $courier ) : ?>
														<option <?php echo isset( $markup['courier'] ) &&  $courier === $markup['courier'] ? 'selected' : '' ?> value="<?php echo esc_attr( $courier ) ?>"><?php echo esc_html( $this->helper->get_courier_name( $courier ) ) ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="repeater-col">
												<select name="pok_setting[markup][<?php echo esc_attr( $markup_key ) ?>][service]" class="markup-service">
													<option <?php echo ! isset( $markup['service'] ) || '' === $markup['service'] ? 'selected' : '' ?> value=""><?php esc_html_e( 'All Service', 'pok' ) ?></option>
													<?php if ( isset( $markup['courier'] ) && isset( $services[ $markup['courier'] ] ) ) : ?>
														<?php foreach ( $services[ $markup['courier'] ] as $key => $service ) : ?>
															<option <?php echo isset( $markup['service'] ) &&  $key === $markup['service'] ? 'selected' : '' ?> value="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $service['long'] ) ?></option>
														<?php endforeach; ?>
													<?php endif; ?>
												</select>
											</div>
											<div class="repeater-col">
												<input type="number" name="pok_setting[markup][<?php echo esc_attr( $markup_key ) ?>][amount]" value="<?php echo isset( $markup['amount'] ) ? esc_attr( $markup['amount'] ) : 0 ?>">
											</div>
											<div class="repeater-col nowrap">
												<button type="button" class="delete-repeater-row button button-small"><?php esc_html_e( 'Remove', 'pok' ) ?></button>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
								<div class="repeater-base">
									<div class="repeater-col">
										<select name="pok_setting[markup][{id}][courier]" class="markup-courier" disabled>
											<option value=""><?php esc_html_e( 'All Courier', 'pok' ) ?></option>
											<?php foreach ( $settings['couriers'] as $courier ) : ?>
												<option value="<?php echo esc_attr( $courier ) ?>"><?php echo esc_html( $this->helper->get_courier_name( $courier ) ) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="repeater-col">
										<select name="pok_setting[markup][{id}][service]" class="markup-service" disabled>
											<option value=""><?php esc_html_e( 'All Service', 'pok' ) ?></option>
										</select>
									</div>
									<div class="repeater-col">
										<input type="number" name="pok_setting[markup][{id}][amount]" value="0" disabled>
									</div>
									<div class="repeater-col nowrap">
										<button type="button" class="delete-repeater-row button button-small"><?php esc_html_e( 'Remove', 'pok' ) ?></button>
									</div>
								</div>
								<button type="button" id="add-markup" class="add-repeater-row button"><?php esc_html_e( 'Add Cost Markup', 'pok' ) ?></button>
								<p class="helper"><?php esc_html_e( "Use a negative value on the Cost Markup to set a price decrease on cost.", 'pok' ); ?></p>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<?php $wc_currency = get_woocommerce_currency(); ?>
							<label for="pok-currency_conversion"><?php esc_html_e( 'Currency Conversion', 'pok' ); ?></label>
							<?php if ( 'IDR' !== $wc_currency ) : ?>
								<p class="helper"><?php esc_html_e( "We provide the shipping costs data in Indonesian Rupiah. You need to set up conversions to convert costs to your site's currency.", 'pok' ); ?></p>
							<?php endif; ?>
						</div>
						<div class="setting-option">
							<select name="pok_setting[currency_conversion]" id="pok-currency_conversion" <?php echo 'IDR' === $wc_currency ? 'disabled' : ''; ?>>
								<option <?php echo 'dont_convert' === $settings['currency_conversion'] ? 'selected' : ''; ?> value="dont_convert"><?php esc_html_e( 'Do not convert', 'pok' ); ?></option>
								<option <?php echo 'fixer' === $settings['currency_conversion'] && 'IDR' !== $wc_currency ? 'selected' : ''; ?> value="fixer"><?php esc_html_e( 'Use Fixer API', 'pok' ); ?></option>
								<option <?php echo 'currencylayer' === $settings['currency_conversion'] && 'IDR' !== $wc_currency ? 'selected' : ''; ?> value="currencylayer"><?php esc_html_e( 'Use Currency Layer API', 'pok' ); ?></option>
								<option <?php echo 'wpml' === $settings['currency_conversion'] && 'IDR' !== $wc_currency ? 'selected' : ''; ?> value="wpml"><?php esc_html_e( "Use WPML's multi currency", 'pok' ); ?></option>
								<option <?php echo 'static' === $settings['currency_conversion'] && 'IDR' !== $wc_currency ? 'selected' : ''; ?> value="static"><?php esc_html_e( 'Static conversion rate', 'pok' ); ?></option>
							</select>
							<?php if ( 'IDR' === $wc_currency ) : ?>
								<p class="helper"><?php esc_html_e( 'Your site is currently using IDR as the currency. So this option is not required.', 'pok' ); ?></p>
							<?php else : ?>
								<div class="setting-sub-option options-currency options-currency-fixer <?php echo 'fixer' === $settings['currency_conversion'] ? 'show' : ''; ?>">
									<label for="pok-currency_fixer_api_type"><?php esc_html_e( 'Fixer Subscription Plan', 'pok' ); ?></label>
									<select name="pok_setting[currency_fixer_api_type]" id="pok-currency_fixer_api_type">
										<option <?php echo 'basic' === $settings['currency_fixer_api_type'] ? 'selected' : ''; ?> value="yes"><?php esc_html_e( 'Basic', 'pok' ); ?></option>
										<option <?php echo 'professional' === $settings['currency_fixer_api_type'] ? 'selected' : ''; ?> value="professional"><?php esc_html_e( 'Professional', 'pok' ); ?></option>
										<option <?php echo 'professional_plus' === $settings['currency_fixer_api_type'] ? 'selected' : ''; ?> value="professional"><?php esc_html_e( 'Professional Plus', 'pok' ); ?></option>
										<option <?php echo 'enterprise' === $settings['currency_fixer_api_type'] ? 'selected' : ''; ?> value="professional"><?php esc_html_e( 'Enterprise', 'pok' ); ?></option>
									</select>
									<p class="helper"><?php printf( __( "You need at least Basic subscription plan on Fixer to use this function. We store the rates from Fixer to cache, so you don't have to worry about API calls limitation. Cache expiration is based on update interval on your plan. <a target='_blank' href='%s'>learn more here</a>", 'pok' ), 'https://fixer.io/product' ); ?></p>
									<label for="pok-currency_fixer_api_key"><?php esc_html_e( 'Fixer API Key', 'pok' ); ?></label>
									<input id="pok-currency_fixer_api_key" type="text" name="pok_setting[currency_fixer_api_key]" value="<?php echo esc_attr( $settings['currency_fixer_api_key'] ); ?>">
									<p class="helper"><?php printf( __( 'Find your API key <a target="_blank" href="%s">here</a>', 'pok' ), 'https://fixer.io/dashboard' ); ?></p>
									<div class="check">
										<button type="button" id="check-fixer-api" class="button button-secondary"><?php esc_html_e( 'Check API Status', 'pok' ); ?></button>
										<p class="api-response"></p>
									</div>
								</div>
								<div class="setting-sub-option options-currency options-currency-currencylayer <?php echo 'currencylayer' === $settings['currency_conversion'] ? 'show' : ''; ?>">
									<label for="pok-currency_currencylayer_api_type"><?php esc_html_e( 'Currency Layer Subscription Plan', 'pok' ); ?></label>
									<select name="pok_setting[currency_currencylayer_api_type]" id="pok-currency_currencylayer_api_type">
										<option <?php echo 'basic' === $settings['currency_currencylayer_api_type'] ? 'selected' : ''; ?> value="yes"><?php esc_html_e( 'Basic', 'pok' ); ?></option>
										<option <?php echo 'professional' === $settings['currency_currencylayer_api_type'] ? 'selected' : ''; ?> value="professional"><?php esc_html_e( 'Professional', 'pok' ); ?></option>
										<option <?php echo 'enterprise' === $settings['currency_currencylayer_api_type'] ? 'selected' : ''; ?> value="professional"><?php esc_html_e( 'Enterprise', 'pok' ); ?></option>
									</select>
									<p class="helper"><?php printf( __( "You need at least Basic subscription plan on Currency Layer to use this function. We store the rates from Currency Layer to cache, so you don't have to worry about API calls limitation. Cache expiration is based on update interval on your plan. <a target='_blank' href='%s'>learn more here</a>", 'pok' ), 'https://currencylayer.com/plan' ); ?></p>
									<label for="pok-currency_currencylayer_api_key"><?php esc_html_e( 'Currency Layer API Key', 'pok' ); ?></label>
									<input id="pok-currency_currencylayer_api_key" type="text" name="pok_setting[currency_currencylayer_api_key]" value="<?php echo esc_attr( $settings['currency_currencylayer_api_key'] ); ?>">
									<p class="helper"><?php printf( __( 'Find your API key <a target="_blank" href="%s">here</a>', 'pok' ), 'https://currencylayer.com/dashboard' ); ?></p>
									<div class="check">
										<button type="button" id="check-currencylayer-api" class="button button-secondary"><?php esc_html_e( 'Check API Status', 'pok' ); ?></button>
										<p class="api-response"></p>
									</div>
								</div>
								<?php if ( ! $this->helper->is_wpml_multi_currency_active() ) : ?>
									<div class="setting-sub-option options-currency options-currency-wpml <?php echo 'wpml' === $settings['currency_conversion'] ? 'show' : ''; ?>">
										<p class="helper"><?php esc_html_e( "You need to install WPML's WooCommerce Multilingual and enable the multi-currency mode to use this function", 'pok' ); ?></p>
									</div>
								<?php elseif ( false === $this->helper->get_wpml_rate() ) : ?>
									<div class="setting-sub-option options-currency options-currency-wpml <?php echo 'wpml' === $settings['currency_conversion'] ? 'show' : ''; ?>">
										<p class="helper"><?php printf( __( "You need to set your currency conversion rate to IDR to use this function. <a href='%s'>click here to configure</a>", 'pok' ), admin_url( 'admin.php?page=wpml-wcml&tab=multi-currency' ) ); ?></p>
									</div>
								<?php else : ?>
									<div class="setting-sub-option options-currency options-currency-wpml <?php echo 'wpml' === $settings['currency_conversion'] ? 'show' : ''; ?>">
										<p class="helper"><?php printf( __( "Current conversion rate on WPML's Multi-Currency setting: 1 IDR = %1\$s %2\$s. <a href='%3\$s'>click here to configure</a>", 'pok' ), number_format( floatval( $this->helper->get_wpml_rate() ), 6 ), $wc_currency, admin_url( 'admin.php?page=wpml-wcml&tab=multi-currency' ) ); ?></p>
									</div>
								<?php endif; ?>
								<div class="setting-sub-option options-currency options-currency-static <?php echo 'static' === $settings['currency_conversion'] ? 'show' : ''; ?>">
									<label for="pok-currency_static_conversion_rate"><?php printf( __( '1 IDR to %s conversion rate', 'pok' ), $wc_currency ); ?></label>
									<input id="pok-currency_static_conversion_rate" type="number" name="pok_setting[currency_static_conversion_rate]" value="<?php echo esc_attr( $settings['currency_static_conversion_rate'] ); ?>" step="any">
									<p class="helper"><?php printf( __( "Click <a target='_blank' href='%s'>here</a> to get latest conversion rate", 'pok' ), 'https://www.google.com/search?q=1+IDR+to+' . $wc_currency ); ?></p>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<?php do_action( 'pok_setting_shipping_cost', $settings ); ?>

				</div>
			</div>

			<div class="setting-section" id="checkout">
				<h4 class="section-title">
					<?php esc_html_e( 'Checkout Page', 'pok' ); ?>
				</h4>
				<div class="setting-table">
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Use Simple Address Field', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'If enabled, the address fields (province, city, district) will be combined into 1 simplified field. This option only available on API Tonjoo.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<?php if ( 'nusantara' === $settings['base_api'] ) : ?>
								<div class="toggle">
									<input type="radio" name="pok_setting[use_simple_address_field]" id="pok-use_simple_address_field-no" <?php echo 'no' === $settings['use_simple_address_field'] ? 'checked' : ''; ?> value="no">
									<label for="pok-use_simple_address_field-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
									<input type="radio" name="pok_setting[use_simple_address_field]" id="pok-use_simple_address_field-yes" <?php echo 'yes' === $settings['use_simple_address_field'] ? 'checked' : ''; ?> value="yes">
									<label for="pok-use_simple_address_field-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
								</div>
							<?php else: ?>
								<p class="helper" style="margin:0;"><?php esc_html_e( 'This option only available on API Tonjoo.', 'pok' ) ?></p>
							<?php endif; ?>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Auto Fill Address', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Auto-fill checkout field with saved address if customer is a returning user.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[auto_fill_address]" id="pok-auto_fill_address-no" <?php echo 'no' === $settings['auto_fill_address'] ? 'checked' : ''; ?> value="no">
								<label for="pok-auto_fill_address-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[auto_fill_address]" id="pok-auto_fill_address-yes" <?php echo 'yes' === $settings['auto_fill_address'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-auto_fill_address-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Show Total Weight on Checkout', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Show total shipping weight on checkout page', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[show_weight_on_checkout]" id="pok-show_weight_on_checkout-no" <?php echo 'no' === $settings['show_weight_on_checkout'] ? 'checked' : ''; ?> value="no">
								<label for="pok-show_weight_on_checkout-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[show_weight_on_checkout]" id="pok-show_weight_on_checkout-yes" <?php echo 'yes' === $settings['show_weight_on_checkout'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-show_weight_on_checkout-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Show Shipping Estimation on Checkout', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Show shipping estimation on checkout', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[show_shipping_etd]" id="pok-show_shipping_etd-no" <?php echo 'no' === $settings['show_shipping_etd'] ? 'checked' : ''; ?> value="no">
								<label for="pok-show_shipping_etd-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[show_shipping_etd]" id="pok-show_shipping_etd-yes" <?php echo 'yes' === $settings['show_shipping_etd'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-show_shipping_etd-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Show Shipping Origin on Checkout', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Show your store location on checkout page', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[show_origin_on_checkout]" id="pok-show_origin_on_checkout-no" <?php echo 'no' === $settings['show_origin_on_checkout'] ? 'checked' : ''; ?> value="no">
								<label for="pok-show_origin_on_checkout-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[show_origin_on_checkout]" id="pok-show_origin_on_checkout-yes" <?php echo 'yes' === $settings['show_origin_on_checkout'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-show_origin_on_checkout-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
						</div>
					</div>

					<?php do_action( 'pok_setting_checkout', $settings ); ?>

				</div>
			</div>

			<div class="setting-section" id="miscellaneous">
				<h4 class="section-title">
					<?php esc_html_e( 'Miscellaneous', 'pok' ); ?>
				</h4>
				<div class="setting-table">
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Show Shipping Calculator on Product Page', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Show shipping cost estimation calculator on product tabs', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[show_shipping_estimation]" id="pok-show_shipping_estimation-no" <?php echo 'no' === $settings['show_shipping_estimation'] ? 'checked' : ''; ?> value="no">
								<label for="pok-show_shipping_estimation-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[show_shipping_estimation]" id="pok-show_shipping_estimation-yes" <?php echo 'yes' === $settings['show_shipping_estimation'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-show_shipping_estimation-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
							<p class="helper"><?php printf( __( "Or simply use %s shortcode on the product description. But make sure to set this option to 'No' first.", 'pok' ), '<code>[pok_shipping_calculator]</code>' ); ?></p>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Add Unique Number on Checkout', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Add unique number to total purchase to easily differ an order from another', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[unique_number]" id="pok-unique_number-no" <?php echo 'no' === $settings['unique_number'] ? 'checked' : ''; ?> value="no">
								<label for="pok-unique_number-no"><?php esc_html_e( 'No', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[unique_number]" id="pok-unique_number-yes" <?php echo 'yes' === $settings['unique_number'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-unique_number-yes"><?php esc_html_e( 'Yes', 'pok' ); ?></label>
							</div>
							<div class="setting-sub-option options-unique-number <?php echo 'yes' === $settings['unique_number'] ? 'show' : ''; ?>">
								<label for="pok-unique_number_length"><?php esc_html_e( 'Unique Number Length', 'pok' ); ?></label>
								<select name="pok_setting[unique_number_length]" id="pok-unique_number_length">
									<?php
									$lengths = array(
										1 	=> 'x (0-9)',
										2 	=> 'xx (0-99)',
										3 	=> 'xxx (0-999)',
										10	=> '0.x (0-0.9)',
										20	=> '0.xx (0-0.99)',
										30	=> '0.xxx (0-0.999)'
									);
									foreach ( $lengths as $key => $label ) {
										?>
										<option <?php echo $key === intval( $settings['unique_number_length'] ) ? 'selected' : ''; ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option>
										<?php
									}
									?>
								</select>
								<p class="helper"><?php esc_html_e( 'Length of you unique number.', 'pok' ); ?></p>
							</div>
						</div>
					</div>

					<?php do_action( 'pok_setting_miscellaneous', $settings ); ?>

				</div>
			</div>

			<div class="setting-section" id="advanced">
				<h4 class="section-title">
					<?php esc_html_e( 'Advanced', 'pok' ); ?>
				</h4>
				<div class="setting-table">
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Cache Expiration (in hours)', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Cache expiration is a feature that keep your shipping costs data or addresses data as a stored cache. This feature will significally increase your website speed.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<label for="pok-cache_expiration_costs"><?php esc_html_e( 'Shipping Costs Data', 'pok' ); ?></label>
							<input type="number" id="pok-cache_expiration_costs" name="pok_setting[cache_expiration_costs]" value="<?php echo esc_attr( $settings['cache_expiration_costs'] ); ?>" min="1">
							<br>
							<label for="pok-cache_expiration_addresses"><?php esc_html_e( 'Addresses Data (province list, city list, etc)', 'pok' ); ?></label>
							<input type="number" id="pok-cache_expiration_addresses" name="pok_setting[cache_expiration_addresses]" value="<?php echo esc_attr( $settings['cache_expiration_addresses'] ); ?>" min="1">
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Flush Cache', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Delete all cached data', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=pok_setting' ), 'flush_cache', 'pok_action' ) ); ?>" class="button button-warning" onclick="return confirm('<?php esc_attr_e( 'Are you sure?', 'pok' ); ?>')">Flush Cache</a>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Reset Configuration', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'Delete all saved configuration just like fresh install.', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<a href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin.php?page=pok_setting' ), 'reset', 'pok_action' ) ); ?>" class="button button-warning" onclick="return confirm('<?php esc_attr_e( 'Are you sure?', 'pok' ); ?>')">Reset</a>
						</div>
					</div>
					<div class="setting-row">
						<div class="setting-index">
							<label><?php esc_html_e( 'Debug Mode', 'pok' ); ?></label>
							<p class="helper"><?php esc_html_e( 'You will be able to access the error logs on the new menu tab that will show up after you enable this option. Be careful, this option will disable caching feature!', 'pok' ); ?></p>
						</div>
						<div class="setting-option">
							<div class="toggle">
								<input type="radio" name="pok_setting[debug_mode]" id="pok-debug_mode-no" <?php echo 'no' === $settings['debug_mode'] ? 'checked' : ''; ?> value="no">
								<label for="pok-debug_mode-no"><?php esc_html_e( 'Disable', 'pok' ); ?></label>
								<input type="radio" name="pok_setting[debug_mode]" id="pok-debug_mode-yes" <?php echo 'yes' === $settings['debug_mode'] ? 'checked' : ''; ?> value="yes">
								<label for="pok-debug_mode-yes"><?php esc_html_e( 'Enable', 'pok' ); ?></label>
							</div>
						</div>
					</div>

					<?php do_action( 'pok_setting_advanced', $settings ); ?>

				</div>
			</div>
		<?php else : ?>
			<div class="pok-notice">
				<p><?php echo wp_kses_post( __( 'More advanced setting will show up here if you activate the license of Rajaongkir.', 'pok' ) ); ?></p>
			</div>
		<?php endif; ?>

		<?php do_action( 'pok_setting_after' ); ?>

	</div>
	<br>
	<?php wp_nonce_field( 'update_setting', 'pok_action' ); ?>
	<input type="submit" value="<?php esc_attr_e( 'Save Setting', 'pok' ); ?>" class="button button-primary">
</form>
