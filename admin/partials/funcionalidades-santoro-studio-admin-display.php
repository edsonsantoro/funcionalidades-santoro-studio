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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h1><?php __('Funcionalidades - Santoro Studio', 'funcionalidades-santoro-studio'); ?></h1>

    <form method="post" action="options.php">
        <?php settings_fields( 'sds-funcionalidades-group' ); ?>
    </form>
</div>