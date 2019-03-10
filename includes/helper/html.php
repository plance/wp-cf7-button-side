<?php
/**
 * HTML helper class. Provides generic methods for generating various HTML
 * tags and making output HTML safe.
 *
 * @package    Kohana
 * @category   Helpers
 * @author     Kohana Team
 * @copyright  (c) 2007-2010 Kohana Team
 * @license    http://kohanaframework.org/license
 */

class WpCf7BtnSideCore_Helper_Html {

	/**
	 * @var  array  preferred order of attributes
	 */
	public static $attribute_order = array
	(
		'action',
		'method',
		'type',
		'id',
		'name',
		'value',
		'href',
		'src',
		'width',
		'height',
		'cols',
		'rows',
		'size',
		'maxlength',
		'rel',
		'media',
		'accept-charset',
		'accept',
		'tabindex',
		'accesskey',
		'alt',
		'title',
		'class',
		'style',
		'selected',
		'checked',
		'readonly',
		'disabled',
	);

	/**
	 * @var  boolean  automatically target external URLs to a new window?
	 */
	public static $windowed_urls = FALSE;

	/**
	 * @var  string  Character set of input and output. Set by [Kohana::init]
	 */
	public static $charset = 'utf-8';

	/**
	 * Convert special characters to HTML entities. All untrusted content
	 * should be passed through this method to prevent XSS injections.
	 *
	 *     echo self::chars($username);
	 *
	 * @param   string   string to convert
	 * @param   boolean  encode existing entities
	 * @return  string
	 */
	public static function chars($value, $double_encode = TRUE)
	{
		return htmlspecialchars( (string) $value, ENT_QUOTES, self::$charset, $double_encode);
	}

	/**
	 * Convert all applicable characters to HTML entities. All characters
	 * that cannot be represented in HTML with the current character set
	 * will be converted to entities.
	 *
	 *     echo self::entities($username);
	 *
	 * @param   string   string to convert
	 * @param   boolean  encode existing entities
	 * @return  string
	 */
	public static function entities($value, $double_encode = TRUE)
	{
		return htmlentities( (string) $value, ENT_QUOTES, self::$charset, $double_encode);
	}

	/**
	 * Create HTML link anchors. Note that the title is not escaped, to allow
	 * HTML elements within links (images, etc).
	 *
	 *     echo self::anchor('/user/profile', 'My Profile');
	 *
	 * @param   string  URL or URI string
	 * @param   string  link text
	 * @param   array   HTML anchor attributes
	 * @return  string
	 * @uses    HelperUrl::base()
	 * @uses    URL::site
	 * @uses    self::attributes
	 */
	public static function anchor($uri, $title = NULL, array $attributes = NULL)
	{
		if ($title === NULL)
		{
			// Use the URI as the title
			$title = $uri;
		}

		// Add the sanitized link to the attributes
		$attributes['href'] = $uri;

		return '<a'.self::attributes($attributes).'>'.$title.'</a>';
	}

	/**
	 * Creates an HTML anchor to a file. Note that the title is not escaped,
	 * to allow HTML elements within links (images, etc).
	 *
	 *     echo self::file_anchor('media/doc/user_guide.pdf', 'User Guide');
	 *
	 * @param   string  name of file to link to
	 * @param   string  link text
	 * @param   array   HTML anchor attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function file_anchor($file, $title = NULL, array $attributes = NULL)
	{
		if ($title === NULL)
		{
			// Use the file name as the title
			$title = basename($file);
		}

		return '<a'.self::attributes($attributes).'>'.$title.'</a>';
	}

	/**
	 * Generates an obfuscated version of a string. Text passed through this
	 * method is less likely to be read by web crawlers and robots, which can
	 * be helpful for spam prevention, but can prevent legitimate robots from
	 * reading your content.
	 *
	 *     echo self::obfuscate($text);
	 *
	 * @param   string  string to obfuscate
	 * @return  string
	 * @since   3.0.3
	 */
	public static function obfuscate($string)
	{
		$safe = '';
		foreach (str_split($string) as $letter)
		{
			switch (rand(1, 3))
			{
				// HTML entity code
				case 1:
					$safe .= '&#'.ord($letter).';';
				break;

				// Hex character code
				case 2:
					$safe .= '&#x'.dechex(ord($letter)).';';
				break;

				// Raw (no) encoding
				case 3:
					$safe .= $letter;
			}
		}

		return $safe;
	}

