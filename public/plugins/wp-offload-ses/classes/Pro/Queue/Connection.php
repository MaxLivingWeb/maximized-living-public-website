<?php

namespace DeliciousBrains\WP_Offload_SES\Pro\Queue;

use DeliciousBrains\WP_Offload_SES\Queue\Jobs\Email_Job;
use DeliciousBrains\WP_Offload_SES\WP_Offload_SES;
use DeliciousBrains\WP_Offload_SES\WP_Queue\Connections\DatabaseConnection;
use DeliciousBrains\WP_Offload_SES\WP_Queue\Job;

/**
 * Class Connection
 *
 * @since 1.0.0
 */
class Connection extends DatabaseConnection {

	/**
	 * Table to store jobs.
	 *
	 * @var string
	 */
	protected $jobs_table;

	/**
	 * Table to store failures.
	 *
	 * @var string
	 */
	protected $failures_table;

	/**
	 * Construct the Connection class.
	 *
	 * @param \wpdb $wpdb WordPress database class.
	 */
	public function __construct( $wpdb ) {
		parent::__construct( $wpdb );

		$this->jobs_table     = $this->database->base_prefix . 'oses_jobs';
		$this->failures_table = $this->database->base_prefix . 'oses_failures';
	}

	/**
	 * Retrieve a job by ID
	 *
	 * @param int $id The ID of the job to retrieve.
	 *
	 * @return bool|Job
	 */
	public function get_job( $id ) {
		$sql     = $this->database->prepare( "SELECT * FROM {$this->jobs_table} WHERE id = %d", $id );
		$raw_job = $this->database->get_row( $sql );

		if ( is_null( $raw_job ) ) {
			return false;
		}

		return $this->vitalize_job( $raw_job );
	}

	/**
	 * Push a job onto the failure queue and mark the email as failed in the email log.
	 *
	 * @param Email_Job  $job       The job that failed.
	 * @param \Exception $exception The exception that caused the failure.
	 *
	 * @return bool
	 */
	public function failure( $job, \Exception $exception ) {
		/** @var WP_Offload_SES $wp_offload_ses */
		global $wp_offload_ses;

		$wp_offload_ses->get_email_log()->update_email( $job->email_id, 'email_status', 'failed' );

		return parent::failure( $job, $exception );
	}

	/**
	 * Push a job onto the queue.
	 *
	 * @param object $job   The email job.
	 * @param int    $delay The delay for the job.
	 *
	 * @return bool|int
	 */
	public function push( \DeliciousBrains\WP_Offload_SES\WP_Queue\Job $job, $delay = 0 ) {
		$args = array(
			'job'          => serialize( $job ),
			'available_at' => $this->datetime( $delay ),
			'created_at'   => $this->datetime(),
		);

		if ( is_multisite() ) {
			$args['subsite_id'] = get_current_blog_id();
		}

		$result = $this->database->insert( $this->jobs_table, $args );

		if ( ! $result ) {
			return false;
		}

		return $this->database->insert_id;
	}

	/**
	 * Retrieve a job from the queue.
	 *
	 * @return bool|Job
	 */
	public function pop() {
		$this->release_reserved();

		$subsite_sql = '';

		if ( is_multisite() ) {
			$subsite_id  = get_current_blog_id();
			$subsite_sql = "AND subsite_id = $subsite_id";
		}

		$sql     = $this->database->prepare( "SELECT * FROM {$this->jobs_table} WHERE reserved_at IS NULL AND available_at <= %s $subsite_sql ORDER BY available_at LIMIT 1", $this->datetime() );
		$raw_job = $this->database->get_row( $sql );

		if ( is_null( $raw_job ) ) {
			return false;
		}

		$job = $this->vitalize_job( $raw_job );
		$this->reserve( $job );

		return $job;
	}

	/**
	 * Get total jobs in the queue.
	 *
	 * @return int
	 */
	public function jobs() {
		$sql = "SELECT COUNT(*) FROM {$this->jobs_table}";

		if ( is_multisite() ) {
			$sql = $this->database->prepare( "SELECT COUNT(*) FROM {$this->jobs_table} WHERE subsite_id = %d", get_current_blog_id() );
		}

		return (int) $this->database->get_var( $sql );
	}

}
