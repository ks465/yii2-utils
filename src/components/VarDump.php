<?php
/**
 * Created by PhpStorm.
 * User: keyhan
 * Date: 06/09/18
 * Time: 12:47
 */


namespace {

    use khans\utils\components\SqlFormatter;
    use khans\utils\components\VarDump;
    use khans\utils\Settings;
    use yii\db\Query;

    if (!function_exists('vd')) {
        /**
         * Shortcut to dump one or more variables for debug purposes
         *
         * @param mixed $variable List of variables to dump.
         *
         * @return void
         */
        function vd($variable)
        {
            $varDump = new VarDump(null, null, null);
            $variables = func_get_args();
            foreach ($variables as $variable) {
                $varDump->dump($variable);
            }
        }
    }
    if (!function_exists('vdd')) {
        /**
         * Shortcut to dump one or more variables for debug purposes. This function will stop your script after the dump.
         *
         * @param mixed $variables List of variables to dump.
         *
         * @return void
         */
        function vdd($variables)
        {
            call_user_func_array('vd', func_get_args());
            exit;
        }
    }
    if (!function_exists('explain')) {
        /**
         * Show a formatted text of an SQL query.
         *
         * @param string|Query $query
         *
         * @return void
         */
        function explain($query)
        {
            if ($query instanceof Query) {
                $query = $query->createCommand()->rawSql;
            }
            if (php_sapi_name() === 'cli') {
                echo getTrace() . "\n" . SqlFormatter::format($query);
            } else {
                echo '<p dir="ltr">' . getTrace() . '</p>';
                echo '<span dir="ltr">' . SqlFormatter::format($query) . '</span>';
            }

        }
    }
    if (!function_exists('xd')) {
        /**
         * Show a formatted text of an SQL query. This function will stop your script after the dump.
         *
         * @param string|Query $query
         *
         * @return void
         */
        function xd($query)
        {
            explain($query);

            exit;
        }
    }
    if (!function_exists('who')) {
        /**
         * Count online users by checking last modified time of session files.
         *
         * Make sure session save path is accessible.
         * If the counting idle time has passed, it may drop the current user in counting.
         *
         * @return bool|int
         */
        function who()
        {
            $path = session_save_path();

            if (!is_readable($path)) {
                return false;
            }
            if (trim($path) == "") {
                return false;
            }
            $d = dir($path);
            $i = 0;
            while (false !== ($entry = $d->read())) {
                if ($entry != "." and $entry != "..") {
                    if (time() - filemtime($path . "/$entry") < Settings::MAX_IDLE_TIME) {
                        $i++;
                    }
                }
            }
            $d->close();

            return $i;
        }
    }
    if (!function_exists('getTrace')) {
        /**
         * Gets the trace of the call before this class
         *
         * @return string File name and line number
         */
        function getTrace()
        {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

            do {
                $caller = array_shift($backtrace);
                if (isset($caller['file']) && $caller['file'] !== __FILE__) {
                    break;
                }
            } while ($caller);

            if (!$caller) {
                return null;
            }

            return $caller['file'] . ':' . $caller['line'];
        }
    }
}


namespace khans\utils\components {

    use Exception;
    use InvalidArgumentException;
    use ReflectionClass;
    use ReflectionException;
    use ReflectionMethod;


    /**
     * Interface for a theme of the dump output
     *
     * @version    0.1.0
     */
    interface VarDumpTheme
    {
        /**
         * Hook to generate output before the first variable dump
         *
         * @return string Output before the first variable dump
         */
        public function beforeFirstDump();

        /**
         * Hook to generate output before the variable dump
         *
         * @param string $trace File and line number where the output is generated
         *
         * @return string Output before the variable dump
         */
        public function beforeDump($trace);

        /**
         * Hook to generate output after the variable dump
         *
         * @return string Output after the variable dump
         */
        public function afterDump();

        /**
         * Hook to do things when the output is printed
         *
         * @return string Output after the print
         */
        public function afterOutput();