	/**
	 * Generates an obfuscated version of an email address. Helps prevent spam
	 * robots from finding email addresses.
	 *
	 *     echo self::email($address);
	 *
	 * @param   string  email address
	 * @return  string
	 * @uses    self::obfuscate
	 */
	public static function email($email)
	{
		// Make sure the at sign is always obfuscated
		return str_replace('@', '&#64;', self::obfuscate($email));
	}

	/**
	 * Creates an email (mailto:) anchor. Note that the title is not escaped,
	 * to allow HTML elements within links (images, etc).
	 *
	 *     echo self::mailto($address);
	 *
	 * @param   string  email address to send to
	 * @param   string  link text
	 * @param   array   HTML anchor attributes
	 * @return  string
	 * @uses    self::email
	 * @uses    self::attributes
	 */
	public static function mailto($email, $title = NULL, array $attributes = NULL)
	{
		// Obfuscate email address
		$email = self::email($email);

		if ($title === NULL)
		{
			// Use the email address as the title
			$title = $email;
		}

		return '<a href="&#109;&#097;&#105;&#108;&#116;&#111;&#058;'.$email.'"'.self::attributes($attributes).'>'.$title.'</a>';
	}

	/**
	 * Creates a style sheet link element.
	 *
	 *     echo self::style('media/css/screen.css');
	 *
	 * @param   string  file name
	 * @param   array   default attributes
	 * @param   boolean  include the index page
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function style($file, array $attributes = NULL, $index = FALSE)
	{
		// Set the stylesheet link
		$attributes['href'] = $file;

		// Set the stylesheet rel
		$attributes['rel'] = 'stylesheet';

		// Set the stylesheet type
		$attributes['type'] = 'text/css';

		return '<link'.self::attributes($attributes).' />';
	}

	/**
	 * Creates a script link.
	 *
	 *     echo self::script('media/js/jquery.min.js');
	 *
	 * @param   string   file name
	 * @param   array    default attributes
	 * @param   boolean  include the index page
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function script($file, array $attributes = NULL, $index = FALSE)
	{
		// Set the script link
		$attributes['src'] = $file;

		// Set the script type
		$attributes['type'] = 'text/javascript';

		return '<script'.self::attributes($attributes).'></script>';
	}

	/**
	 * Creates a image link.
	 *
	 *     echo self::image('media/img/logo.png', array('alt' => 'My Company'));
	 *
	 * @param   string   file name
	 * @param   array    default attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function image($file, array $attributes = NULL)
	{
		// Add the image link
		$attributes['src'] = $file;

		return '<img'.self::attributes($attributes).' />';
	}


	/**
	 * Creates a form label. Label text is not automatically translated.
	 *
	 *     echo self::label('username', 'Username');
	 *
	 * @param   string  target input
	 * @param   string  label text
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function label($input, $text = NULL, array $attributes = NULL)
	{
		if ($text === NULL)
		{
			// Use the input name as the text
			$text = ucwords(preg_replace('/[\W_]+/', ' ', $input));
		}

		// Set the label target
		$attributes['for'] = $input;

		return '<label'.self::attributes($attributes).'>'.$text.'</label>';
	}
	
	/**
	 * Creates tag
	 * @param string $tag
	 * @param string $content
	 * @param array $attributes
	 * @return string
	 */
	public static function tag($tag, $content, array $attributes = NULL)
	{
		return '<'.$tag.self::attributes($attributes).'>'.$content.'</'.$tag.'>';
	}
	
	/**
	 * Compiles an array of HTML attributes into an attribute string.
	 * Attributes will be sorted using self::$attribute_order for consistency.
	 *
	 *     echo '<div'.self::attributes($attrs).'>'.$content.'</div>';
	 *
	 * @param   array   attribute list
	 * @return  string
	 */
	public static function attributes(array $attributes = NULL)
	{
		if (empty($attributes))
			return '';

		$sorted = array();
		foreach (self::$attribute_order as $key)
		{
			if (isset($attributes[$key]))
			{
				// Add the attribute to the sorted list
				$sorted[$key] = $attributes[$key];
			}
		}

		// Combine the sorted attributes
		$attributes = $sorted + $attributes;

		$compiled = '';
		foreach ($attributes as $key => $value)
		{
			if ($value === NULL)
			{
				// Skip attributes that have NULL values
				continue;
			}

			if (is_int($key))
			{
				// Assume non-associative keys are mirrored attributes
				$key = $value;
			}

			// Add the attribute value
			$compiled .= ' '.$key.'="'.self::chars($value).'"';
		}

		return $compiled;
	}

