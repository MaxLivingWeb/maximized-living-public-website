<?php

/**
 * W3 Total Cache is active
 */
if ( defined( 'W3TC' ) ) {

    /**
     * Clear Page Cache - W3 Total Cache
     */
    function arcaneClearCache() {
        if ( function_exists( 'w3tc_pgcache_flush' ) ) {
            w3tc_pgcache_flush();
        }
    }

    /**
     *
     * Clear Cache on ACF Post Save
     *
     * @param $post_id
     *
     * @return mixed
     */
    function acf_save_clear_cache( $post_id ) {

        // just execute if the $post_id has either of these Values. Skip on Autosave
        if ( ( $post_id === 0 || $post_id === 'options' ) && ! defined( 'DOING_AUTOSAVE' ) ) {
            arcaneClearCache();
        }

        return $post_id;

    }

    add_action( 'acf/save_post', 'acf_save_clear_cache', 1 );

    /**
     *
     * Hour Cache Clear Cron Scheduler
     *
     * @param $schedules
     *
     * @return mixed
     */
    function hourly_cache_clear_cron_schedule( $schedules ) {
        $schedules['cache_clear_hourly'] = array(
            'interval' => 3600, // Every hour
            'display'  => __( 'Cache Clear Hourly' ),
        );

        return $schedules;
    }

    add_filter( 'cron_schedules', 'hourly_cache_clear_cron_schedule' );

    //Schedule an action if it's not already scheduled
    if ( ! wp_next_scheduled( 'HourCacheClear' ) ) {
        wp_schedule_event( time(), 'cache_clear_hourly', 'HourCacheClear' );
    }

    add_action( 'HourCacheClear', 'hour_cache_clear' );

    /**
     * Call clear cache function
     */
    function hour_cache_clear() {
        arcaneClearCache();
    }

    // Dump WP Crons for debugging
    //wp_die(var_dump(get_option( 'cron' )));

}
