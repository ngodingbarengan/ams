<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	http://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Shopping po Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping po
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/po.html
 * @deprecated	3.0.0	This class is too specific for CI.
 */
class CI_Purchase_order {

	/**
	 * These are the regular expression rules that we use to validate the product ID and product name
	 * alpha-numeric, dashes, underscores, or periods
	 *
	 * @var string
	 */
	public $product_id_rules = '\.a-z0-9_-';

	/**
	 * These are the regular expression rules that we use to validate the product ID and product name
	 * alpha-numeric, dashes, underscores, colons or periods
	 *
	 * @var string
	 */
	//public $product_name_rules = '\w \-\.\:';
	public $product_name_rules = '^.';
	//merubah regex $product_name_rules agar bisa menerima karakter inputan apapun
	
	/**
	 * only allow safe product names
	 *
	 * @var bool
	 */
	public $product_name_safe = TRUE;

	// --------------------------------------------------------------------------

	/**
	 * Reference to CodeIgniter instance
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Contents of the po
	 *
	 * @var array
	 */
	protected $_po_contents = array();

	/**
	 * Shopping Class Constructor
	 *
	 * The constructor loads the Session class, used to store the shopping po contents.
	 *
	 * @param	array
	 * @return	void
	 */
	public function __construct($params = array())
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = is_array($params) ? $params : array();

		// Load the Sessions class
		$this->CI->load->driver('session', $config);

		// Grab the shopping po array from the session table
		$this->_po_contents = $this->CI->session->userdata('po_contents');
		if ($this->_po_contents === NULL)
		{
			// No po exists so we'll set some base values
			$this->_po_contents = array('po_total' => 0, 'total_items' => 0);
		}

		log_message('info', 'po Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Insert items into the po and save it to the session table
	 *
	 * @param	array
	 * @return	bool
	 */
	public function insert($items = array())
	{
		// Was any po data passed? No? Bah...
		if ( ! is_array($items) OR count($items) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// You can either insert a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one. The way we
		// determine the array type is by looking for a required array key named "id"
		// at the top level. If it's not found, we will assume it's a multi-dimensional array.

		$save_po = FALSE;
		if (isset($items['id']))
		{
			if (($rowid = $this->_insert($items)))
			{
				$save_po = TRUE;
			}
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) && isset($val['id']))
				{
					if ($this->_insert($val))
					{
						$save_po = TRUE;
					}
				}
			}
		}