	//===========================================================
	//  FORM FIELDS
	//===========================================================


	/**
	 * Generates an opening HTML form tag.
	 *
	 *     // Form will submit back to the current page using POST
	 *     echo self::open();
	 *
	 *     // Form will submit to 'search' using GET
	 *     echo self::open('search', array('method' => 'get'));
	 *
	 *     // When "file" inputs are present, you must include the "enctype"
	 *     echo self::open(NULL, array('enctype' => 'multipart/form-data'));
	 *
	 * @param   string  form action, defaults to the current request URI
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function formOpen($action, array $attributes = NULL)
	{
		$attributes['action'] = $action;

		if (!isset($attributes['method']))
		{
			// Use POST method
			$attributes['method'] = 'post';
		}

		return '<form'.self::attributes($attributes).'>';
	}

	/**
	 * Creates the closing form tag.
	 *
	 *     echo self::close();
	 *
	 * @return  string
	 */
	public static function formClose()
	{
		return '</form>';
	}

	/**
	 * Creates a form input. If no type is specified, a "text" type input will
	 * be returned.
	 *
	 *     echo self::fieldInput('username', $username);
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function fieldInput($name, $value = NULL, array $attributes = NULL)
	{
		// Set the input name
		$attributes['name'] = $name;

		// Set the input value
		$attributes['value'] = $value;

		if ( ! isset($attributes['type']))
		{
			// Default type is text
			$attributes['type'] = 'text';
		}

		if ( ! isset($attributes['id']))
		{
			$attributes['id'] = $name;
		}

		return '<input'.self::attributes($attributes).' />';
	}

	/**
	 * Creates a hidden form input.
	 *
	 *     echo self::fieldHidden('csrf', $token);
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldHidden($name, $value = NULL, array $attributes = NULL)
	{
		$attributes['type'] = 'hidden';

		return self::fieldInput($name, $value, $attributes);
	}

	/**
	 * Creates a password form input.
	 *
	 *     echo self::fieldPassword('password');
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldPassword($name, $value = NULL, array $attributes = NULL)
	{
		$attributes['type'] = 'password';

		return self::fieldInput($name, $value, $attributes);
	}

	/**
	 * Creates a file upload form input. No input value can be specified.
	 *
	 *     echo self::file('image');
	 *
	 * @param   string  input name
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldFile($name, array $attributes = NULL)
	{
		$attributes['type'] = 'file';

		return self::fieldInput($name, NULL, $attributes);
	}

	/**
	 * Creates a checkbox form input.
	 *
	 *     echo self::fieldCheckbox('remember_me', 1, (bool) $remember);
	 *
	 * @param   string   input name
	 * @param   string   input value
	 * @param   boolean  checked status
	 * @param   array    html attributes
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldCheckbox($name, $value = NULL, $checked = FALSE, array $attributes = NULL)
	{
		$attributes['type'] = 'checkbox';

		if ($checked === TRUE)
		{
			// Make the checkbox active
			$attributes['checked'] = 'checked';
		}

		return self::fieldInput($name, $value, $attributes);
	}

	/**
	 * Creates a radio form input.
	 *
	 *     echo self::fieldRadio('like_cats', 1, $cats);
	 *     echo self::fieldRadio('like_cats', 0, ! $cats);
	 *
	 * @param   string   input name
	 * @param   string   input value
	 * @param   boolean  checked status
	 * @param   array    html attributes
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldRadio($name, $value = NULL, $checked = FALSE, array $attributes = NULL)
	{
		$attributes['type'] = 'radio';

		if ($checked === TRUE)
		{
			// Make the radio active
			$attributes['checked'] = 'checked';
		}

		return self::fieldInput($name, $value, $attributes);
	}

	/**
	 * Creates a textarea form input.
	 *
	 *     echo self::fieldTextarea('about', $about);
	 *
	 * @param   string   textarea name
	 * @param   string   textarea body
	 * @param   array    html attributes
	 * @param   boolean  encode existing HTML characters
	 * @return  string
	 * @uses    self::attributes
	 * @uses    self::chars
	 */
	public static function fieldTextarea($name, $body = '', array $attributes = NULL, $double_encode = TRUE)
	{
		// Set the input name
		$attributes['name'] = $name;

		// Add default rows and cols attributes (required)
		$attributes += array('rows' => 10, 'cols' => 50);

		return '<textarea'.self::attributes($attributes).'>'.self::chars($body, $double_encode).'</textarea>';
	}