        /**
         * Formats a single value
         *
         * @param string  $type Type of the value
         * @param string  $short Short display of the value, a preview or teaser
         * @param string  $full Full display of the value
         * @param boolean $showType Flag to see if the type should be displayed
         * @param boolean $encode Encode for the output eg htmlentities
         *
         * @return string Output of the value
         */
        public function formatValue($type, $short, $full = null, $showType = true, $encode = true);

        /**
         * Formats a single list item
         *
         * @param string $key Formatted display of the key
         * @param string $value Formatted display of the value
         *
         * @return string Output of the list item
         */
        public function formatListItem($key, $value = null);

        /**
         * Formats a list from items
         *
         * @param array $items Items formatted by formatListItem
         *
         * @return string Output of the list
         * @see formatListItem
         */
        public function formatListItems(array $items);
    }

    /**
     * Class to print variables like var_dump
     */
    class VarDump
    {
        /**
         * Default maximum recursive depth
         *
         * @var integer
         */
        const DEFAULT_RECURSIVE_DEPTH = 10;

        /**
         * Default maximum length for the preview of a string
         *
         * @var integer
         */
        const DEFAULT_STRING_LENGTH = 100;

        /**
         * Default flag to see if object methods should be included
         *
         * @var boolean
         */
        const DEFAULT_METHODS = true;

        /**
         * Default theme for a CLI environment
         *
         * @var string
         */
        const DEFAULT_THEME_CLI = 'CliVarDumpTheme';

        /**
         * Default theme for a HTML environment
         *
         * @var string
         */
        const DEFAULT_THEME_HTML = 'BlackHtmlVarDumpTheme';

        /**
         * Current recursion level in process
         *
         * @var int
         */
        private $recursiveDepth;

        /**
         * Maximum level of recursions
         *
         * @var int
         */
        private $recursiveMaximum;

        /**
         * Maximum length for the preview of a string
         *
         * @var int
         */
        private $stringLength;

        /**
         * List of escaped characters to be replaced by literally characters
         *
         * @var array
         */
        private $stringSearch;

        /**
         * List of characters to replace the escaped characters
         *
         * @var array
         */
        private $stringReplace;

        /**
         * Flag to see if object methods should be included
         *
         * @var bool
         */
        private $includeMethods;

        /**
         * List of objects in the values
         *
         * @var array
         */
        private $objects;

        /**
         * @var bool
         */
        private $isPhp7;

        /**
         * Flag to distinguish start of dump
         *
         * @var bool
         */
        private $isFirst;

        /**
         * @var VarDumpTheme
         */
        private $theme;

