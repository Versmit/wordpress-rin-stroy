<?php

namespace WebpConverter\Error;

use WebpConverter\Conversion\Format\FormatFactory;
use WebpConverter\Error\Detector\CloudflareStatusDetector;
use WebpConverter\Error\Detector\CurlLibraryDetector;
use WebpConverter\Error\Detector\LibsNotInstalledDetector;
use WebpConverter\Error\Detector\LibsWithoutWebpSupportDetector;
use WebpConverter\Error\Detector\PassthruExecutionDetector;
use WebpConverter\Error\Detector\PathsErrorsDetector;
use WebpConverter\Error\Detector\RewritesErrorsDetector;
use WebpConverter\Error\Detector\SettingsIncorrectDetector;
use WebpConverter\Error\Detector\TokenStatusDetector;
use WebpConverter\Error\Detector\UnsupportedServerDetector;
use WebpConverter\Error\Detector\WebpFormatActivatedDetector;
use WebpConverter\Error\Notice\NoticeInterface;
use WebpConverter\Error\Notice\RewritesCachedNotice;
use WebpConverter\HookableInterface;
use WebpConverter\PluginData;
use WebpConverter\PluginInfo;
use WebpConverter\Service\OptionsAccessManager;

/**
 * Supports generating list of server configuration errors.
 */
class ErrorDetectorAggregator implements HookableInterface {

	const ERRORS_CACHE_OPTION           = 'webpc_errors_cache';
	const ERROR_DETECTOR_DATE_TRANSIENT = 'webpc_error_detector';

	/**
	 * @var PluginInfo
	 */
	private $plugin_info;

	/**
	 * @var PluginData
	 */
	private $plugin_data;

	/**
	 * @var FormatFactory
	 */
	private $format_factory;

	/**
	 * @var string[]
	 */
	private $not_fatal_errors = [
		RewritesCachedNotice::ERROR_KEY,
	];

	/**
	 * @var NoticeInterface[]|null
	 */
	private $cached_errors = null;

	public function __construct(
		PluginInfo $plugin_info,
		PluginData $plugin_data,
		FormatFactory $format_factory
	) {
		$this->plugin_info    = $plugin_info;
		$this->plugin_data    = $plugin_data;
		$this->format_factory = $format_factory;
	}

	/**
	 * {@inheritdoc}
	 */
	public function init_hooks() {
		add_filter( 'webpc_server_errors', [ $this, 'get_server_errors' ], 10, 2 );
		add_filter( 'webpc_server_errors_messages', [ $this, 'get_server_errors_messages' ], 10, 1 );
	}

	/**
	 * Returns list of errors codes for server configuration.
	 *
	 * @param string[] $values      Default value of filter.
	 * @param bool     $only_errors Only errors, no warnings?
	 *
	 * @return string[]
	 */
	public function get_server_errors( array $values, bool $only_errors = false ): array {
		$error_codes = $this->get_cached_error_codes();

		return array_filter(
			$error_codes,
			function ( $error ) use ( $only_errors ) {
				return ( ! $only_errors || ! in_array( $error, $this->not_fatal_errors ) );
			}
		);
	}

	/**
	 * Returns list of errors messages for server configuration.
	 *
	 * @param string[] $values Default value of filter.
	 *
	 * @return string[][]
	 */
	public function get_server_errors_messages( array $values ): array {
		$detected_errors = $this->get_errors_list();
		$this->cache_errors( $detected_errors );

		$error_messages = [];
		foreach ( $detected_errors as $error ) {
			$error_messages[] = $error->get_message();
		}
		return $error_messages;
	}

	/**
	 * @return string[]
	 */
	private function get_cached_error_codes(): array {
		$error_codes = [];

		if ( $this->cached_errors !== null ) {
			foreach ( $this->cached_errors as $error ) {
				$error_codes[] = $error->get_key();
			}
		} else {
			$error_codes = OptionsAccessManager::get_option( self::ERRORS_CACHE_OPTION, [] );
		}

		return $error_codes;
	}

	/**
	 * @param NoticeInterface[] $detected_errors .
	 *
	 * @return void
	 */
	private function cache_errors( array $detected_errors ) {
		$error_codes = [];
		foreach ( $detected_errors as $error ) {
			$error_codes[] = $error->get_key();
		}

		OptionsAccessManager::update_option( self::ERRORS_CACHE_OPTION, $error_codes );
	}

	/**
	 * Checks for configuration errors according to specified logic.
	 * Saves errors to cache.
	 *
	 * @return NoticeInterface[]
	 */
	private function get_errors_list(): array {
		if ( $this->cached_errors !== null ) {
			return $this->cached_errors;
		}

		$this->pause_duplicated_detection();
		$this->cached_errors = [];

		if ( $new_error = ( new UnsupportedServerDetector() )->get_error() ) {
			$this->cached_errors[] = $new_error;
			return $this->cached_errors;
		}

		if ( $new_error = ( new TokenStatusDetector( $this->plugin_data ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		} elseif ( $new_error = ( new LibsNotInstalledDetector( $this->plugin_data ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		} elseif ( $new_error = ( new LibsWithoutWebpSupportDetector( $this->plugin_data ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		}

		if ( $new_error = ( new PathsErrorsDetector() )->get_error() ) {
			$this->cached_errors[] = $new_error;
		}

		if ( $new_error = ( new PassthruExecutionDetector( $this->plugin_info, $this->plugin_data, $this->format_factory ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		} elseif ( $new_error = ( new RewritesErrorsDetector( $this->plugin_info, $this->plugin_data, $this->format_factory ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		} elseif ( $new_error = ( new CurlLibraryDetector() )->get_error() ) {
			$this->cached_errors[] = $new_error;
		}

		if ( $this->cached_errors ) {
			return $this->cached_errors;
		}

		if ( $new_error = ( new SettingsIncorrectDetector( $this->plugin_data ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		}
		if ( $new_error = ( new CloudflareStatusDetector( $this->plugin_data ) )->get_error() ) {
			$this->cached_errors[] = $new_error;
		}

		return $this->cached_errors;
	}

	/**
	 * @return void
	 */
	private function pause_duplicated_detection() {
		$current_date = ( new \DateTime() )->format( 'Uv' );
		$cached_date  = get_site_transient( self::ERROR_DETECTOR_DATE_TRANSIENT );
		if ( $cached_date && ( $cached_date >= ( $current_date - 1000 ) ) ) {
			sleep( 1 );
			$current_date = ( new \DateTime() )->format( 'Uv' );
		}

		set_site_transient( self::ERROR_DETECTOR_DATE_TRANSIENT, $current_date );
	}
}