	/**
	 * Creates a select form input.
	 *
	 *     echo self::fieldSelect('country', $countries, $country);
	 *
	 * [!!] Support for multiple selected options was added in v3.0.7.
	 *
	 * @param   string   input name
	 * @param   array    available options
	 * @param   mixed    selected option string, or an array of selected options
	 * @param   array    html attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function fieldSelect($name, array $options = NULL, $selected = NULL, array $attributes = NULL)
	{
		// Set the input name
		$attributes['name'] = $name;

		if (is_array($selected))
		{
			// This is a multi-select, god save us!
			$attributes['multiple'] = 'multiple';
		}

		if ( ! is_array($selected))
		{
			if ($selected === NULL)
			{
				// Use an empty array
				$selected = array();
			}
			else
			{
				// Convert the selected options to an array
				$selected = array( (string) $selected);
			}
		}

		if (empty($options))
		{
			// There are no options
			$options = '';
		}
		else
		{
			foreach ($options as $value => $name)
			{
				if (is_array($name))
				{
					// Create a new optgroup
					$group = array('label' => $value);

					// Create a new list of options
					$_options = array();

					foreach ($name as $_value => $_name)
					{
						// Force value to be string
						$_value = (string) $_value;

						// Create a new attribute set for this option
						$option = array('value' => $_value);

						if (in_array($_value, $selected))
						{
							// This option is selected
							$option['selected'] = 'selected';
						}

						// Change the option to the HTML string
						$_options[] = '<option'.self::attributes($option).'>'.self::chars($_name, FALSE).'</option>';
					}

					// Compile the options into a string
					$_options = "\n".implode("\n", $_options)."\n";

					$options[$value] = '<optgroup'.self::attributes($group).'>'.$_options.'</optgroup>';
				}
				else
				{
					// Force value to be string
					$value = (string) $value;

					// Create a new attribute set for this option
					$option = array('value' => $value);

					if (in_array($value, $selected))
					{
						// This option is selected
						$option['selected'] = 'selected';
					}

					// Change the option to the HTML string
					$options[$value] = '<option'.self::attributes($option).'>'.self::chars($name, FALSE).'</option>';
				}
			}

			// Compile the options into a single string
			$options = "\n".implode("\n", $options)."\n";
		}

		return '<select'.self::attributes($attributes).'>'.$options.'</select>';
	}

	/**
	 * Creates a submit form input.
	 *
	 *     echo self::fieldSubmit(NULL, 'Login');
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldSubmit($name, $value, array $attributes = NULL)
	{
		$attributes['type'] = 'submit';
		$attributes['class'] = 'submit';

		return self::fieldInput($name, $value, $attributes);
	}

	/**
	 * Creates a image form input.
	 *
	 *     echo self::fieldImage(NULL, NULL, array('src' => 'media/img/login.png'));
	 *
	 * @param   string   input name
	 * @param   string   input value
	 * @param   array    html attributes
	 * @param   boolean  add index file to URL?
	 * @return  string
	 * @uses    self::input
	 */
	public static function fieldImage($name, $value, array $attributes = NULL)
	{
		$attributes['type'] = 'image';

		return self::fieldInput($name, $value, $attributes);
	}

	/**
	 * Creates a button form input. Note that the body of a button is NOT escaped,
	 * to allow images and other HTML to be used.
	 *
	 *     echo self::fieldButton('save', 'Save Profile', array('type' => 'submit'));
	 *
	 * @param   string  input name
	 * @param   string  input value
	 * @param   array   html attributes
	 * @return  string
	 * @uses    self::attributes
	 */
	public static function fieldButton($name, $body, array $attributes = NULL)
	{
		// Set the input name
		$attributes['name'] = $name;

		return '<button'.self::attributes($attributes).'>'.$body.'</button>';
	}
	
}