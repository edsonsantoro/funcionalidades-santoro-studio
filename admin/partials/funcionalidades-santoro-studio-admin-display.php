<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://santoro.studio
 * @since      1.0.0
 *
 * @package    Funcionalidades_Santoro_Studio
 * @subpackage Funcionalidades_Santoro_Studio/admin/partials
 */
/**
		 * This is a framework to build Plugin Settings pages
		 * 
		 * @since 1.0.0
		 */

// Settings Page: SantoroStudio
// Retrieving values: get_option( 'your_field_id' )
class SantoroStudio_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
	}

	public function wph_create_settings() {
		$page_title = 'Santoro Studio';
		$menu_title = 'Santoro Studio';
		$capability = 'manage_options';
		$slug = 'SantoroStudio';
		$callback = array($this, 'wph_settings_content');
                add_options_page($page_title, $menu_title, $capability, $slug, $callback);
		
	}
    
	public function wph_settings_content() { ?>
		<div class="wrap">
			<h1>Santoro Studio</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'SantoroStudio' );
					do_settings_sections( 'SantoroStudio' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function wph_setup_sections() {
		add_settings_section( 'SantoroStudio_section', 'Opções para seu site Woocommerce', array(), 'SantoroStudio' );
	}

    public function sds_get_role_names() {
        global $wp_roles;
        if ( ! isset( $wp_roles ) )
            $wp_roles = new WP_Roles();    
        return $wp_roles->get_names();
    }

	public function wph_setup_fields() {
		$fields = array(
                    array(
                        'section' => 'SantoroStudio_section',
                        'label' => 'Auto repor itens ao estoque',
                        'id' => 'sds_funcionalidades[increase_stock_levels_for_cancelled_orders]',
                        'desc' => 'Marque esta opção para devolver todos os itens de um pedido cancelado ao estoque automaticamente.',
                        'type' => 'checkbox',
                    ),
        
                    array(
                        'section' => 'SantoroStudio_section',
                        'label' => 'Reservar itens de pedidos sem pagamento',
                        'id' => 'sds_funcionalidades[reduce_stock_levels_for_pending_orders]',
                        'desc' => 'Marque esta opção para que todos os itens em pedidos com status "Aguardando Pagamento", continuem reservados para tal cliente até o pagamento.',
                        'type' => 'checkbox',
                    ),
        
                    array(
                        'section' => 'SantoroStudio_section',
                        'label' => 'Definir cliente como "Visitante" para pedidos criados manualmente',
                        'id' => 'sds_funcionalidades[update_customer_for_admin_orders]',
                        'desc' => 'Quando um pedido é feito manualmente no WooCommerce, somente o cliente definido para tal pedido pode ver a página de pagamento. Marque esta opção para que os pedidos criados manualmente tenham como Cliente um Visitante, permitindo assim enviar link de pagamento para qualquer pessoa.',
                        'type' => 'checkbox',
                    ),
        
                    array(
                        'section' => 'SantoroStudio_section',
                        'label' => 'Definir cliente como "Visitante" para pedidos criados pela equipe',
                        'id' => 'sds_funcionalidades[update_customer_for_public_orders]',
                        'desc' => 'Quando um pedido é feito por sua equipe em nome de um cliente usando o perfil de administração do WooCommerce, somente este perfil pode ver a página de pagamento. Marque esta opção para que os pedidos criados por sua equipe em nome de clientes tenham como Cliente um Visitante, permitindo assim enviar link de pagamento para qualquer pessoa.',
                        'type' => 'checkbox',
                    ),
        
                    array(
                        'section' => 'SantoroStudio_section',
                        'label' => 'Perfis que terão o cliente modificado para Visitante para pedidos manuais',
                        'id' => 'sds_funcionalidades[manual_orders_roles][roles][]',
                        'desc' => 'Somente as funções selecionadas terão os clientes de pedidos atualizados para Visitante automaticamente.',
                        'type' => 'multiselect',
                        'options' => $this->sds_get_role_names()
                    ),
        
                    array(
                        'section' => 'SantoroStudio_section',
                        'label' => 'Perfis que terão o cliente modificado para Visitante para pedidos públicos',
                        'id' => 'sds_funcionalidades[public_orders_roles][roles][]',
                        'desc' => 'Somente as funções selecionadas terão os clientes de pedidos atualizados para Visitante automaticamente.',
                        'type' => 'multiselect',
                        'options' => $this->sds_get_role_names()
                    )
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'SantoroStudio', $field['section'], $field );
			if($field['type'] == 'multiselect'){
                register_setting( 'SantoroStudio', $field['id'] );
            } else {
                register_setting( 'SantoroStudio', $field['id'] );
            }
		}
	}
	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
            
            
                        case 'select':
                            case 'multiselect':
                                if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
                                    $attr = '';
                                    $options = '';
                                    foreach( $field['options'] as $key => $label ) {
                                        $options.= sprintf('<option value="%s" %s>%s</option>',
                                            $key,
                                            selected($value, $key, false),
                                            $label
                                        );
                                    }
                                    if( $field['type'] === 'multiselect' ){
                                        $attr = ' multiple="multiple" ';
                                    }
                                    printf( '<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
                                        $field['id'],
                                        $attr,
                                        $options
                                    );
                                }
                                break;

                        case 'checkbox':
                            printf('<input %s id="%s" name="%s" type="checkbox" value="1">',
                                $value === '1' ? 'checked' : '',
                                $field['id'],
                                $field['id']
                        );
                            break;

			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
    
}
new SantoroStudio_Settings_Page();
                