        /**
         * Constructs a new dump
         *
         * @param integer      $recursiveDepth Maximum level of recursions
         * @param integer      $stringLength Maximum length for the preview of a string
         * @param boolean      $includeMethods Flag to see if object methods should be included
         * @param VarDumpTheme $theme Theme for the output, null for automatic
         *
         * @throws InvalidArgumentException
         */
        public function __construct($recursiveDepth = null, $stringLength = null, $includeMethods = null,
            VarDumpTheme $theme = null)
        {
            if ($recursiveDepth === null) {
                $recursiveDepth = isset($_ENV['VAR_DUMP_RECURSIVE_DEPTH']) ? $_ENV['VAR_DUMP_RECURSIVE_DEPTH'] : self::DEFAULT_RECURSIVE_DEPTH;
            }
            if (!is_numeric($recursiveDepth) || $recursiveDepth < 0) {
                throw new InvalidArgumentException('Could not set maximum recursive depth: number greater than 0 expected');
            }

            if ($stringLength === null) {
                $stringLength = isset($_ENV['VAR_DUMP_STRING_LENGTH']) ? $_ENV['VAR_DUMP_STRING_LENGTH'] : self::DEFAULT_STRING_LENGTH;
            }
            if (!is_numeric($stringLength) || $stringLength < 0) {
                throw new InvalidArgumentException('Could not set maximum string length: number greater than 0 expected');
            }

            if ($includeMethods === null) {
                $includeMethods = isset($_ENV['VAR_DUMP_METHODS']) ? $_ENV['VAR_DUMP_METHODS'] : self::DEFAULT_METHODS;
            }
            if (!is_bool($includeMethods)) {
                throw new InvalidArgumentException('Could not set include methods flag: boolean expected');
            }

            $this->recursiveDepth = 0;
            $this->recursiveMaximum = (integer)$recursiveDepth;

            $this->stringLength = (integer)$stringLength;
            $this->stringSearch = ["\0", "\a", "\b", "\f", "\n", "\r", "\t", "\v"];
            $this->stringReplace = ['\0', '\a', '\b', '\f', '\n', '\r', '\t', '\v'];

            $this->includeMethods = $includeMethods;
            $this->objects = [];

            $this->isFirst = true;
            $this->isPhp7 = version_compare(PHP_VERSION, '7.0.0') >= 0;

            try {
                $this->setTheme($theme);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        /**
         * Sets the theme of the dump
         *
         * @param VarDumpTheme $theme Theme to set, null for automatic
         *
         * @return void
         * @throws Exception
         */
        public function setTheme(VarDumpTheme $theme = null)
        {
            if ($theme == null) {
                if (php_sapi_name() === 'cli') {
                    $theme = isset($_ENV['VAR_DUMP_THEME_CLI']) ? $_ENV['VAR_DUMP_THEME_CLI'] : (__NAMESPACE__ . '\\' . self::DEFAULT_THEME_CLI);
                } else {
                    $theme = isset($_ENV['VAR_DUMP_THEME_HTML']) ? $_ENV['VAR_DUMP_THEME_HTML'] : (__NAMESPACE__ . '\\' . self::DEFAULT_THEME_HTML);
                }

                if (is_string($theme)) {
                    $theme = new $theme();
                }
            }
            if (!$theme instanceof VarDumpTheme) {
                throw new Exception('Could not set theme: instance of VarDumpTheme expected');
            }

            $this->theme = $theme;
        }

        /**
         * Prints any value for debug purposes
         *
         * @var mixed $value Value to print
         * @return void
         */
        public function dump($value)
        {
            $output = '';

            if ($this->isFirst) {
                $this->isFirst = false;

                $output .= $this->theme->beforeFirstDump();
            }

            $output .= $this->theme->beforeDump($this->getTrace());
            $output .= $this->getValue($value);
            $output .= $this->theme->afterDump();

            echo $output;

            $this->theme->afterOutput();
        }

        /**
         * Gets the trace of the call before this class
         *
         * @return string File name and line number
         */
        private function getTrace()
        {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

            do {
                $caller = array_shift($backtrace);
                if (isset($caller['file']) && $caller['file'] !== __FILE__) {
                    break;
                }
            } while ($caller);

            if (!$caller) {
                return null;
            }

            return $caller['file'] . ':' . $caller['line'];
        }

        /**
         * Gets the output for any value
         *
         * @param mixed   $value Value to get the output for
         * @param boolean $showType Flag to see if the type of value should be showed
         * @param boolean $encode Flag to see if the necessary output encoding should be done, set to false when a value
         *                          is formatted twice by the theme
         *
         * @return string Output of the value
         */
        private function getValue($value, $showType = true, $encode = true)
        {
            $type = gettype($value);

            switch ($type) {
                case 'boolean':
                    return $this->theme->formatValue('boolean', $value ? 'true' : 'false', null, $showType, $encode);
                case 'NULL':
                    return $this->theme->formatValue(null, 'null', null, $showType, $encode);
                case 'integer':
                case 'double':
                case 'resource':
                    return $this->theme->formatValue($type, (string)$value, null, $showType, $encode);
                case 'string':
                    return $this->getStringValue($value, $showType, $encode);
                case 'array':
                    return $this->getArrayValue($value, $showType, $encode);
                case 'object':
                    return $this->getObjectValue($value);
                default:
                    return $this->theme->formatValue('unknown', '???', null, $showType, $encode);
            }
        }

        /**
         * Gets the output for a string value
         *
         * @param string  $string String value to get the output for
         * @param boolean $showType Flag to see if the type of value should be  showed
         * @param boolean $encode Flag to see if the necessairy output encoding
         *                          should be done, set to false when a value is formatted twice by the theme
         *
         * @return string Output of the string
         */
        private function getStringValue($string, $showType, $encode)
        {
            $length = strlen($string);
            $string = str_replace($this->stringSearch, $this->stringReplace, $string);

            $short = substr($string, 0, $this->stringLength);
            if ($length > $this->stringLength) {
                $short .= '...';
            }

            $short = '"' . $short . '"';
            $string = '"' . $string . '"';

            if ($string != $short) {
                $full = $this->theme->formatValue(null, $string, null, false, true);
            } else {
                $full = null;
            }

            return $this->theme->formatValue('string(' . $length . ')', $short, $full, $showType, $encode);
        }

        /**
         * Gets the output for an array value
         *
         * @param array   $array Array value to get the output for
         * @param boolean $showType Flag to see if the type of value should be showed
         * @param boolean $encode Flag to see if the necessairy output encoding should be done, set to false when a
         *     value is formatted twice by the theme
         *
         * @return string Output of the array
         */
        private function getArrayValue($array, $showType, $encode)
        {
            $numItems = count($array);
            if ($numItems == 0) {
                // empty array
                return $this->theme->formatValue('array(0)', '[]', null, $showType, $encode);
            } elseif ($this->recursiveDepth == $this->recursiveMaximum) {
                // too deep in recursiveness
                return $this->theme->formatValue('array(' . $numItems . ')', '[...]', null, $showType, $encode);
            }

            // retrieve array dump
            $this->recursiveDepth++;

            $items = [];
            foreach ($array as $key => $value) {
                $items[$key] = $this->theme->formatListItem($this->getValue($key), $this->getValue($value));
            }

            $this->recursiveDepth--;

            return $this->theme->formatValue('array(' . $numItems . ')', '[...]', $this->theme->formatListItems($items), $showType);
        }

        /**
         * Gets the output for an object instance
         *
         * @param mixed $object Object instance to get the output for
         *
         * @return string Output of the object
         */
        private function getObjectValue($object)
        {
            $className = get_class($object);
            $objectId = 0;

            $id = array_search($object, $this->objects, true);
            if ($id !== false) {
                // already retrieved this instance
                return $this->theme->formatValue($className . '#' . $id, '{...}', null);
            } elseif ($this->recursiveDepth == $this->recursiveMaximum) {
                // too deep in recursiveness
                $objectId++;

                return $this->theme->formatValue($className . '#' . $objectId, '{...}', null);
            }

            // retrieve object instance dump
            /** @noinspection PhpUnusedLocalVariableInspection */
            $id = $objectId++;
            $this->recursiveDepth++;

            $items = [];

            // instance properties
            $properties = (array)$object;
            foreach ($properties as $property => $value) {
                $name = str_replace("\0", ':', trim($property));
                if (strpos($name, ':')) {
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    list($type, $name) = explode(':', $name);
                }

                $name = '$' . $name;

                $items[$name] = $this->theme->formatListItem($this->getValue($name, false), $this->getValue($value, false));
            }

            // instance methods
            if ($this->includeMethods) {
                try {
                    $class = new ReflectionClass($className);
                    $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

                    foreach ($methods as $method) {
                        $items[] = $this->theme->formatListItem($this->getValue($this->getMethodSignature($method), false), null);
                    }
                } catch (ReflectionException $e) {
                    $items[] = 'Could not get methods, because of: ' . $e->getMessage();
                }

            }

            $this->recursiveDepth--;

            $this->objects[$id] = $object;

            ksort($items);

            return $this->theme->formatValue($className . '#' . $id, '{...}', $this->theme->formatListItems($items));
        }

        /**
         * Gets the signature of a method
         *
         * @param ReflectionMethod $method
         *
         * @return string
         */
        private function getMethodSignature(ReflectionMethod $method)
        {
            $parameters = $method->getParameters();
            foreach ($parameters as $index => $parameter) {
                $value = '';

                if ($this->isPhp7 && $parameter->hasType()) {
                    $value .= $parameter->getType() . ' ';
                }

                $value .= '$' . $parameter->getName();

                if ($parameter->isOptional()) {
                    $defaultValue = $this->getValue($parameter->getDefaultValue(), false, false);
                    $value .= ' = ' . $defaultValue;
                }
                $parameters[$index] = $value;
            }

            return $method->getName() . '(' . implode(', ', $parameters) . ')';
        }
    }

    /**
     * CLI dump theme
     */
    class CliVarDumpTheme implements VarDumpTheme
    {
        /**
         * @inheritdoc
         */
        public function beforeFirstDump()
        {
            return null;
        }

        /**
         * @inheritdoc
         */
        public function beforeDump($trace)
        {
            return "\n[" . $trace . "]\n";
        }

        /**
         * @inheritdoc
         */
        public function afterDump()
        {
            return "\n";
        }

        /**
         * @inheritdoc
         */
        public function afterOutput()
        {
        }

        /**
         * @inheritdoc
         */
        public function formatValue($type, $short, $full = null, $showType = true, $encode = true)
        {
            $output = '';

            if ($showType && $type) {
                $output .= $type . ' ';
            }

            if ($full && $full !== $short) {
                $output .= $short;
                $lines = explode("\n", (string)$full);
                foreach ($lines as $line) {
                    $output .= "\n    " . $line;
                }
            } else {
                $output .= (string)$short;
            }

            return $output;
        }

        /**
         * @inheritdoc
         */
        public function formatListItem($key, $value = null)
        {
            return '- ' . $key . ($value !== null ? ' => ' . $value : '');
        }

        /**
         * @inheritdoc
         */
        public function formatListItems(array $items)
        {
            return implode("\n", $items);
        }
    }

    /**
     * File dump theme
     */
    class FileVarDumpTheme extends CliVarDumpTheme
    {
        /**
         * Output filename
         *
         * @var string
         */
        private $file;

        /**
         * Output dump size
         *
         * @var int|string
         */
        private $truncateSize;
        private $sessionSeparator = "=====================";
        private $dumpSeparator = "---------------------";

        /**
         * FileVarDumpTheme constructor.
         *
         * @param     $file
         * @param int $truncateSize
         */
        public function __construct($file, $truncateSize = 1024)
        {
            if (!is_string($file) || $file === '') {
                throw new InvalidArgumentException('Could not set file: non empty string expected');
            }

            if (!is_numeric($truncateSize) || $truncateSize <= 0) {
                throw new InvalidArgumentException('Could not set truncate size: number greater than 0 expected');
            }

            $this->file = $file;
            $this->truncateSize = $truncateSize;
        }

        /**
         * @inheritdoc
         */
        public function beforeFirstDump()
        {
            return "\n" . $this->sessionSeparator . "\n" . date("Y-m-d H:i:s") . "\n";
        }

        /**
         * @inheritdoc
         */
        public function beforeDump($trace)
        {
            ob_start();

            return "\n[" . $trace . "]\n";
        }

        /**
         * @inheritdoc
         */
        public function afterDump()
        {
            return "\n" . $this->dumpSeparator . "\n";
        }

        /**
         * @inheritdoc
         * @throws Exception
         */
        public function afterOutput()
        {
            $output = ob_get_contents();
            ob_end_clean();

            $status = @file_put_contents($this->file, $output, FILE_APPEND | LOCK_EX);
            if ($status === false) {
                throw new Exception('Could not write to ' . $this->file);
            }

            $fileSize = filesize($this->file) / 1024; // we work with kb
            if ($fileSize < $this->truncateSize) {
                return;
            }

            if (strlen($output) * 1024 > $this->truncateSize) {
                $output = '';
            }

            $status = @file_put_contents($this->file, $output, LOCK_EX);
            if ($status === false) {
                throw new Exception('Could not write to ' . $this->file);
            }
        }
    }

    /**
     * HTML dump theme
     */
    class HtmlVarDumpTheme implements VarDumpTheme
    {
        /**
         * Id of the print call
         *
         * @var integer
         */
        private static $printId = 1;
        /**
         * Id of the current element
         *
         * @var integer
         */
        private static $elementId = 1;
        /**
         * @var array
         * Color definitions
         */
        protected $colors;
        /**
         * @var array
         * Style definitions
         */
        protected $styles;

        /**
         * Constructs a new HTML theme
         *
         * @return null
         */
        public function __construct()
        {
            if (!$this->colors) {
                $this->colors = [
                    'general-background' => 'whitesmoke',
                    'general-text'       => 'black',
                    'general-link'       => 'black',
                    'general-border'     => 'black',
                    'code-background'    => 'white',
                    'code-text'          => 'red',
                ];
            }

            $this->styles = [
                'container'     => 'font-family: monospace; padding: 1em; margin: 1em; line-height: 1.5em; border-radius: 5px; border: 1px solid ' .
                    $this->colors['general-border'] . '; color: ' . $this->colors['general-text'] . '; background-color: ' . $this->colors['general-background'],
                'trace'         => 'font-size: 0.8em',
                'link'          => 'font-size: 0.8em; color: ' . $this->colors['general-link'],
                'code'          => 'background-color: ' . $this->colors['code-background'] . '; color: ' . $this->colors['code-text'],
                'list'          => 'list-style: none; margin: 0; padding: 0 0 0 1.5em',
                'list-item'     => 'margin: 0',
                'expand-string' => 'margin-left: 1.5em',
                'expand-block'  => 'display: none',
            ];
        }

        /**
         * @inheritdoc
         */
        public function beforeFirstDump()
        {
            return '<script>
            function gotoVardump(id) {
                expandAllVardump(' . self::$printId . ');

                var url = "" + window.location;

                window.location = url.replace(/#[A-Za-z0-9_-]*$/, "") + "#vardump-anchor-" + id;

                history.replaceState(null, null, url);

                return false;
            }

            function expandAllVardump(id) {
                document.body.style.cursor = "progress";

                var blocks = document.getElementsByClassName("vardump-block-" + id);
                for (var i = 0, l = blocks.length; i < l; i++) {
                    blocks[i].style.display = "block";
                }

                var links = document.getElementsByClassName("vardump-link-" + id);
                for (var i = 0, l = links.length; i < l; i++) {
                    links[i].innerHTML = "[reduce]";
                }

                document.body.style.cursor = "default";

                return false;
            }

            function reduceAllVardump(id) {
                document.body.style.cursor = "wait";

                var blocks = document.getElementsByClassName("vardump-block-" + id);
                for (var i = 0, l = blocks.length; i < l; i++) {
                    blocks[i].style.display = "none";
                }

                var links = document.getElementsByClassName("vardump-link-" + id);
                for (var i = 0, l = links.length; i < l; i++) {
                    links[i].innerHTML = "[expand]";
                }

                document.body.style.cursor = "auto";

                return false;
            }

            function toggleVardump(id) {
                var block = document.getElementById("vardump-block-" + id);
                var link = document.getElementById("vardump-link-" + id);

                if (block.style.display == "block" ) {
                    block.style.display = "none";
                    link.innerHTML = "[expand]";
                } else {
                    block.style.display = "block";
                    link.innerHTML = "[reduce]";
                }

                return false;
            }
        </script>';
        }

        /**
         * @inheritdoc
         */
        public function beforeDump($trace)
        {
            $output = '<div style="' . $this->styles['container'] . '" dir=ltr>';
            $output .= '<div style="' . $this->styles['trace'] . '">' . htmlentities($trace) . '</div>' . "\n";
            $output .= '<div>';
            $output .= '<a style="' . $this->styles['link'] . '" href="#" onclick="return expandAllVardump(' . self::$printId . ');">[expand all]</a>';
            $output .= ' ';
            $output .= '<a style="' . $this->styles['link'] . '" href="#" onclick="return reduceAllVardump(' . self::$printId . ');">[reduce all]</a>';
            $output .= '</div>';

            return $output;
        }

        /**
         * @inheritdoc
         */
        public function afterDump()
        {
            self::$printId++;

            return '</div>';
        }

        /**
         * @inheritdoc
         */
        public function afterOutput()
        {
        }

        /**
         * @inheritdoc
         */
        public function formatValue($type, $short, $full = null, $showType = true, $encode = true)
        {
            $output = '';

            if ($showType && $type) {
                $output .= $type . ' ';
            }

            if ($encode) {
                $output .= '<code style="' . $this->styles['code'] . '">';
                $output .= htmlentities((string)$short);
                $output .= '</code>';
            } else {
                $output .= (string)$short;
            }

            if (strpos($type, '#')) {
                list($className, $id) = explode('#', $type);
            } else {
                $id = null;
            }

            if ($full && $full !== $short) {
                self::$elementId++;

                $this->anchors[$id] = self::$elementId;

                $output .= ' <a style="' . $this->styles['link'] . '" href="#" id="vardump-link-' . self::$elementId . '" class="vardump-link-' . self::$printId . '" onclick="return toggleVardump(' . self::$elementId . ');">[expand]</a> ';
                $output .= '<a name="vardump-anchor-' . self::$elementId . '"></a>';
                $output .= '<div style="' . $this->styles['expand-block'] . '" id="vardump-block-' . self::$elementId . '" class="vardump-block-' . self::$printId . '">';
                if (substr($full, 0, 3) == '<ul') {
                    $output .= $full;
                } else {
                    $output .= '<div style="' . $this->styles['expand-string'] . '">' . $full . '</div>';
                }
                $output .= '</div>';
            } elseif ($id && isset($this->anchors[$id])) {
                $output .= ' <a style="' . $this->styles['link'] . '" href="#" onclick="return gotoVardump(' . $this->anchors[$id] . ');">[goto]</a> ';
            }

            return $output;
        }

        /**
         * @inheritdoc
         */
        public function formatListItem($key, $value = null)
        {
            return '<li class="' . $this->styles['list-item'] . '">' . $key . ($value !== null ? ' => ' . $value : '') . '</li>';
        }

        /**
         * @inheritdoc
         */
        public function formatListItems(array $items)
        {
            return '<ul style="' . $this->styles['list'] . '">' . implode('', $items) . '</ul>';
        }
    }

    /**
     * Black HTML dump theme
     */
    class BlackHtmlVarDumpTheme extends HtmlVarDumpTheme
    {
        /**
         * BlackHtmlVarDumpTheme constructor.
         */
        public function __construct()
        {
            $this->colors = [
                'general-background' => 'black',
                'general-text'       => 'gold',
                'general-link'       => 'lightgray',
                'general-border'     => 'black',
                'code-background'    => 'black',
                'code-text'          => 'yellow',
            ];

            parent::__construct();
        }
    }

    /**
     * Green HTML dump theme
     */
    class GreenHtmlVarDumpTheme extends HtmlVarDumpTheme
    {
        /**
         * GreenHtmlVarDumpTheme constructor.
         */
        public function __construct()
        {
            $this->colors = [
                'general-background' => 'honeydew',
                'general-text'       => 'green',
                'general-link'       => 'darkgreen',
                'general-border'     => 'green',
                'code-background'    => 'white',
                'code-text'          => 'purple',
            ];

            parent::__construct();
        }
    }

    /**
     * Red HTML dump theme
     */
    class RedHtmlVarDumpTheme extends HtmlVarDumpTheme
    {
        /**
         * RedHtmlVarDumpTheme constructor.
         */
        public function __construct()
        {
            $this->colors = [
                'general-background' => 'snow',
                'general-text'       => 'red',
                'general-link'       => 'darkred',
                'general-border'     => 'red',
                'code-background'    => 'ivory',
                'code-text'          => 'darkred',
            ];

            parent::__construct();
        }
    }

    /**
     * Blue HTML dump theme
     */
    class BlueHtmlVarDumpTheme extends HtmlVarDumpTheme
    {
        /**
         * BlueHtmlVarDumpTheme constructor.
         */
        public function __construct()
        {
            $this->colors = [
                'general-background' => 'aliceblue',
                'general-text'       => 'blue',
                'general-link'       => 'blue',
                'general-border'     => 'blue',
                'code-background'    => 'LightYellow',
                'code-text'          => 'red',
            ];

            parent::__construct();
        }
    }
}
