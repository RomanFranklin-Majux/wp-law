<?php defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * @package TheModernFirmFramework
 * @category Classes
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-Present The Modern Firm, LLC
 */
class TMF_Row {

	private $name;

	private $cell_count = 1;

	public function __construct($row_name = NULL, $collapse = FALSE, $classes = NULL) {
		$this->name = $row_name;
		$this->open($collapse, $classes);
	}


	public static function factory($row_name = NULL, $collapse = FALSE, $classes = NULL) {
		return new TMF_Row($row_name, $collapse, $classes);
	}


	private function open($collapse = FALSE, $classes = NULL) {
		$row_name	= ($this->name) ? 'id="' .strtolower($this->name) . '-row" ' : '';
		$collapse	= ($collapse) ? 'collapse-' . $collapse : '';
		$classes	= ($classes) ? strtolower($classes) : '';

		?>
			<div <?php echo $row_name ?> class="row <?php echo $collapse ?> <?php echo $classes ?>">
		<?php
	}


	public function cell($size, $static = FALSE, $min_size = NULL, $classes = NULL) {
		$cell_name	= ($this->name) ? 'id="' .strtolower($this->name) . '-cell-'. $this->cell_count .'" '  : '';
		$static		= ($static) ? ' static' : '';
		$min_size	= ($min_size) ? ' min-span-' . $min_size : '';
		$classes	= ($classes) ? strtolower(' ' . $classes) : '';

		if ($this->cell_count > 1)
			$this->cell_close();

		?>
		<div <?php echo $cell_name ?> class="cell span-<?php echo $size ?><?php echo $static ?><?php echo $min_size ?><?php echo $classes ?>">
			<div class="inner">
		<?php

		$this->cell_count++;
	}


	public function close($row_name = NULL) {
		echo "</div></div></div>";
	}


	private static function cell_close() {
		echo "</div></div>";
	}
}