		// Save the po data if the insert was successful
		if ($save_po === TRUE)
		{
			$this->_save_po();
			return isset($rowid) ? $rowid : TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert
	 *
	 * @param	array
	 * @return	bool
	 */
	protected function _insert($items = array())
	{
		// Was any po data passed? No? Bah...
		if ( ! is_array($items) OR count($items) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Does the $items array contain an id, quantity, price, and name?  These are required
		if ( ! isset($items['id'], $items['qty'], $items['price'], $items['code'], $items['name']))
		{
			log_message('error', 'The po array must contain a product ID, quantity, price, code, and name.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the quantity. It can only be a number.  Duh... also trim any leading zeros
		$items['qty'] = (float) $items['qty'];

		// If the quantity is zero or blank there's nothing for us to do
		if ($items['qty'] == 0)
		{
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product ID. It can only be alpha-numeric, dashes, underscores or periods
		// Not totally sure we should impose this rule, but it seems prudent to standardize IDs.
		// Note: These can be user-specified by setting the $this->product_id_rules variable.
		if ( ! preg_match('/^['.$this->product_id_rules.']+$/i', $items['id']))
		{
			log_message('error', 'Invalid product ID.  The product ID can only contain alpha-numeric characters, dashes, and underscores');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product name. It can only be alpha-numeric, dashes, underscores, colons or periods.
		// Note: These can be user-specified by setting the $this->product_name_rules variable.
		if ($this->product_name_safe && ! preg_match('/^['.$this->product_name_rules.']+$/i'.(UTF8_ENABLED ? 'u' : ''), $items['name']))
		{
			log_message('error', 'An invalid name was submitted as the product name: '.$items['name'].' The name can only contain alpha-numeric characters, dashes, underscores, colons, and spaces');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the price. Remove leading zeros and anything that isn't a number or decimal point.
		$items['price'] = (float) $items['price'];

		// We now need to create a unique identifier for the item being inserted into the po.
		// Every time something is added to the po it is stored in the master po array.
		// Each row in the po array, however, must have a unique index that identifies not only
		// a particular product, but makes it possible to store identical products with different options.
		// For example, what if someone buys two identical t-shirts (same product ID), but in
		// different sizes?  The product ID (and other attributes, like the name) will be identical for
		// both sizes because it's the same shirt. The only difference will be the size.
		// Internally, we need to treat identical submissions, but with different options, as a unique product.
		// Our solution is to convert the options array to a string and MD5 it along with the product ID.
		// This becomes the unique "row ID"
		if (isset($items['options']) && count($items['options']) > 0)
		{
			$rowid = md5($items['id'].serialize($items['options']));
		}
		else
		{
			// No options were submitted so we simply MD5 the product ID.
			// Technically, we don't need to MD5 the ID in this case, but it makes
			// sense to standardize the format of array indexes for both conditions
			$rowid = md5($items['id']);
		}

		// --------------------------------------------------------------------

		// Now that we have our unique "row ID", we'll add our po items to the master array
		// grab quantity if it's already there and add it on
		$old_quantity = isset($this->_po_contents[$rowid]['qty']) ? (int) $this->_po_contents[$rowid]['qty'] : 0;

		// Re-create the entry, just to make sure our index contains only the data from this submission
		$items['rowid'] = $rowid;
		$items['qty'] += $old_quantity;
		$this->_po_contents[$rowid] = $items;

		return $rowid;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the po
	 *
	 * This function permits the quantity of a given item to be changed.
	 * Typically it is called from the "view po" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * product ID and quantity for each item.
	 *
	 * @param	array
	 * @return	bool
	 */
	public function update($items = array())
	{
		// Was any po data passed?
		if ( ! is_array($items) OR count($items) === 0)
		{
			return FALSE;
		}

		// You can either update a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one.  The way we
		// determine the array type is by looking for a required array key named "rowid".
		// If it's not found we assume it's a multi-dimensional array
		$save_po = FALSE;
		if (isset($items['rowid']))
		{
			if ($this->_update($items) === TRUE)
			{
				$save_po = TRUE;
			}
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) && isset($val['rowid']))
				{
					if ($this->_update($val) === TRUE)
					{
						$save_po = TRUE;
					}
				}
			}
		}

		// Save the po data if the insert was successful
		if ($save_po === TRUE)
		{
			$this->_save_po();
			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the po
	 *
	 * This function permits changing item properties.
	 * Typically it is called from the "view po" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * rowid and quantity for each item.
	 *
	 * @param	array
	 * @return	bool
	 */
	protected function _update($items = array())
	{
		// Without these array indexes there is nothing we can do
		if ( ! isset($items['rowid'], $this->_po_contents[$items['rowid']]))
		{
			return FALSE;
		}

		// Prep the quantity
		if (isset($items['qty']))
		{
			$items['qty'] = (float) $items['qty'];
			// Is the quantity zero?  If so we will remove the item from the po.
			// If the quantity is greater than zero we are updating
			if ($items['qty'] == 0)
			{
				unset($this->_po_contents[$items['rowid']]);
				return TRUE;
			}
		}

		// find updatable keys
		$keys = array_intersect(array_keys($this->_po_contents[$items['rowid']]), array_keys($items));
		// if a price was passed, make sure it contains valid data
		if (isset($items['price']))
		{
			$items['price'] = (float) $items['price'];
		}

		// product id & name shouldn't be changed
		foreach (array_diff($keys, array('id', 'name')) as $key)
		{
			$this->_po_contents[$items['rowid']][$key] = $items[$key];
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Save the po array to the session DB
	 *
	 * @return	bool
	 */
	protected function _save_po()
	{
		// Let's add up the individual prices and set the po sub-total
		$this->_po_contents['total_items'] = $this->_po_contents['po_total'] = 0;
		foreach ($this->_po_contents as $key => $val)
		{
			// We make sure the array contains the proper indexes
			if ( ! is_array($val) OR ! isset($val['price'], $val['qty']))
			{
				continue;
			}

			$this->_po_contents['po_total'] += ($val['price'] * $val['qty']);
			$this->_po_contents['total_items'] += $val['qty'];
			$this->_po_contents[$key]['subtotal'] = ($this->_po_contents[$key]['price'] * $this->_po_contents[$key]['qty']);
		}

		// Is our po empty? If so we delete it from the session
		if (count($this->_po_contents) <= 2)
		{
			$this->CI->session->unset_userdata('po_contents');

			// Nothing more to do... coffee time!
			return FALSE;
		}

		// If we made it this far it means that our po has data.
		// Let's pass it to the Session class so it can be stored
		$this->CI->session->set_userdata(array('po_contents' => $this->_po_contents));

		// Woot!
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * po Total
	 *
	 * @return	int
	 */
	public function total()
	{
		return $this->_po_contents['po_total'];
	}

	// --------------------------------------------------------------------

	/**
	 * Remove Item
	 *
	 * Removes an item from the po
	 *
	 * @param	int
	 * @return	bool
	 */
	 public function remove($rowid)
	 {
		// unset & save
		unset($this->_po_contents[$rowid]);
		$this->_save_po();
		return TRUE;
	 }

	// --------------------------------------------------------------------

	/**
	 * Total Items
	 *
	 * Returns the total item count
	 *
	 * @return	int
	 */
	public function total_items()
	{
		return $this->_po_contents['total_items'];
	}

	// --------------------------------------------------------------------

	/**
	 * po Contents
	 *
	 * Returns the entire po array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function contents($newest_first = FALSE)
	{
		// do we want the newest first?
		$po = ($newest_first) ? array_reverse($this->_po_contents) : $this->_po_contents;

		// Remove these so they don't create a problem when showing the po table
		unset($po['total_items']);
		unset($po['po_total']);

		return $po;
	}

	// --------------------------------------------------------------------

	/**
	 * Get po item
	 *
	 * Returns the details of a specific item in the po
	 *
	 * @param	string	$row_id
	 * @return	array
	 */
	public function get_item($row_id)
	{
		return (in_array($row_id, array('total_items', 'po_total'), TRUE) OR ! isset($this->_po_contents[$row_id]))
			? FALSE
			: $this->_po_contents[$row_id];
	}

	// --------------------------------------------------------------------

	/**
	 * Has options
	 *
	 * Returns TRUE if the rowid passed to this function correlates to an item
	 * that has options associated with it.
	 *
	 * @param	string	$row_id = ''
	 * @return	bool
	 */
	public function has_options($row_id = '')
	{
		return (isset($this->_po_contents[$row_id]['options']) && count($this->_po_contents[$row_id]['options']) !== 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Product options
	 *
	 * Returns the an array of options, for a particular product row ID
	 *
	 * @param	string	$row_id = ''
	 * @return	array
	 */
	public function product_options($row_id = '')
	{
		return isset($this->_po_contents[$row_id]['options']) ? $this->_po_contents[$row_id]['options'] : array();
	}

	// --------------------------------------------------------------------

	/**
	 * Format Number
	 *
	 * Returns the supplied number with commas and a decimal point.
	 *
	 * @param	float
	 * @return	string
	 */
	public function format_number($n = '')
	{
		return ($n === '') ? '' : number_format( (float) $n, 2, '.', ',');
	}

	// --------------------------------------------------------------------

	/**
	 * Destroy the po
	 *
	 * Empties the po and kills the session
	 *
	 * @return	void
	 */
	public function destroy()
	{
		$this->_po_contents = array('po_total' => 0, 'total_items' => 0);
		$this->CI->session->unset_userdata('po_contents');
	}

}
